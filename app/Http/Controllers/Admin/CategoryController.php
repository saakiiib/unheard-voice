<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::with('parent')
                ->select(['id', 'name', 'slug', 'image', 'parent_id', 'sort_order', 'is_active'])
                ->orderBy('sort_order');

            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    if ($row->is_active) {
                        return '<a href="' . route('category.show', $row->slug) . '" target="_blank">' . $row->name . '</a>';
                    }
                    return $row->name;
                })
                ->addColumn('image', function ($row) {
                    $src = $row->image ? asset($row->image) : asset('placeholder.webp');
                    return '<img src="' . $src . '" class="img-thumbnail" style="width:55px;height:55px;object-fit:cover;">';
                })
                ->addColumn('parent_category', function ($row) {
                    return $row->parent
                        ? '<span class="badge bg-info-subtle text-info">' . $row->parent->name . '</span>'
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
                            <button class="btn btn-soft-secondary btn-sm"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item edit-btn"
                                            data-id="' . $row->id . '"
                                            data-url="' . route('category.edit', $row->id) . '">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn"
                                            data-delete-url="' . route('category.delete', $row->id) . '"
                                            data-method="DELETE"
                                            data-table="#categoryTable">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'parent_category', 'status', 'action', 'name'])
                ->make(true);
        }

        $categories = Category::orderBy('sort_order')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255|unique:categories,name',
            'parent_id'        => 'nullable|exists:categories,id',
            'description'      => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string|max:255',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = 'placeholder.webp';

        if ($request->hasFile('image')) {
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/categories/');

            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }

            Image::make($request->file('image'))
                ->resize(800, null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $imagePath = '/uploads/categories/' . $filename;
        }

        $metaImagePath = null;
        if ($request->hasFile('meta_image')) {
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/categories/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);
            Image::make($request->file('meta_image'))
                ->resize(1200, null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                })
                ->encode('webp', 80)
                ->save($destPath . $filename);
            $metaImagePath = '/uploads/categories/' . $filename;
        }

        Category::create([
            'parent_id'        => $request->parent_id ?: null,
            'name'             => $request->name,
            'slug'             => Str::slug($request->name),
            'image'            => $imagePath,
            'description'      => $request->description,
            'sort_order'       => Category::max('sort_order') + 1,
            'is_active'        => true,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'meta_image'       => $metaImagePath
        ]);

        return response()->json(['success' => true, 'message' => 'Category created successfully.']);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json(['success' => true, 'data' => $category]);
    }

    public function update(Request $request)
    {
        $category = Category::findOrFail($request->id);

        $request->validate([
            'name'             => 'required|string|max:255|unique:categories,name,' . $category->id,
            'parent_id'        => 'nullable|exists:categories,id',
            'description'      => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            @unlink(public_path(ltrim($category->image, '/')));

            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/categories/');

            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }

            Image::make($request->file('image'))
                ->resize(800, null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                })
                ->encode('webp', 80)
                ->save($destPath . $filename);

            $category->image = '/uploads/categories/' . $filename;
        }

        if ($request->hasFile('meta_image')) {
            if ($category->meta_image) @unlink(public_path(ltrim($category->meta_image, '/')));
            $filename = mt_rand(10000000, 99999999) . '.webp';
            $destPath = public_path('uploads/categories/');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);
            Image::make($request->file('meta_image'))
                ->resize(1200, null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                })
                ->encode('webp', 80)
                ->save($destPath . $filename);
            $category->meta_image = '/uploads/categories/' . $filename;
        }

        $category->parent_id        = $request->parent_id ?: null;
        $category->name             = $request->name;
        $category->slug             = Str::slug($request->name);
        $category->description      = $request->description;
        $category->meta_title       = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords    = $request->meta_keywords;
        $category->save();

        return response()->json(['success' => true, 'message' => 'Category updated successfully.']);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->children()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete. This category has sub-categories. Please delete them first.'
            ], 422);
        }

        if (
            $category->image &&
            $category->image !== 'placeholder.webp' &&
            file_exists(public_path($category->image))
        ) {
            @unlink(public_path($category->image));
        }

        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->update(['is_active' => !$category->is_active]);

        return response()->json([
            'success' => true,
            'status'  => $category->is_active,
            'message' => 'Status updated successfully.',
        ]);
    }

    public function parents()
    {
        $parents = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name']);

        return response()->json($parents);
    }

    public function list()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'parent_id']);

        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Category::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Category order updated successfully!']);
    }
}