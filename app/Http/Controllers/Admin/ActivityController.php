<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $activities = Activity::with('category')
                ->select(['id', 'title', 'slug', 'image', 'category_id', 'location', 'activity_date', 'sort_order', 'is_active'])
                ->orderBy('sort_order');

            return DataTables::of($activities)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $src = $row->image ? asset($row->image) : asset('placeholder.webp');
                    return '<img src="' . $src . '" class="img-thumbnail" style="width:55px;height:55px;object-fit:cover;">';
                })
                ->addColumn('category', function ($row) {
                    return $row->category
                        ? '<span class="badge bg-success-subtle text-success">' . $row->category->name . '</span>'
                        : '<span class="text-muted">—</span>';
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
                                    <button class="dropdown-item edit-btn" data-id="' . $row->id . '" data-url="' . route('activity.edit', $row->id) . '">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn" data-delete-url="' . route('activity.delete', $row->id) . '" data-method="DELETE" data-table="#activityTable">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'category', 'status', 'action'])
                ->make(true);
        }

        $activities = Activity::orderBy('sort_order')->get();
        return view('admin.activities.index', compact('activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'location'         => 'nullable|string|max:255',
            'activity_date'    => 'nullable|date',
            'body'             => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $imagePath = 'placeholder.webp';
        if ($request->hasFile('image')) {
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/activities/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('image'))
                ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $imagePath = '/uploads/activities/' . $filename;
        }

        $metaImagePath = null;
        if ($request->hasFile('meta_image')) {
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/activities/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('meta_image'))
                ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);
            $metaImagePath = '/uploads/activities/' . $filename;
        }

        Activity::create([
            'category_id'      => $request->category_id ?: null,
            'title'            => $request->title,
            'slug'             => $this->generateUniqueSlug($request->title),
            'location'         => $request->location,
            'activity_date'    => $request->activity_date,
            'body'             => $request->body,
            'image'            => $imagePath,
            'sort_order'       => Activity::max('sort_order') + 1,
            'is_active'        => true,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'meta_image'       => $metaImagePath
        ]);

        return response()->json(['success' => true, 'message' => 'Activity created successfully.']);
    }

    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->formatted_date = $activity->activity_date ? \Carbon\Carbon::parse($activity->activity_date)->format('Y-m-d\TH:i') : '';
        return response()->json(['success' => true, 'data' => $activity]);
    }

    public function update(Request $request)
    {
        $activity = Activity::findOrFail($request->id);

        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'location'         => 'nullable|string|max:255',
            'activity_date'    => 'nullable|date',
            'body'             => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($activity->image && $activity->image !== 'placeholder.webp' && file_exists(public_path($activity->image))) {
                @unlink(public_path($activity->image));
            }
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/activities/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('image'))
                ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $activity->image = '/uploads/activities/' . $filename;
        }

        if ($request->hasFile('meta_image')) {
            if ($activity->meta_image && file_exists(public_path($activity->meta_image))) {
                @unlink(public_path($activity->meta_image));
            }
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/activities/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('meta_image'))
                ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);
            $activity->meta_image = '/uploads/activities/' . $filename;
        }

        $activity->category_id      = $request->category_id ?: null;
        $activity->slug             = $this->generateUniqueSlug($request->title, $activity->id);
        $activity->title            = $request->title;
        $activity->location         = $request->location;
        $activity->activity_date    = $request->activity_date;
        $activity->body             = $request->body;
        $activity->meta_title       = $request->meta_title;
        $activity->meta_description = $request->meta_description;
        $activity->meta_keywords    = $request->meta_keywords;
        $activity->save();

        return response()->json(['success' => true, 'message' => 'Activity updated successfully.']);
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Activity::when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . str_pad($counter, 3, '0', STR_PAD_LEFT);
            $counter++;
        }

        return $slug;
    }

    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        if ($activity->image && $activity->image !== 'placeholder.webp' && file_exists(public_path($activity->image))) {
            @unlink(public_path($activity->image));
        }
        if ($activity->meta_image && file_exists(public_path($activity->meta_image))) {
            @unlink(public_path($activity->meta_image));
        }
        $activity->delete();
        return response()->json(['success' => true, 'message' => 'Activity deleted successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        $activity = Activity::findOrFail($request->id);
        $activity->update(['is_active' => !$activity->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Activity::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Activity order updated successfully!']);
    }
}