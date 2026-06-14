<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $testimonials = Testimonial::select(['id', 'name', 'designation', 'review', 'sort_order', 'is_active'])->orderBy('sort_order');

            return DataTables::of($testimonials)
                ->addIndexColumn()
                ->addColumn('review', function ($row) {
                    return strlen($row->review) > 60 ? substr($row->review, 0, 60) . '...' : $row->review;
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
                                    <button class="dropdown-item edit-btn" data-id="' . $row->id . '" data-url="' . route('testimonial.edit', $row->id) . '">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn" data-delete-url="' . route('testimonial.delete', $row->id) . '" data-method="DELETE" data-table="#testimonialTable">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'review' => 'required|string',
        ]);

        Testimonial::create([
            'name'        => $request->name,
            'designation' => $request->designation,
            'review'      => $request->review,
            'sort_order'  => Testimonial::max('sort_order') + 1,
            'is_active'   => true,
        ]);

        return response()->json(['success' => true, 'message' => 'Testimonial added successfully.']);
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return response()->json(['success' => true, 'data' => $testimonial]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'review' => 'required|string',
        ]);

        $testimonial = Testimonial::findOrFail($request->id);
        $testimonial->update([
            'name'        => $request->name,
            'designation' => $request->designation,
            'review'      => $request->review,
        ]);

        return response()->json(['success' => true, 'message' => 'Testimonial updated successfully.']);
    }

    public function destroy($id)
    {
        Testimonial::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Testimonial deleted successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        $testimonial = Testimonial::findOrFail($request->id);
        $testimonial->update(['is_active' => !$testimonial->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Testimonial::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }
}