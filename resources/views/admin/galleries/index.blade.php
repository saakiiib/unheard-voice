@extends('admin.pages.master')
@section('title', 'Gallery')

@section('content')

    <div class="container-fluid mb-3" id="newBtnSection">
        <button class="btn btn-primary" id="newBtn">
            <i class="ri-add-line me-1"></i> Add New Album
        </button>
    </div>

    {{-- ADD / EDIT FORM --}}
    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title mb-0 flex-grow-1" id="cardTitle">Add New Album</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="galleryId">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Album Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" placeholder="Enter album title">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Short description (optional)"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Cover Image</label>
                                <input type="file" class="form-control" id="cover_image" accept="image/*"
                                    onchange="previewImage(event, '#coverPreview')">
                                <img id="coverPreview" src="{{ asset('placeholder.webp') }}" class="img-thumbnail mt-2"
                                    style="max-width:200px;display:block;">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-primary" id="saveBtn"><i class="ri-save-line me-1"></i> Save Album</button>
                        <button class="btn btn-light ms-1" id="cancelBtn">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MEDIA MANAGER (slide down on Manage click) --}}
    <div class="container-fluid" id="mediaManagerContainer" style="display:none;">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">
                    <i class="ri-image-2-line me-1"></i>
                    Manage Media — <span id="mediaAlbumTitle" class="text-primary"></span>
                </h4>
                <button class="btn btn-sm btn-light" id="closeMediaManager">
                    <i class="ri-close-line"></i> Close
                </button>
            </div>
            <div class="card-body">
                <input type="hidden" id="activeGalleryId">

                <div class="row g-3 mb-4">
                    {{-- Bulk Image Upload --}}
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="mb-3"><i class="ri-image-add-line me-1 text-primary"></i> Upload Images</h6>
                            <input type="file" class="form-control mb-2" id="bulkImages" accept="image/*" multiple>
                            <button class="btn btn-primary btn-sm w-100" id="bulkUploadBtn">
                                <i class="ri-upload-2-line me-1"></i> Upload Selected Images
                            </button>
                            <div class="progress mt-2" id="uploadProgress" style="display:none;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- YouTube Add --}}
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="mb-3"><i class="ri-youtube-line me-1 text-danger"></i> Add YouTube Video</h6>
                            <input type="text" class="form-control mb-2" id="youtubeUrl"
                                placeholder="https://www.youtube.com/watch?v=...">
                            <button class="btn btn-danger btn-sm w-100" id="addYoutubeBtn">
                                <i class="ri-add-line me-1"></i> Add Video
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Media Grid --}}
                <div id="mediaGrid" class="row g-2">
                    <div class="col-12 text-center text-muted py-4" id="mediaEmpty">
                        <i class="ri-image-line fs-1"></i>
                        <p class="mt-2">No media yet. Upload images or add a YouTube video.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- GALLERY TABLE --}}
    <div class="container-fluid" id="contentContainer">
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#listTab" type="button">Albums
                    List</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sortTab" type="button">Sort
                    Albums</button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="listTab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">All Albums</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="galleryTable" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Cover</th>
                                        <th>Title</th>
                                        <th>Media</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="sortTab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Sort Albums</h4>
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
                                    @foreach ($galleries as $index => $gallery)
                                        <tr data-id="{{ $gallery->id }}" style="cursor:grab;">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $gallery->title }}</td>
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

            // ── DATATABLE ──
            $('#galleryTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: '{{ route('gallery.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'cover_image',
                        name: 'cover_image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'media_count',
                        name: 'media_count',
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

            // ── SORT ──
            $('#sortable').sortable({
                placeholder: 'ui-state-highlight',
                cursor: 'grab',
                update: function() {
                    var order = $(this).sortable('toArray', {
                        attribute: 'data-id'
                    });
                    $.ajax({
                        url: '{{ route('gallery.updateOrder') }}',
                        method: 'POST',
                        data: {
                            order: order
                        },
                        success: function(res) {
                            showSuccess(res.message);
                            $('#sortable tr').each(function(i) {
                                $(this).find('td:first').text(i + 1);
                            });
                            reloadTable('#galleryTable');
                        }
                    });
                }
            });

            // ── ADD NEW ──
            $('#newBtn').on('click', function() {
                clearAlbumForm();
                $('#cardTitle').text('Add New Album');
                $('#mediaManagerContainer').slideUp(200);
                $('#addThisFormContainer').slideDown(300);
                $('#newBtn').hide();
                pageTop();
            });

            $('#cancelBtn').on('click', function() {
                $('#addThisFormContainer').slideUp(200);
                $('#newBtn').show();
                clearAlbumForm();
            });

            // ── SAVE ALBUM ──
            $('#saveBtn').on('click', function() {
                var id = $('#galleryId').val();
                var url = id ? '{{ route('gallery.update') }}' : '{{ route('gallery.store') }}';

                var formData = new FormData();
                formData.append('title', $('#title').val());
                formData.append('description', $('#description').val());
                if (id) formData.append('id', id);
                var coverFile = document.getElementById('cover_image').files[0];
                if (coverFile) formData.append('cover_image', coverFile);

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
                            clearAlbumForm();
                            reloadTable('#galleryTable');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) showError(Object.values(xhr.responseJSON
                            .errors)[0][0]);
                        else showError(xhr.responseJSON?.message ?? 'Something went wrong.');
                    }
                });
            });

            // ── EDIT ALBUM ──
            $(document).on('click', '.edit-btn', function() {
                var url = $(this).data('url');
                showLoader();
                $.get(url, function(res) {
                    if (res.success) {
                        var d = res.data;
                        $('#galleryId').val(d.id);
                        $('#title').val(d.title);
                        $('#description').val(d.description);
                        $('#coverPreview').attr('src', d.cover_image ? d.cover_image :
                            '/placeholder.webp');
                        $('#cardTitle').text('Edit Album');
                        $('#mediaManagerContainer').slideUp(200);
                        $('#addThisFormContainer').slideDown(300);
                        $('#newBtn').hide();
                        pageTop();
                    }
                });
            });

            // ── TOGGLE STATUS ──
            $(document).on('change', '.toggle-status', function() {
                var id = $(this).data('id');
                $.post('{{ route('gallery.toggleStatus') }}', {
                    id: id
                }, function(res) {
                    reloadTable('#galleryTable');
                    showSuccess(res.message);
                });
            });

            // ── MANAGE MEDIA ──
            $(document).on('click', '.manage-btn', function() {
                var id = $(this).data('id');
                var title = $(this).data('title');
                var url = $(this).data('url');

                $('#activeGalleryId').val(id);
                $('#mediaAlbumTitle').text(title);
                $('#addThisFormContainer').slideUp(200);
                $('#newBtn').show();
                $('#mediaManagerContainer').slideDown(300);
                pageTop();
                loadMedia(url);
            });

            $('#closeMediaManager').on('click', function() {
                $('#mediaManagerContainer').slideUp(200);
                reloadTable('#galleryTable');
            });

            // ── LOAD MEDIA ──
            function loadMedia(url) {
                $.get(url, function(res) {
                    if (res.success) renderMediaGrid(res.data);
                });
            }

            function renderMediaGrid(items) {
                var grid = $('#mediaGrid');
                grid.empty();

                if (!items.length) {
                    grid.html(
                        '<div class="col-12 text-center text-muted py-4"><i class="ri-image-line fs-1"></i><p class="mt-2">No media yet.</p></div>'
                        );
                    return;
                }

                $.each(items, function(i, m) {
                    var card = '';
                    if (m.type === 'image') {
                        card = '<div class="col-6 col-md-3 col-lg-2 media-item" data-id="' + m.id + '">' +
                            '<div class="position-relative border rounded overflow-hidden" style="aspect-ratio:1;">' +
                            '<img src="' + m.file + '" class="w-100 h-100" style="object-fit:cover;">' +
                            '<button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-media-btn" data-id="' +
                            m.id + '" style="padding:2px 6px;">' +
                            '<i class="ri-delete-bin-line"></i></button>' +
                            '</div></div>';
                    } else {
                        var thumb = 'https://img.youtube.com/vi/' + m.youtube_id + '/hqdefault.jpg';
                        card = '<div class="col-6 col-md-3 col-lg-2 media-item" data-id="' + m.id + '">' +
                            '<div class="position-relative border rounded overflow-hidden" style="aspect-ratio:1;">' +
                            '<img src="' + thumb + '" class="w-100 h-100" style="object-fit:cover;">' +
                            '<span class="position-absolute top-0 start-0 m-1 badge bg-danger"><i class="ri-youtube-line"></i> Video</span>' +
                            '<button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-media-btn" data-id="' +
                            m.id + '" style="padding:2px 6px;">' +
                            '<i class="ri-delete-bin-line"></i></button>' +
                            '</div></div>';
                    }
                    grid.append(card);
                });

                // sortable media
                grid.sortable({
                    items: '.media-item',
                    placeholder: 'col-6 col-md-3 col-lg-2',
                    cursor: 'grab',
                    update: function() {
                        var order = [];
                        grid.find('.media-item').each(function() {
                            order.push($(this).data('id'));
                        });
                        $.post('{{ route('gallery.media.updateOrder') }}', {
                            order: order
                        }, function(res) {
                            showSuccess(res.message);
                        });
                    }
                });
            }

            // ── BULK IMAGE UPLOAD ──
            $('#bulkUploadBtn').on('click', function() {
                var galleryId = $('#activeGalleryId').val();
                var files = document.getElementById('bulkImages').files;

                if (!files.length) {
                    showError('Please select at least one image.');
                    return;
                }
                if (!galleryId) {
                    showError('No album selected.');
                    return;
                }

                var formData = new FormData();
                formData.append('gallery_id', galleryId);
                $.each(files, function(i, f) {
                    formData.append('files[]', f);
                });

                $('#uploadProgress').show();
                showLoader();

                $.ajax({
                    url: '{{ route('gallery.media.bulk') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.success) {
                            showSuccess(res.message);
                            $('#bulkImages').val('');
                            $('#uploadProgress').hide();
                            loadMedia('{{ url('admin/galleries') }}/' + galleryId + '/media');
                        }
                    },
                    error: function(xhr) {
                        $('#uploadProgress').hide();
                        if (xhr.status === 422) showError(Object.values(xhr.responseJSON
                            .errors)[0][0]);
                        else showError('Upload failed.');
                    }
                });
            });

            // ── ADD YOUTUBE ──
            $('#addYoutubeBtn').on('click', function() {
                var galleryId = $('#activeGalleryId').val();
                var url = $('#youtubeUrl').val().trim();

                if (!url) {
                    showError('Please enter a YouTube URL.');
                    return;
                }
                if (!galleryId) {
                    showError('No album selected.');
                    return;
                }

                showLoader();
                $.ajax({
                    url: '{{ route('gallery.media.youtube') }}',
                    method: 'POST',
                    data: {
                        gallery_id: galleryId,
                        youtube_url: url
                    },
                    success: function(res) {
                        if (res.success) {
                            showSuccess(res.message);
                            $('#youtubeUrl').val('');
                            loadMedia('{{ url('admin/galleries') }}/' + galleryId + '/media');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) showError(Object.values(xhr.responseJSON
                            .errors)[0][0]);
                        else showError('Failed to add video.');
                    }
                });
            });

            // ── DELETE MEDIA ──
            $(document).on('click', '.delete-media-btn', function() {
                var id = $(this).data('id');
                var galleryId = $('#activeGalleryId').val();
                var item = $(this).closest('.media-item');

                if (!confirm('Delete this media?')) return;

                $.ajax({
                    url: '{{ url('admin/galleries/media') }}/' + id,
                    method: 'DELETE',
                    success: function(res) {
                        if (res.success) {
                            item.remove();
                            showSuccess(res.message);
                            if ($('#mediaGrid .media-item').length === 0) {
                                $('#mediaGrid').html(
                                    '<div class="col-12 text-center text-muted py-4"><i class="ri-image-line fs-1"></i><p class="mt-2">No media yet.</p></div>'
                                    );
                            }
                        }
                    }
                });
            });

            function clearAlbumForm() {
                $('#galleryId').val('');
                $('#title').val('');
                $('#description').val('');
                $('#cover_image').val('');
                $('#coverPreview').attr('src', '/placeholder.webp');
            }
        });
    </script>
@endsection