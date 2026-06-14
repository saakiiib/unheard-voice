<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class EventController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $events = Event::with('category')
                ->select(['id', 'title', 'slug', 'image', 'category_id', 'location', 'event_date', 'sort_order', 'is_active'])
                ->orderBy('sort_order');

            return DataTables::of($events)
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
                ->addColumn('event_date', function ($row) {
                    return $row->event_date ? $row->event_date->format('Y-m-d H:i') : '—';
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
                                    <button class="dropdown-item edit-btn" data-id="' . $row->id . '" data-url="' . route('event.edit', $row->id) . '">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn" data-delete-url="' . route('event.delete', $row->id) . '" data-method="DELETE" data-table="#eventTable">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'category', 'status', 'action'])
                ->make(true);
        }

        $events = Event::orderBy('sort_order')->get();
        return view('admin.events.index', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'location'         => 'nullable|string|max:255',
            'event_date'       => 'nullable|date',
            'body'             => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $imagePath = 'placeholder.webp';
        if ($request->hasFile('image')) {
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/events/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('image'))
                ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $imagePath = '/uploads/events/' . $filename;
        }

        $metaImagePath = null;
        if ($request->hasFile('meta_image')) {
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/events/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('meta_image'))
                ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);
            $metaImagePath = '/uploads/events/' . $filename;
        }

        Event::create([
            'category_id'      => $request->category_id ?: null,
            'title'            => $request->title,
            'slug'             => Str::slug($request->title) . '-' . time(),
            'location'         => $request->location,
            'event_date'       => $request->event_date,
            'body'             => $request->body,
            'image'            => $imagePath,
            'sort_order'       => Event::max('sort_order') + 1,
            'is_active'        => true,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'meta_image'       => $metaImagePath
        ]);

        return response()->json(['success' => true, 'message' => 'Event created successfully.']);
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $event->formatted_date = $event->event_date ? $event->event_date->format('Y-m-dT' . 'H:i') : '';
        return response()->json(['success' => true, 'data' => $event]);
    }

    public function update(Request $request)
    {
        $event = Event::findOrFail($request->id);

        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'location'         => 'nullable|string|max:255',
            'event_date'       => 'nullable|date',
            'body'             => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image && $event->image !== 'placeholder.webp' && file_exists(public_path($event->image))) {
                @unlink(public_path($event->image));
            }
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/events/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('image'))
                ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $event->image = '/uploads/events/' . $filename;
        }

        if ($request->hasFile('meta_image')) {
            if ($event->meta_image && file_exists(public_path($event->meta_image))) {
                @unlink(public_path($event->meta_image));
            }
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/events/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('meta_image'))
                ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);
            $event->meta_image = '/uploads/events/' . $filename;
        }

        $event->category_id      = $request->category_id ?: null;
        $event->title            = $request->title;
        $event->slug             = Str::slug($request->title) . '-' . $event->id;
        $event->location         = $request->location;
        $event->event_date       = $request->event_date;
        $event->body             = $request->body;
        $event->meta_title       = $request->meta_title;
        $event->meta_description = $request->meta_description;
        $event->meta_keywords    = $request->meta_keywords;
        $event->save();

        return response()->json(['success' => true, 'message' => 'Event updated successfully.']);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if ($event->image && $event->image !== 'placeholder.webp' && file_exists(public_path($event->image))) {
            @unlink(public_path($event->image));
        }
        if ($event->meta_image && file_exists(public_path($event->meta_image))) {
            @unlink(public_path($event->meta_image));
        }
        $event->delete();
        return response()->json(['success' => true, 'message' => 'Event deleted successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        $event = Event::findOrFail($request->id);
        $event->update(['is_active' => !$event->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Event::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Event order updated successfully!']);
    }
}