<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $programs = Program::select(['id', 'title', 'subtitle', 'image', 'sort_order', 'is_active'])->orderBy('sort_order');

            return DataTables::of($programs)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $src = $row->image ? asset($row->image) : asset('placeholder.webp');
                    return '<img src="' . $src . '" class="img-thumbnail" style="width:60px;height:60px;object-fit:cover;">';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    return '
                        <div class="form-check form-switch" dir="ltr">
                            <input type="checkbox" class="form-check-input toggle-status"
                                id="status' . $row->id . '"
                                data-id="' . $row->id . '" ' . $checked . '>
                            <label class="form-check-label" for="status' . $row->id . '"></label>
                        </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item edit-btn" data-id="' . $row->id . '" data-url="' . route('program.edit', $row->id) . '">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn" data-delete-url="' . route('program.delete', $row->id) . '" data-method="DELETE" data-table="#programTable">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        $programs = Program::orderBy('sort_order')->get();
        return view('admin.programs.index', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = 'placeholder.webp';
        if ($request->hasFile('image')) {
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/programs/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('image'))
                ->resize(800, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $imagePath = '/uploads/programs/' . $filename;
        }

        Program::create([
            'title'             => $request->title,
            'subtitle'          => $request->subtitle,
            'slug'              => Str::slug($request->title) . '-' . time(),
            'short_description' => $request->short_description,
            'long_description'  => $request->long_description,
            'image'             => $imagePath,
            'sort_order'        => Program::max('sort_order') + 1,
            'is_active'         => true,
        ]);

        return response()->json(['success' => true, 'message' => 'Program created successfully.']);
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return response()->json(['success' => true, 'data' => $program]);
    }

    public function update(Request $request)
    {
        $program = Program::findOrFail($request->id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($program->image && $program->image !== 'placeholder.webp' && file_exists(public_path($program->image))) {
                @unlink(public_path($program->image));
            }
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/programs/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('image'))
                ->resize(800, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $program->image = '/uploads/programs/' . $filename;
        }

        $program->title             = $request->title;
        $program->subtitle          = $request->subtitle;
        $program->short_description = $request->short_description;
        $program->long_description  = $request->long_description;
        $program->save();

        return response()->json(['success' => true, 'message' => 'Program updated successfully.']);
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        if ($program->image && $program->image !== 'placeholder.webp' && file_exists(public_path($program->image))) {
            @unlink(public_path($program->image));
        }
        $program->delete();
        return response()->json(['success' => true, 'message' => 'Program deleted successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        $program = Program::findOrFail($request->id);
        $program->update(['is_active' => !$program->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Program::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }
}