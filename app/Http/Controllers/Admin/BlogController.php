<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $blogs = Blog::with('category')
                ->select(['id', 'title', 'slug', 'image', 'category_id', 'author_name', 'read_time', 'sort_order', 'is_active'])
                ->orderBy('sort_order');

            return DataTables::of($blogs)
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
                                    <button class="dropdown-item edit-btn" data-id="' . $row->id . '" data-url="' . route('blog.edit', $row->id) . '">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn" data-delete-url="' . route('blog.delete', $row->id) . '" data-method="DELETE" data-table="#blogTable">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'category', 'status', 'action'])
                ->make(true);
        }

        $blogs = Blog::orderBy('sort_order')->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'author_name'      => 'required|string|max:255',
            'read_time'        => 'nullable|string|max:50',
            'body'             => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $imagePath = 'placeholder.webp';
        if ($request->hasFile('image')) {
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/blogs/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('image'))
                ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $imagePath = '/uploads/blogs/' . $filename;
        }

        $metaImagePath = null;
        if ($request->hasFile('meta_image')) {
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/blogs/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('meta_image'))
                ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);
            $metaImagePath = '/uploads/blogs/' . $filename;
        }

        Blog::create([
            'category_id'      => $request->category_id ?: null,
            'title'            => $request->title,
            'slug'             => Str::slug($request->title) . '-' . time(),
            'author_name'      => $request->author_name,
            'read_time'        => $request->read_time,
            'body'             => $request->body,
            'image'            => $imagePath,
            'sort_order'       => Blog::max('sort_order') + 1,
            'is_active'        => true,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'meta_image'       => $metaImagePath
        ]);

        return response()->json(['success' => true, 'message' => 'Blog created successfully.']);
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json(['success' => true, 'data' => $blog]);
    }

    public function update(Request $request)
    {
        $blog = Blog::findOrFail($request->id);

        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'author_name'      => 'required|string|max:255',
            'read_time'        => 'nullable|string|max:50',
            'body'             => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image && $blog->image !== 'placeholder.webp' && file_exists(public_path($blog->image))) {
                @unlink(public_path($blog->image));
            }
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/blogs/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('image'))
                ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $blog->image = '/uploads/blogs/' . $filename;
        }

        if ($request->hasFile('meta_image')) {
            if ($blog->meta_image && file_exists(public_path($blog->meta_image))) {
                @unlink(public_path($blog->meta_image));
            }
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/blogs/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            Image::make($request->file('meta_image'))
                ->resize(1200, null, function ($c) { $c->aspectRatio(); $c->upsize(); })
                ->encode('webp', 80)
                ->save($destPath . $filename);
            $blog->meta_image = '/uploads/blogs/' . $filename;
        }

        $blog->category_id      = $request->category_id ?: null;
        $blog->title            = $request->title;
        $blog->slug             = Str::slug($request->title) . '-' . $blog->id;
        $blog->author_name      = $request->author_name;
        $blog->read_time        = $request->read_time;
        $blog->body             = $request->body;
        $blog->meta_title       = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->meta_keywords    = $request->meta_keywords;
        $blog->save();

        return response()->json(['success' => true, 'message' => 'Blog updated successfully.']);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->image && $blog->image !== 'placeholder.webp' && file_exists(public_path($blog->image))) {
            @unlink(public_path($blog->image));
        }
        if ($blog->meta_image && file_exists(public_path($blog->meta_image))) {
            @unlink(public_path($blog->meta_image));
        }
        $blog->delete();
        return response()->json(['success' => true, 'message' => 'Blog deleted successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        $blog = Blog::findOrFail($request->id);
        $blog->update(['is_active' => !$blog->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Blog::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Blog order updated successfully!']);
    }
}