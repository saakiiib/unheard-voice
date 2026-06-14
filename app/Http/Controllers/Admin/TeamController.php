<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $teams = Team::select(['id', 'name', 'position', 'type', 'image', 'sort_order', 'is_active'])->orderBy('sort_order');

            return DataTables::of($teams)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $src = $row->image ? asset($row->image) : asset('placeholder.webp');
                    return '<img src="' . $src . '" class="img-thumbnail rounded-circle" style="width:50px;height:50px;object-fit:cover;">';
                })
                ->addColumn('type', function ($row) {
                    $badge = $row->type === 'Leadership' ? 'bg-primary' : 'bg-info';
                    return '<span class="badge ' . $badge . '">' . $row->type . '</span>';
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
                                    <button class="dropdown-item edit-btn" data-id="' . $row->id . '" data-url="' . route('team.edit', $row->id) . '">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn" data-delete-url="' . route('team.delete', $row->id) . '" data-method="DELETE" data-table="#teamTable">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'type', 'status', 'action'])
                ->make(true);
        }

        $teams = Team::orderBy('sort_order')->get();
        return view('admin.teams.index', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'type'     => 'required|in:Leadership,Advisors',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = 'placeholder.webp';
        if ($request->hasFile('image')) {
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/teams/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            // Square size aspect ratio for professional avatars
            Image::make($request->file('image'))
                ->fit(500, 500, function ($c) { $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $imagePath = '/uploads/teams/' . $filename;
        }

        Team::create([
            'type'        => $request->type,
            'name'        => $request->name,
            'position'    => $request->position,
            'description' => $request->description,
            'image'       => $imagePath,
            'sort_order'  => Team::max('sort_order') + 1,
            'is_active'   => true,
        ]);

        return response()->json(['success' => true, 'message' => 'Team member added successfully.']);
    }

    public function edit($id)
    {
        $team = Team::findOrFail($id);
        return response()->json(['success' => true, 'data' => $team]);
    }

    public function update(Request $request)
    {
        $team = Team::findOrFail($request->id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'type'     => 'required|in:Leadership,Advisors',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($team->image && $team->image !== 'placeholder.webp' && file_exists(public_path($team->image))) {
                @unlink(public_path($team->image));
            }
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/teams/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('image'))
                ->fit(500, 500, function ($c) { $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $team->image = '/uploads/teams/' . $filename;
        }

        $team->type        = $request->type;
        $team->name        = $request->name;
        $team->position    = $request->position;
        $team->description = $request->description;
        $team->save();

        return response()->json(['success' => true, 'message' => 'Team member updated successfully.']);
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        if ($team->image && $team->image !== 'placeholder.webp' && file_exists(public_path($team->image))) {
            @unlink(public_path($team->image));
        }
        $team->delete();
        return response()->json(['success' => true, 'message' => 'Team member removed successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        $team = Team::findOrFail($request->id);
        $team->update(['is_active' => !$team->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Team::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }
}