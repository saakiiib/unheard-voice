@extends('admin.pages.master')
@section('title', 'Activities')

@section('content')

    <div class="container-fluid mb-3" id="newBtnSection">
        <button class="btn btn-primary" id="newBtn">
            <i class="ri-add-line me-1"></i> Add New Activity
        </button>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1" id="cardTitle">Add New Activity</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="activityId">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Activity Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" placeholder="Enter activity title">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Category 
                                    <span id="quickAddCatBtn" class="badge bg-primary ms-1 cursor-pointer" style="cursor: pointer;" title="Quick Add Category">
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
                                <label class="form-label">Activity Location</label>
                                <input type="text" class="form-control" id="location" placeholder="e.g. Dhaka, Bangladesh">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Activity Date & Time</label>
                                <input type="datetime-local" class="form-control" id="activity_date">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Activity Details</label>
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

    {{-- MEDIA MANAGER --}}
    <div class="container-fluid" id="mediaManagerContainer" style="display:none;">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">
                    <i class="ri-image-2-line me-1"></i>
                    Manage Media — <span id="mediaActivityTitle" class="text-primary"></span>
                </h4>
                <button class="btn btn-sm btn-light" id="closeMediaManager">
                    <i class="ri-close-line"></i> Close
                </button>
            </div>
            <div class="card-body">
                <input type="hidden" id="activeActivityId">

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="mb-3"><i class="ri-image-add-line me-1 text-primary"></i> Upload Images</h6>
                            <input type="file" class="form-control mb-2" id="bulkImages" accept="image/*" multiple>
                            <button class="btn btn-primary btn-sm w-100" id="bulkUploadBtn">
                                <i class="ri-upload-2-line me-1"></i> Upload Selected Images
                            </button>
                            <div class="progress mt-2" id="uploadProgress" style="display:none;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="mb-3"><i class="ri-video-add-line me-1 text-success"></i> Upload Videos</h6>
                            <input type="file" class="form-control mb-2" id="bulkVideos" accept="video/*" multiple>
                            <button class="btn btn-success btn-sm w-100" id="bulkVideoUploadBtn">
                                <i class="ri-upload-2-line me-1"></i> Upload Selected Videos
                            </button>
                            <div class="progress mt-2" id="videoUploadProgress" style="display:none;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="mb-3"><i class="ri-youtube-line me-1 text-danger"></i> Add YouTube Video</h6>
                            <input type="text" class="form-control mb-2" id="youtubeUrl" placeholder="https://www.youtube.com/watch?v=...">
                            <button class="btn btn-danger btn-sm w-100" id="addYoutubeBtn">
                                <i class="ri-add-line me-1"></i> Add Video
                            </button>
                        </div>
                    </div>
                </div>

                <div id="mediaGrid" class="row g-2">
                    <div class="col-12 text-center text-muted py-4" id="mediaEmpty">
                        <i class="ri-image-line fs-1"></i>
                        <p class="mt-2">No media yet. Upload images, videos, or add a YouTube video.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="contentContainer">
        <ul class="nav nav-tabs mb-3" id="activityTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab">Activities List</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sort-tab" data-bs-toggle="tab" data-bs-target="#sort" type="button" role="tab">Sort Activities</button>
            </li>
        </ul>

        <div class="tab-content" id="activityTabContent">
            <div class="tab-pane fade show active" id="list" role="tabpanel">
                <div class="card">
                    <div class="card-header"><h4 class="card-title mb-0">All Activities</h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="activityTable" class="table table-bordered table-striped" style="width: 100%">
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

            <div class="tab-pane fade" id="sort" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Sort Activities</h4>
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
                                    @foreach ($activities as $index => $activity)
                                        <tr data-id="{{ $activity->id }}" style="cursor:grab;">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $activity->title }}</td>
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

    <div class="modal fade" id="quickCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="quickCatName" placeholder="e.g. Social Work, Campaign">
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

            $('#activityTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: '{{ route('activity.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'category', name: 'category', orderable: false, searchable: false },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            $('#sortable').sortable({
                placeholder: 'ui-state-highlight',
                cursor: 'grab',
                update: function(event, ui) {
                    var order = $(this).sortable('toArray', { attribute: 'data-id' });
                    $.ajax({
                        url: '{{ route('activity.updateOrder') }}',
                        method: 'POST',
                        data: { order: order },
                        success: function(res) {
                            showSuccess(res.message);
                            $('#sortable tr').each(function(index) {
                                $(this).find('td:first').text(index + 1);
                            });
                            reloadTable('#activityTable');
                        }
                    });
                }
            });

            function loadCategories(selectedId = null) {
                $.get('{{ route('category.list') }}', function(res) {
                    if(res.success) {
                        var dropdown = $('#category_id');
                        dropdown.empty().append('<option value="">— Select Category —</option>');
                        $.each(res.data, function(i, cat) {
                            var selected = (selectedId && cat.id == selectedId) ? 'selected' : '';
                            dropdown.append('<option value="' + cat.id + '" ' + selected + '>' + cat.name + '</option>');
                        });
                        dropdown.trigger('change');
                    }
                });
            }

            loadCategories();

            $(document).on('click', '#quickAddCatBtn', function() {
                $('#quickCatName').val('');
                $('#quickCategoryModal').modal('show');
            });

            $('#quickCatSaveBtn').on('click', function() {
                var catName = $('#quickCatName').val().trim();
                if (!catName) {
                    showError('Category name is required!');
                    return;
                }

                showLoader();

                var formData = new FormData();
                formData.append('name', catName);

                $.ajax({
                    url: '{{ route('category.store') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.success) {
                            showSuccess('Category added successfully!');
                            $('#quickCategoryModal').modal('hide');
                            
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
                        if (xhr.status === 422) {
                            var firstErr = Object.values(xhr.responseJSON.errors)[0][0];
                            showError(firstErr);
                        } else {
                            showError('Failed to create category.');
                        }
                    }
                });
            });

            $('#newBtn').on('click', function() {
                clearForm();
                loadCategories();
                $('#cardTitle').text('Add New Activity');
                $('#addThisFormContainer').slideDown(300);
                $('#newBtn').hide();
                pageTop();
            });

            $('#cancelBtn').on('click', function() {
                $('#addThisFormContainer').slideUp(200);
                $('#newBtn').show();
                clearForm();
            });

            $('#saveBtn').on('click', function() {
                var id = $('#activityId').val();
                var url = id ? '{{ route('activity.update') }}' : '{{ route('activity.store') }}';

                var formData = new FormData();
                formData.append('title', $('#title').val());
                formData.append('category_id', $('#category_id').val());
                formData.append('location', $('#location').val());
                formData.append('activity_date', $('#activity_date').val());
                formData.append('body', $('#body').val());
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
                        if (res.success) {
                            showSuccess(res.message);
                            $('#addThisFormContainer').slideUp(200);
                            $('#newBtn').show();
                            clearForm();
                            reloadTable('#activityTable');
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

            $(document).on('click', '.edit-btn', function() {
                var url = $(this).data('url');
                showLoader();
                $.get(url, function(res) {
                    if (res.success) {
                        var d = res.data;
                        loadCategories(d.category_id);
                        $('#activityId').val(d.id);
                        $('#title').val(d.title);
                        $('#location').val(d.location);
                        $('#activity_date').val(d.formatted_date);
                        
                        $('.summernote').summernote('code', d.body ?? '');
                        
                        $('#meta_title').val(d.meta_title);
                        $('#meta_description').val(d.meta_description);
                        $('#meta_keywords').val(d.meta_keywords);
                        $('#imagePreview').attr('src', d.image ? d.image : '/placeholder.webp');
                        $('#metaImagePreview').attr('src', d.meta_image ? d.meta_image : '/placeholder.webp');
                        $('#cardTitle').text('Edit Activity');
                        $('#addThisFormContainer').slideDown(300);
                        $('#newBtn').hide();
                        pageTop();
                    }
                });
            });

            $(document).on('change', '.toggle-status', function() {
                var id = $(this).data('id');
                $.post('{{ route('activity.toggleStatus') }}', { id: id }, function(res) {
                    reloadTable('#activityTable');
                    showSuccess(res.message);
                });
            });

            function clearForm() {
                $('#activityId').val('');
                $('#title').val('');
                $('.summernote').summernote('code', '');
                $('#image').val('');
                $('#meta_title').val('');
                $('#meta_description').val('');
                $('#meta_keywords').val('');
                $('#meta_image').val('');
                $('#category_id').val('').trigger('change');
                $('#location').val('');
                $('#activity_date').val('');
                $('#imagePreview').attr('src', '/placeholder.webp');
                $('#metaImagePreview').attr('src', '/placeholder.webp');
            }

            // ── MANAGE MEDIA ──
            $(document).on('click', '.manage-btn', function() {
                var id = $(this).data('id');
                var title = $(this).data('title');
                var url = $(this).data('url');

                $('#activeActivityId').val(id);
                $('#mediaActivityTitle').text(title);
                $('#addThisFormContainer').slideUp(200);
                $('#newBtn').show();
                $('#mediaManagerContainer').slideDown(300);
                pageTop();
                loadMedia(url);
            });

            $('#closeMediaManager').on('click', function() {
                $('#mediaManagerContainer').slideUp(200);
                reloadTable('#activityTable');
            });

            function loadMedia(url) {
                $.get(url, function(res) {
                    if (res.success) renderMediaGrid(res.data);
                });
            }

            function renderMediaGrid(items) {
                var grid = $('#mediaGrid');
                grid.empty();

                if (!items.length) {
                    grid.html('<div class="col-12 text-center text-muted py-4"><i class="ri-image-line fs-1"></i><p class="mt-2">No media yet.</p></div>');
                    return;
                }

                $.each(items, function(i, m) {
                    var card = '';
                    if (m.type === 'image') {
                        card = '<div class="col-6 col-md-3 col-lg-2 media-item" data-id="' + m.id + '">' +
                            '<div class="position-relative border rounded overflow-hidden" style="aspect-ratio:1;">' +
                            '<img src="' + m.file + '" class="w-100 h-100" style="object-fit:cover;">' +
                            '<button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-media-btn" data-id="' + m.id + '" style="padding:2px 6px;">' +
                            '<i class="ri-delete-bin-line"></i></button></div></div>';
                    } else if (m.type === 'video') {
                        card = '<div class="col-6 col-md-3 col-lg-2 media-item" data-id="' + m.id + '">' +
                            '<div class="position-relative border rounded overflow-hidden" style="aspect-ratio:1;">' +
                            '<video src="' + m.file + '" class="w-100 h-100" style="object-fit:cover;" controls></video>' +
                            '<span class="position-absolute top-0 start-0 m-1 badge bg-success"><i class="ri-video-line"></i> Video</span>' +
                            '<button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-media-btn" data-id="' + m.id + '" style="padding:2px 6px;">' +
                            '<i class="ri-delete-bin-line"></i></button></div></div>';
                    } else {
                        var thumb = 'https://img.youtube.com/vi/' + m.youtube_id + '/hqdefault.jpg';
                        card = '<div class="col-6 col-md-3 col-lg-2 media-item" data-id="' + m.id + '">' +
                            '<div class="position-relative border rounded overflow-hidden" style="aspect-ratio:1;">' +
                            '<img src="' + thumb + '" class="w-100 h-100" style="object-fit:cover;">' +
                            '<span class="position-absolute top-0 start-0 m-1 badge bg-danger"><i class="ri-youtube-line"></i> YouTube</span>' +
                            '<button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-media-btn" data-id="' + m.id + '" style="padding:2px 6px;">' +
                            '<i class="ri-delete-bin-line"></i></button></div></div>';
                    }
                    grid.append(card);
                });

                grid.sortable({
                    items: '.media-item',
                    placeholder: 'col-6 col-md-3 col-lg-2',
                    cursor: 'grab',
                    update: function() {
                        var order = [];
                        grid.find('.media-item').each(function() {
                            order.push($(this).data('id'));
                        });
                        $.post('{{ route('activity.media.updateOrder') }}', { order: order }, function(res) {
                            showSuccess(res.message);
                        });
                    }
                });
            }

            // ── BULK IMAGE UPLOAD ──
            $('#bulkUploadBtn').on('click', function() {
                var activityId = $('#activeActivityId').val();
                var files = document.getElementById('bulkImages').files;

                if (!files.length) { showError('Please select at least one image.'); return; }
                if (!activityId) { showError('No activity selected.'); return; }

                var formData = new FormData();
                formData.append('activity_id', activityId);
                $.each(files, function(i, f) { formData.append('files[]', f); });

                $('#uploadProgress').show();
                showLoader();

                $.ajax({
                    url: '{{ route('activity.media.bulk') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.success) {
                            showSuccess(res.message);
                            $('#bulkImages').val('');
                            $('#uploadProgress').hide();
                            loadMedia('{{ url('admin/activities') }}/' + activityId + '/media');
                        }
                    },
                    error: function(xhr) {
                        $('#uploadProgress').hide();
                        if (xhr.status === 422) showError(Object.values(xhr.responseJSON.errors)[0][0]);
                        else showError('Upload failed.');
                    }
                });
            });

            // ── BULK VIDEO UPLOAD ──
            $('#bulkVideoUploadBtn').on('click', function() {
                var activityId = $('#activeActivityId').val();
                var files = document.getElementById('bulkVideos').files;

                if (!files.length) { showError('Please select at least one video.'); return; }
                if (!activityId) { showError('No activity selected.'); return; }

                var formData = new FormData();
                formData.append('activity_id', activityId);
                $.each(files, function(i, f) { formData.append('videos[]', f); });

                $('#videoUploadProgress').show();
                showLoader();

                $.ajax({
                    url: '{{ route('activity.media.videoBulk') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.success) {
                            showSuccess(res.message);
                            $('#bulkVideos').val('');
                            $('#videoUploadProgress').hide();
                            loadMedia('{{ url('admin/activities') }}/' + activityId + '/media');
                        }
                    },
                    error: function(xhr) {
                        $('#videoUploadProgress').hide();
                        if (xhr.status === 422) showError(Object.values(xhr.responseJSON.errors)[0][0]);
                        else showError('Upload failed.');
                    }
                });
            });

            // ── ADD YOUTUBE ──
            $('#addYoutubeBtn').on('click', function() {
                var activityId = $('#activeActivityId').val();
                var url = $('#youtubeUrl').val().trim();

                if (!url) { showError('Please enter a YouTube URL.'); return; }
                if (!activityId) { showError('No activity selected.'); return; }

                showLoader();
                $.ajax({
                    url: '{{ route('activity.media.youtube') }}',
                    method: 'POST',
                    data: { activity_id: activityId, youtube_url: url },
                    success: function(res) {
                        if (res.success) {
                            showSuccess(res.message);
                            $('#youtubeUrl').val('');
                            loadMedia('{{ url('admin/activities') }}/' + activityId + '/media');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) showError(Object.values(xhr.responseJSON.errors)[0][0]);
                        else showError('Failed to add video.');
                    }
                });
            });

            // ── DELETE MEDIA ──
            $(document).on('click', '.delete-media-btn', function() {
                var id = $(this).data('id');
                var item = $(this).closest('.media-item');

                if (!confirm('Delete this media?')) return;

                $.ajax({
                    url: '{{ url('admin/activities/media') }}/' + id,
                    method: 'DELETE',
                    success: function(res) {
                        if (res.success) {
                            item.remove();
                            showSuccess(res.message);
                            if ($('#mediaGrid .media-item').length === 0) {
                                $('#mediaGrid').html('<div class="col-12 text-center text-muted py-4"><i class="ri-image-line fs-1"></i><p class="mt-2">No media yet.</p></div>');
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection