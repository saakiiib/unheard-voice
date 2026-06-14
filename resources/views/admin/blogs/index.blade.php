@extends('admin.pages.master')
@section('title', 'Blogs')

@section('content')

    {{-- ── Top Button ── --}}
    <div class="container-fluid mb-3" id="newBtnSection">
        <button class="btn btn-primary" id="newBtn">
            <i class="ri-add-line me-1"></i> Add New Blog
        </button>
    </div>

    {{-- ── Add / Edit Form ── --}}
    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1" id="cardTitle">Add New Blog</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="blogId">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Blog Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" placeholder="Enter blog title">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Category <span
                                    id="quickAddCatBtn" class="badge bg-primary ms-1 cursor-pointer"
                                    title="Quick Add Category">
                                    + Add New
                                </span>
                                </label>
                                <div class="input-group">
                                    <select class="form-control select2" id="category_id">
                                        <option value="">— Select Category —</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Author Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="author_name" value="Admin" placeholder="Author name">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Reading Time</label>
                                <input type="text" class="form-control" id="read_time" placeholder="e.g. 5 mins">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Blog Content</label>
                                <textarea class="form-control summernote" id="body"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Featured Image</label>
                                <input type="file" class="form-control" id="image" accept="image/*" onchange="previewImage(event, '#imagePreview')">
                                <img id="imagePreview" src="{{ asset('placeholder.webp') }}" class="img-thumbnail mt-2" style="max-width:200px; display:block;">
                            </div>

                            <div class="col-12 mt-2">
                                <h6 class="text-muted border-bottom pb-1">SEO / Meta</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Meta Title</label>
                                <input type="text" class="form-control" id="meta_title" placeholder="Meta title">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" placeholder="Keywords">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" rows="2" placeholder="Meta description"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Meta Image</label>
                                <input type="file" class="form-control" id="meta_image" accept="image/*" onchange="previewImage(event, '#metaImagePreview')">
                                <img id="metaImagePreview" src="{{ asset('placeholder.webp') }}" class="img-thumbnail mt-2" style="max-width:200px; display:block;">
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-primary" id="saveBtn"><i class="ri-save-line me-1"></i> Save</button>
                        <button class="btn btn-light ms-1" id="cancelBtn">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Tabs + Table ── --}}
    <div class="container-fluid" id="contentContainer">
        <ul class="nav nav-tabs mb-3" id="blogTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab">Blogs List</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sort-tab" data-bs-toggle="tab" data-bs-target="#sort" type="button" role="tab">Sort Blogs</button>
            </li>
        </ul>

        <div class="tab-content" id="blogTabContent">
            {{-- List Tab --}}
            <div class="tab-pane fade show active" id="list" role="tabpanel">
                <div class="card">
                    <div class="card-header"><h4 class="card-title mb-0">All Blogs</h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="blogTable" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sort Tab --}}
            <div class="tab-pane fade" id="sort" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Sort Blogs</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:80px;">Sl</th>
                                        <th>Title</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($blogs as $index => $blog)
                                        <tr data-id="{{ $blog->id }}" style="cursor:grab;">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $blog->title }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ── QUICK ADD CATEGORY MODAL ── --}}
    <div class="modal fade" id="quickCategoryModal" static data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="quickCatName" placeholder="e.g. Technology, Health">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="quickCatSaveBtn">Save Category</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            // ── DataTable ─────────────────────────────────────────────────────────
            $('#blogTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: '{{ route('blog.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'category', name: 'category', orderable: false, searchable: false },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            // ── Sortable (Drag & Drop) ────────────────────────────────────────────
            $('#sortable').sortable({
                placeholder: 'ui-state-highlight',
                cursor: 'grab',
                update: function(event, ui) {
                    var order = $(this).sortable('toArray', { attribute: 'data-id' });
                    $.ajax({
                        url: '{{ route('blog.updateOrder') }}',
                        method: 'POST',
                        data: { order: order },
                        success: function(res) {
                            showSuccess(res.message);
                            $('#sortable tr').each(function(index) {
                                $(this).find('td:first').text(index + 1);
                            });
                            reloadTable('#blogTable');
                        }
                    });
                }
            });

            // ── Load Categories into Select2 ──────────────────────────────────────
            function loadCategories(selectedId = null) {
                $.get('{{ route('category.list') }}', function(res) {
                    if(res.success) {
                        var dropdown = $('#category_id');
                        dropdown.empty().append('<option value="">— Select Category —</option>');
                        $.each(res.data, function(i, cat) {
                            var selected = (selectedId && cat.id == selectedId) ? 'selected' : '';
                            dropdown.append('<option value="' + cat.id + '" ' + selected + '>' + cat.name + '</option>');
                        });
                        dropdown.trigger('change'); // select2 আপডেট করার জন্য trigger
                    }
                });
            }

            // Initial Category Load
            loadCategories();

            // ── Quick Add Category Modal Open ──────────────────────────────────────
            $('#quickAddCatBtn').on('click', function() {
                $('#quickCatName').val('');
                $('#quickCategoryModal').modal('show');
            });

            // ── Quick Add Category Save ───────────────────────────────────────────
            $('#quickCatSaveBtn').on('click', function() {
                var catName = $('#quickCatName').val().trim();
                if (!catName) {
                    showError('Category name is required!');
                    return;
                }

                // আপনার গ্লোবাল loader চালুর জন্য
                showLoader();

                var formData = new FormData();
                formData.append('name', catName); // category.store রুট অনুযায়ী শুধু Name পাস করা হচ্ছে

                $.ajax({
                    url: '{{ route('category.store') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        hideLoader();
                        if (res.success) {
                            showSuccess('Category added successfully!');
                            $('#quickCategoryModal').modal('hide');
                            
                            // সব ক্যাটাগরি পুনরায় লোড করবে এবং নতুন তৈরি হওয়া ক্যাটাগরিটি অটোমেটিক সিলেক্ট হবে
                            // যেহেতু ক্যাটাগরি কন্ট্রোলার জাস্ট রেসপন্স ব্যাক করে, আমরা ক্যাটাগরি লিস্ট রিফ্রেশ করে সিলেক্ট করে নিচ্ছি।
                            $.get('{{ route('category.list') }}', function(listRes) {
                                if(listRes.success) {
                                    var dropdown = $('#category_id');
                                    dropdown.empty().append('<option value="">— Select Category —</option>');
                                    var newCatId = null;
                                    
                                    $.each(listRes.data, function(i, cat) {
                                        if (cat.name.toLowerCase() === catName.toLowerCase()) {
                                            newCatId = cat.id;
                                        }
                                        dropdown.append('<option value="' + cat.id + '">' + cat.name + '</option>');
                                    });
                                    
                                    if(newCatId) {
                                        dropdown.val(newCatId).trigger('change');
                                    } else {
                                        loadCategories();
                                    }
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        hideLoader();
                        if (xhr.status === 422) {
                            var firstErr = Object.values(xhr.responseJSON.errors)[0][0];
                            showError(firstErr);
                        } else {
                            showError('Failed to create category.');
                        }
                    }
                });
            });

            // ── Form Open/Close ───────────────────────────────────────────────────
            $('#newBtn').on('click', function() {
                clearForm();
                loadCategories();
                $('#cardTitle').text('Add New Blog');
                $('#addThisFormContainer').slideDown(300);
                $('#newBtn').hide();
                pageTop();
            });

            $('#cancelBtn').on('click', function() {
                $('#addThisFormContainer').slideUp(200);
                $('#newBtn').show();
                clearForm();
            });

            // ── Save/Update Blog ──────────────────────────────────────────────────
            $('#saveBtn').on('click', function() {
                var id = $('#blogId').val();
                var url = id ? '{{ route('blog.update') }}' : '{{ route('blog.store') }}';

                var formData = new FormData();
                formData.append('title', $('#title').val());
                formData.append('category_id', $('#category_id').val());
                formData.append('author_name', $('#author_name').val());
                formData.append('read_time', $('#read_time').val());
                formData.append('body', $('#body').val()); // Summernote এর ভ্যালু অটোমেটিক সিঙ্ক হয়ে যায়
                formData.append('meta_title', $('#meta_title').val());
                formData.append('meta_description', $('#meta_description').val());
                formData.append('meta_keywords', $('#meta_keywords').val());
                if (id) formData.append('id', id);

                var imageFile = document.getElementById('image').files[0];
                if (imageFile) formData.append('image', imageFile);

                var metaImageFile = document.getElementById('meta_image').files[0];
                if (metaImageFile) formData.append('meta_image', metaImageFile);

                showLoader();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        hideLoader();
                        if (res.success) {
                            showSuccess(res.message);
                            $('#addThisFormContainer').slideUp(200);
                            $('#newBtn').show();
                            clearForm();
                            reloadTable('#blogTable');
                            reload(1000); // Sortable লিস্টের ডাটা সিনক্রোনাইজড রাখার জন্য গ্লোবাল রিলোড কল
                        }
                    },
                    error: function(xhr) {
                        hideLoader();
                        if (xhr.status === 422) {
                            var first = Object.values(xhr.responseJSON.errors)[0][0];
                            showError(first);
                        } else {
                            showError(xhr.responseJSON?.message ?? 'Something went wrong.');
                        }
                    }
                });
            });

            // ── Edit Blog ─────────────────────────────────────────────────────────
            $(document).on('click', '.edit-btn', function() {
                var url = $(this).data('url');
                showLoader();
                $.get(url, function(res) {
                    hideLoader();
                    if (res.success) {
                        var d = res.data;
                        loadCategories(d.category_id);
                        $('#blogId').val(d.id);
                        $('#title').val(d.title);
                        $('#author_name').val(d.author_name);
                        $('#read_time').val(d.read_time);
                        
                        // Summernote এ ডাটা পুশ করা
                        $('.summernote').summernote('code', d.body ?? '');
                        
                        $('#meta_title').val(d.meta_title);
                        $('#meta_description').val(d.meta_description);
                        $('#meta_keywords').val(d.meta_keywords);
                        $('#imagePreview').attr('src', d.image ? d.image : '/placeholder.webp');
                        $('#metaImagePreview').attr('src', d.meta_image ? d.meta_image : '/placeholder.webp');
                        $('#cardTitle').text('Edit Blog');
                        $('#addThisFormContainer').slideDown(300);
                        $('#newBtn').hide();
                        pageTop();
                    }
                });
            });

            // ── Toggle Status ─────────────────────────────────────────────────────
            $(document).on('change', '.toggle-status', function() {
                var id = $(this).data('id');
                $.post('{{ route('blog.toggleStatus') }}', { id: id }, function(res) {
                    reloadTable('#blogTable');
                    showSuccess(res.message);
                });
            });

            // ── Clear Form ────────────────────────────────────────────────────────
            function clearForm() {
                $('#blogId').val('');
                $('#title').val('');
                $('.summernote').summernote('code', ''); // Summernote ক্লিয়ার করা
                $('#image').val('');
                $('#meta_title').val('');
                $('#meta_description').val('');
                $('#meta_keywords').val('');
                $('#meta_image').val('');
                $('#category_id').val('').trigger('change');
                $('#author_name').val('Admin');
                $('#read_time').val('');
                $('#imagePreview').attr('src', '/placeholder.webp');
                $('#metaImagePreview').attr('src', '/placeholder.webp');
            }
        });
    </script>
@endsection