<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sliders = Slider::select(['id', 'title', 'eyebrow_text', 'image', 'sort_order', 'is_active'])->orderBy('sort_order');

            return DataTables::of($sliders)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $src = $row->image ? asset($row->image) : asset('placeholder.webp');
                    return '<img src="' . $src . '" class="img-thumbnail" style="width:100px;height:55px;object-fit:cover;">';
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
                                    <button class="dropdown-item edit-btn" data-id="' . $row->id . '" data-url="' . route('slider.edit', $row->id) . '">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn" data-delete-url="' . route('slider.delete', $row->id) . '" data-method="DELETE" data-table="#sliderTable">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        $sliders = Slider::orderBy('sort_order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        $imagePath = 'placeholder.webp';
        if ($request->hasFile('image')) {
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/sliders/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('image'))
                ->resize(1920, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $imagePath = '/uploads/sliders/' . $filename;
        }

        Slider::create([
            'eyebrow_text' => $request->eyebrow_text,
            'title'        => $request->title,
            'description'  => $request->description,
            'btn1_text'    => $request->btn1_text,
            'btn1_url'     => $request->btn1_url,
            'btn2_text'    => $request->btn2_text,
            'btn2_url'     => $request->btn2_url,
            'image'        => $imagePath,
            'sort_order'   => Slider::max('sort_order') + 1,
            'is_active'    => true,
        ]);

        return response()->json(['success' => true, 'message' => 'Slider created successfully.']);
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return response()->json(['success' => true, 'data' => $slider]);
    }

    public function update(Request $request)
    {
        $slider = Slider::findOrFail($request->id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image && $slider->image !== 'placeholder.webp' && file_exists(public_path($slider->image))) {
                @unlink(public_path($slider->image));
            }
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/sliders/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('image'))
                ->resize(1920, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $slider->image = '/uploads/sliders/' . $filename;
        }

        $slider->eyebrow_text = $request->eyebrow_text;
        $slider->title        = $request->title;
        $slider->description  = $request->description;
        $slider->btn1_text    = $request->btn1_text;
        $slider->btn1_url     = $request->btn1_url;
        $slider->btn2_text    = $request->btn2_text;
        $slider->btn2_url     = $request->btn2_url;
        $slider->save();

        return response()->json(['success' => true, 'message' => 'Slider updated successfully.']);
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        if ($slider->image && $slider->image !== 'placeholder.webp' && file_exists(public_path($slider->image))) {
            @unlink(public_path($slider->image));
        }
        $slider->delete();
        return response()->json(['success' => true, 'message' => 'Slider deleted successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        $slider = Slider::findOrFail($request->id);
        $slider->update(['is_active' => !$slider->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Slider::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Slider order updated successfully!']);
    }
}