@extends('admin.pages.master')
@section('title', 'Programs')

@section('content')

    <div class="container-fluid mb-3" id="newBtnSection">
        <button class="btn btn-primary" id="newBtn">
            <i class="ri-add-line me-1"></i> Add New Program
        </button>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1" id="cardTitle">Add New Program</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="programId">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Program Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" placeholder="e.g. Mental Health Workshops">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Subtitle / Tag</label>
                                <input type="text" class="form-control" id="subtitle" placeholder="e.g. Workshop, Community">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Short Description</label>
                                <textarea class="form-control" id="short_description" rows="3" placeholder="Enter short intro description..."></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Long Description (Details)</label>
                                <textarea class="form-control summernote" id="long_description"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Program Image</label>
                                <input type="file" class="form-control" id="image" accept="image/*" onchange="previewImage(event, '#imagePreview')">
                                <img id="imagePreview" src="{{ asset('placeholder.webp') }}" class="img-thumbnail mt-2" style="max-width:200px; display:block;">
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

    <div class="container-fluid" id="contentContainer">
        <ul class="nav nav-tabs mb-3" id="programTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab">Programs List</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sort-tab" data-bs-toggle="tab" data-bs-target="#sort" type="button" role="tab">Sort Programs</button>
            </li>
        </ul>

        <div class="tab-content" id="programTabContent">
            <div class="tab-pane fade show active" id="list" role="tabpanel">
                <div class="card">
                    <div class="card-header"><h4 class="card-title mb-0">All Programs</h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="programTable" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
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
                        <h4 class="card-title mb-0">Sort Programs (Drag & Drop)</h4>
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
                                    @foreach ($programs as $index => $program)
                                        <tr data-id="{{ $program->id }}" style="cursor:grab;">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $program->title }}</td>
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
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('#programTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: '{{ route('program.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'subtitle', name: 'subtitle' },
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
                        url: '{{ route('program.updateOrder') }}',
                        method: 'POST',
                        data: { order: order },
                        success: function(res) {
                            showSuccess(res.message);
                            $('#sortable tr').each(function(index) {
                                $(this).find('td:first').text(index + 1);
                            });
                            reloadTable('#programTable');
                        }
                    });
                }
            });

            $('#newBtn').on('click', function() {
                clearForm();
                $('#cardTitle').text('Add New Program');
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
                var id = $('#programId').val();
                var url = id ? '{{ route('program.update') }}' : '{{ route('program.store') }}';

                var formData = new FormData();
                formData.append('title', $('#title').val());
                formData.append('subtitle', $('#subtitle').val());
                formData.append('short_description', $('#short_description').val());
                formData.append('long_description', $('#long_description').val());
                if (id) formData.append('id', id);

                var imageFile = document.getElementById('image').files[0];
                if (imageFile) formData.append('image', imageFile);

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
                            reloadTable('#programTable');
                            reload(1000);
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
                        $('#programId').val(d.id);
                        $('#title').val(d.title);
                        $('#subtitle').val(d.subtitle);
                        $('#short_description').val(d.short_description);
                        
                        $('.summernote').summernote('code', d.long_description ?? '');
                        
                        $('#imagePreview').attr('src', d.image ? d.image : '/placeholder.webp');
                        $('#cardTitle').text('Edit Program');
                        $('#addThisFormContainer').slideDown(300);
                        $('#newBtn').hide();
                        pageTop();
                    }
                });
            });

            $(document).on('change', '.toggle-status', function() {
                var id = $(this).data('id');
                $.post('{{ route('program.toggleStatus') }}', { id: id }, function(res) {
                    reloadTable('#programTable');
                    showSuccess(res.message);
                });
            });

            function clearForm() {
                $('#programId').val('');
                $('#title').val('');
                $('#subtitle').val('');
                $('#short_description').val('');
                $('.summernote').summernote('code', '');
                $('#image').val('');
                $('#imagePreview').attr('src', '/placeholder.webp');
            }
        });
    </script>
@endsection