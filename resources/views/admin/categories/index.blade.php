@extends('admin.pages.master')
@section('title', 'Categories')

@section('content')

    {{-- ── Top Button ── --}}
    <div class="container-fluid mb-3" id="newBtnSection">
        <button class="btn btn-primary" id="newBtn">
            <i class="ri-add-line me-1"></i> Add New Category
        </button>
    </div>

    {{-- ── Add / Edit Form ── --}}
    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1" id="cardTitle">Add New Category</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="categoryId">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name"
                                    placeholder="e.g. National, International">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Parent Category <small
                                        class="text-muted">(optional)</small></label>
                                <select class="form-control" id="parent_id">
                                    <option value="">— Select Parent Category —</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" id="description" placeholder="Short description">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Category Image</label>
                                <input type="file" class="form-control" id="image" accept="image/*"
                                    onchange="previewImage(event, '#imagePreview')">
                                <img id="imagePreview" src="{{ asset('placeholder.webp') }}" class="img-thumbnail mt-2"
                                    style="max-width:200px; display:block;">
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
                                <input type="text" class="form-control" id="meta_keywords"
                                    placeholder="Comma separated keywords">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" rows="2" placeholder="Meta description"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Meta Image</label>
                                <input type="file" class="form-control" id="meta_image" accept="image/*"
                                    onchange="previewImage(event, '#metaImagePreview')">
                                <img id="metaImagePreview" src="{{ asset('placeholder.webp') }}" class="img-thumbnail mt-2"
                                    style="max-width:200px; display:block;">
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-primary" id="saveBtn">
                            <i class="ri-save-line me-1"></i> Save
                        </button>
                        <button class="btn btn-light ms-1" id="cancelBtn">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Tabs + Table ── --}}
    <div class="container-fluid" id="contentContainer">
        <ul class="nav nav-tabs mb-3" id="categoryTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button"
                    role="tab">Categories List</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sort-tab" data-bs-toggle="tab" data-bs-target="#sort" type="button"
                    role="tab">Sort Categories</button>
            </li>
        </ul>

        <div class="tab-content" id="categoryTabContent">

            {{-- List Tab --}}
            <div class="tab-pane fade show active" id="list" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">All Categories</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="categoryTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Category Name</th>
                                        <th>Parent Category</th>
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
                        <h4 class="card-title mb-0">Sort Categories</h4>
                        <small class="text-muted">Drag & drop rows to change order</small>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:80px;">Sl</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($categories as $index => $category)
                                        <tr data-id="{{ $category->id }}" style="cursor:grab;">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $category->name }}</td>
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

@endsection

@section('script')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ── DataTable ─────────────────────────────────────────────────────────
            $('#categoryTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: '{{ route('category.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'parent_category',
                        name: 'parent_category',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // ── Sortable ──────────────────────────────────────────────────────────
            $('#sortable').sortable({
                placeholder: 'ui-state-highlight',
                cursor: 'grab',
                forcePlaceholderSize: true,
                opacity: 0.8,
                update: function(event, ui) {
                    var order = $(this).sortable('toArray', {
                        attribute: 'data-id'
                    });
                    $.ajax({
                        url: '{{ route('category.updateOrder') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            order: order
                        },
                        success: function(res) {
                            showSuccess(res.message);
                            $('#sortable tr').each(function(index) {
                                $(this).find('td:first').text(index + 1);
                            });
                            reloadTable('#categoryTable');
                        },
                        error: function(xhr) {
                            showError(xhr.responseJSON?.message ?? 'Something went wrong!');
                        }
                    });
                }
            });

            // ── Load Parent Categories ────────────────────────────────────────────
            function loadParentCategories(selectedId) {
                $.get('{{ route('category.parents') }}', function(data) {
                    $('#parent_id').empty().append('<option value="">— Select Parent Category —</option>');
                    $.each(data, function(i, cat) {
                        var selected = (selectedId && cat.id == selectedId) ? 'selected' : '';
                        $('#parent_id').append('<option value="' + cat.id + '" ' + selected + '>' +
                            cat.name + '</option>');
                    });
                });
            }

            // ── Show / Hide Form ──────────────────────────────────────────────────
            $('#newBtn').on('click', function() {
                clearForm();
                loadParentCategories();
                $('#cardTitle').text('Add New Category');
                $('#addThisFormContainer').slideDown(300);
                $('#newBtn').hide();
            });

            $('#cancelBtn').on('click', function() {
                $('#addThisFormContainer').slideUp(200);
                $('#newBtn').show();
                clearForm();
            });

            // ── Save ──────────────────────────────────────────────────────────────
            $('#saveBtn').on('click', function() {
                var id = $('#categoryId').val();
                var url = id ? '{{ route('category.update') }}' : '{{ route('category.store') }}';

                var formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('parent_id', $('#parent_id').val());
                formData.append('description', $('#description').val());
                formData.append('meta_title', $('#meta_title').val());
                formData.append('meta_description', $('#meta_description').val());
                formData.append('meta_keywords', $('#meta_keywords').val());
                if (id) formData.append('id', id);

                var imageFile = document.getElementById('image').files[0];
                if (imageFile) formData.append('image', imageFile);

                var metaImageFile = document.getElementById('meta_image').files[0];
                if (metaImageFile) formData.append('meta_image', metaImageFile);

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.success) {
                            showSuccess(res.message);
                            $('#addThisFormContainer').slideUp(200);
                            $('#newBtn').show();
                            clearForm();
                            reloadTable('#categoryTable');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var first = Object.values(xhr.responseJSON.errors)[0][0];
                            showError(first);
                        } else {
                            showError(xhr.responseJSON?.message ?? 'Something went wrong.');
                        }
                    }
                });
            });

            // ── Edit ──────────────────────────────────────────────────────────────
            $(document).on('click', '.edit-btn', function() {
                var url = $(this).data('url');

                $.get(url, function(res) {
                    if (res.success) {
                        var d = res.data;
                        loadParentCategories(d.parent_id);
                        $('#categoryId').val(d.id);
                        $('#name').val(d.name);
                        $('#description').val(d.description);
                        $('#meta_title').val(d.meta_title);
                        $('#meta_description').val(d.meta_description);
                        $('#meta_keywords').val(d.meta_keywords);
                        $('#imagePreview').attr('src', d.image ? d.image : '/placeholder.webp');
                        $('#metaImagePreview').attr('src', d.meta_image ? d.meta_image :
                            '/placeholder.webp');
                        $('#cardTitle').text('Edit Category');
                        $('#addThisFormContainer').slideDown(300);
                        $('#newBtn').hide();
                        pagetop();
                    }
                });
            });

            // ── Toggle Status ─────────────────────────────────────────────────────
            $(document).on('change', '.toggle-status', function() {
                var id = $(this).data('id');
                var status = $(this).prop('checked') ? 1 : 0;
                $.post('{{ route('category.toggleStatus') }}', {
                    id: id,
                    status: status
                }, function(res) {
                    reloadTable('#categoryTable');
                    showSuccess(res.message);
                }).fail(function() {
                    showError('Failed to update status.');
                });
            });

            // ── Clear Form ────────────────────────────────────────────────────────
            function clearForm() {
                $('#categoryId').val('');
                $('#name').val('');
                $('#description').val('');
                $('#image').val('');
                $('#meta_title').val('');
                $('#meta_description').val('');
                $('#meta_keywords').val('');
                $('#meta_image').val('');
                $('#parent_id').val('');
                $('#imagePreview').attr('src', '/placeholder.webp');
                $('#metaImagePreview').attr('src', '/placeholder.webp');
            }

        });
    </script>
@endsection