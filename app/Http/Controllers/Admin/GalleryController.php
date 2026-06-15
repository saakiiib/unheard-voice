<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $galleries = Gallery::select(['id', 'title', 'cover_image', 'sort_order', 'is_active'])
                ->withCount(['media as photo_count' => fn($q) => $q->where('type', 'image')])
                ->withCount(['media as video_count' => fn($q) => $q->where('type', 'youtube')])
                ->orderBy('sort_order');

            return DataTables::of($galleries)
                ->addIndexColumn()
                ->addColumn('cover_image', function ($row) {
                    $src = $row->cover_image ? asset($row->cover_image) : asset('placeholder.webp');
                    return '<img src="' . $src . '" class="img-thumbnail" style="width:55px;height:55px;object-fit:cover;">';
                })
                ->addColumn('media_count', function ($row) {
                    return '<span class="badge bg-info-subtle text-info me-1">' . $row->photo_count . ' Photos</span>
                            <span class="badge bg-warning-subtle text-warning">' . $row->video_count . ' Videos</span>';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    return '
                        <div class="form-check form-switch" dir="ltr">
                            <input type="checkbox" class="form-check-input toggle-status"
                                id="status' . $row->id . '" data-id="' . $row->id . '" ' . $checked . '>
                            <label class="form-check-label" for="status' . $row->id . '"></label>
                        </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item manage-btn"
                                        data-id="' . $row->id . '"
                                        data-title="' . e($row->title) . '"
                                        data-url="' . route('gallery.media.list', $row->id) . '">
                                        <i class="ri-image-2-line align-bottom me-2 text-muted"></i> Manage Media
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item edit-btn" data-id="' . $row->id . '" data-url="' . route('gallery.edit', $row->id) . '">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn"
                                        data-delete-url="' . route('gallery.delete', $row->id) . '"
                                        data-method="DELETE"
                                        data-table="#galleryTable">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['cover_image', 'media_count', 'status', 'action'])
                ->make(true);
        }

        $galleries = Gallery::orderBy('sort_order')->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $coverPath = 'placeholder.webp';
        if ($request->hasFile('cover_image')) {
            $coverPath = $this->uploadImage($request->file('cover_image'));
        }

        $gallery = Gallery::create([
            'title'       => $request->title,
            'slug'        => $this->generateUniqueSlug($request->title),
            'description' => $request->description,
            'cover_image' => $coverPath,
            'sort_order'  => Gallery::max('sort_order') + 1,
            'is_active'   => true,
        ]);

        return response()->json(['success' => true, 'message' => 'Album created successfully.', 'id' => $gallery->id]);
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return response()->json(['success' => true, 'data' => $gallery]);
    }

    public function update(Request $request)
    {
        $gallery = Gallery::findOrFail($request->id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($gallery->cover_image && $gallery->cover_image !== 'placeholder.webp' && file_exists(public_path($gallery->cover_image))) {
                @unlink(public_path($gallery->cover_image));
            }
            $gallery->cover_image = $this->uploadImage($request->file('cover_image'));
        }

        if ($gallery->title !== $request->title) {
            $gallery->slug = $this->generateUniqueSlug($request->title, $gallery->id);
        }

        $gallery->title       = $request->title;
        $gallery->description = $request->description;
        $gallery->save();

        return response()->json(['success' => true, 'message' => 'Album updated successfully.']);
    }

    public function destroy($id)
    {
        $gallery = Gallery::with('media')->findOrFail($id);

        foreach ($gallery->media as $media) {
            if ($media->type === 'image' && $media->file && file_exists(public_path($media->file))) {
                @unlink(public_path($media->file));
            }
        }

        if ($gallery->cover_image && $gallery->cover_image !== 'placeholder.webp' && file_exists(public_path($gallery->cover_image))) {
            @unlink(public_path($gallery->cover_image));
        }

        $gallery->delete();
        return response()->json(['success' => true, 'message' => 'Album deleted successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        $gallery = Gallery::findOrFail($request->id);
        $gallery->update(['is_active' => !$gallery->is_active]);
        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Gallery::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }

    // ── MEDIA ──

    public function mediaList($galleryId)
    {
        $media = GalleryMedia::where('gallery_id', $galleryId)->orderBy('sort_order')->get()
            ->map(function ($m) {
                return [
                    'id'           => $m->id,
                    'type'         => $m->type,
                    'file'         => $m->file ? asset($m->file) : null,
                    'youtube_url'  => $m->youtube_url,
                    'youtube_id'   => $m->youtube_id,
                    'sort_order'   => $m->sort_order,
                ];
            });

        return response()->json(['success' => true, 'data' => $media]);
    }

    public function mediaBulkStore(Request $request)
    {
        $request->validate([
            'gallery_id' => 'required|exists:galleries,id',
            'files.*'    => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $maxOrder = GalleryMedia::where('gallery_id', $request->gallery_id)->max('sort_order') ?? 0;

        foreach ($request->file('files', []) as $file) {
            $maxOrder++;
            GalleryMedia::create([
                'gallery_id' => $request->gallery_id,
                'type'       => 'image',
                'file'       => $this->uploadImage($file),
                'sort_order' => $maxOrder,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Images uploaded successfully.']);
    }

    public function mediaYoutubeStore(Request $request)
    {
        $request->validate([
            'gallery_id'  => 'required|exists:galleries,id',
            'youtube_url' => 'required|url',
        ]);

        GalleryMedia::create([
            'gallery_id'  => $request->gallery_id,
            'type'        => 'youtube',
            'youtube_url' => $request->youtube_url,
            'sort_order'  => GalleryMedia::where('gallery_id', $request->gallery_id)->max('sort_order') + 1,
        ]);

        return response()->json(['success' => true, 'message' => 'YouTube video added successfully.']);
    }

    public function mediaDestroy($id)
    {
        $media = GalleryMedia::findOrFail($id);
        if ($media->type === 'image' && $media->file && file_exists(public_path($media->file))) {
            @unlink(public_path($media->file));
        }
        $media->delete();
        return response()->json(['success' => true, 'message' => 'Media deleted successfully.']);
    }

    public function mediaUpdateOrder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            GalleryMedia::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Media order updated!']);
    }

    // ── HELPERS ──

    private function uploadImage($file): string
    {
        $filename = mt_rand(10000000, 99999999) . '.webp';
        $destPath = public_path('uploads/galleries/');
        if (!file_exists($destPath)) mkdir($destPath, 0755, true);

        Image::make($file)
            ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
            ->encode('webp', 80)
            ->save($destPath . $filename);

        return '/uploads/galleries/' . $filename;
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug     = $baseSlug;
        $counter  = 1;

        while (
            Gallery::when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)->exists()
        ) {
            $slug = $baseSlug . '-' . str_pad($counter, 3, '0', STR_PAD_LEFT);
            $counter++;
        }

        return $slug;
    }
}