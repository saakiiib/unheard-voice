@extends('admin.pages.master')
@section('title', 'Hero Sliders')

@section('content')

    <div class="container-fluid mb-3" id="newBtnSection">
        <button class="btn btn-primary" id="newBtn">
            <i class="ri-add-line me-1"></i> Add New Slide
        </button>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1" id="cardTitle">Add New Slide</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="sliderId">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Eyebrow Text</label>
                                <input type="text" class="form-control" id="eyebrow_text" placeholder="e.g. Safe spaces, stronger communities">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Slide Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" placeholder="Use <br> tag for line breaks & <span class='accent'></span> for accent color">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Description / Lead Text</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Enter slide description"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Button 1 (Teal Button) Text</label>
                                <input type="text" class="form-control" id="btn1_text" placeholder="e.g. Explore Programs">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Button 1 URL</label>
                                <input type="text" class="form-control" id="btn1_url" placeholder="e.g. programs.html">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Button 2 (Outline Button) Text</label>
                                <input type="text" class="form-control" id="btn2_text" placeholder="e.g. Upcoming Events">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Button 2 URL</label>
                                <input type="text" class="form-control" id="btn2_url" placeholder="e.g. events.html">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Slider Background Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="image" accept="image/*" onchange="previewImage(event, '#imagePreview')">
                                <img id="imagePreview" src="{{ asset('placeholder.webp') }}" class="img-thumbnail mt-2" style="max-width:300px; display:block;">
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
        <ul class="nav nav-tabs mb-3" id="sliderTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab">Slides List</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sort-tab" data-bs-toggle="tab" data-bs-target="#sort" type="button" role="tab">Sort Order</button>
            </li>
        </ul>

        <div class="tab-content" id="sliderTabContent">
            <div class="tab-pane fade show active" id="list" role="tabpanel">
                <div class="card">
                    <div class="card-header"><h4 class="card-title mb-0">All Sliders</h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="sliderTable" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Eyebrow Text</th>
                                        <th>Title</th>
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
                        <h4 class="card-title mb-0">Sort Slides (Drag & Drop)</h4>
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
                                    @foreach ($sliders as $index => $slider)
                                        <tr data-id="{{ $slider->id }}" style="cursor:grab;">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{!! $slider->title !!}</td>
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

            $('#sliderTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: '{{ route('slider.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'eyebrow_text', name: 'eyebrow_text' },
                    { data: 'title', name: 'title' },
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
                        url: '{{ route('slider.updateOrder') }}',
                        method: 'POST',
                        data: { order: order },
                        success: function(res) {
                            showSuccess(res.message);
                            $('#sortable tr').each(function(index) {
                                $(this).find('td:first').text(index + 1);
                            });
                            reloadTable('#sliderTable');
                        }
                    });
                }
            });

            $('#newBtn').on('click', function() {
                clearForm();
                $('#cardTitle').text('Add New Slide');
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
                var id = $('#sliderId').val();
                var url = id ? '{{ route('slider.update') }}' : '{{ route('slider.store') }}';

                var formData = new FormData();
                formData.append('eyebrow_text', $('#eyebrow_text').val());
                formData.append('title', $('#title').val());
                formData.append('description', $('#description').val());
                formData.append('btn1_text', $('#btn1_text').val());
                formData.append('btn1_url', $('#btn1_url').val());
                formData.append('btn2_text', $('#btn2_text').val());
                formData.append('btn2_url', $('#btn2_url').val());
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
                            reloadTable('#sliderTable');
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
                        $('#sliderId').val(d.id);
                        $('#eyebrow_text').val(d.eyebrow_text);
                        $('#title').val(d.title);
                        $('#description').val(d.description);
                        $('#btn1_text').val(d.btn1_text);
                        $('#btn1_url').val(d.btn1_url);
                        $('#btn2_text').val(d.btn2_text);
                        $('#btn2_url').val(d.btn2_url);
                        
                        $('#imagePreview').attr('src', d.image ? d.image : '/placeholder.webp');
                        $('#cardTitle').text('Edit Slide');
                        $('#addThisFormContainer').slideDown(300);
                        $('#newBtn').hide();
                        pageTop();
                    }
                });
            });

            $(document).on('change', '.toggle-status', function() {
                var id = $(this).data('id');
                $.post('{{ route('slider.toggleStatus') }}', { id: id }, function(res) {
                    reloadTable('#sliderTable');
                    showSuccess(res.message);
                });
            });

            function clearForm() {
                $('#sliderId').val('');
                $('#eyebrow_text').val('');
                $('#title').val('');
                $('#description').val('');
                $('#btn1_text').val('');
                $('#btn1_url').val('');
                $('#btn2_text').val('');
                $('#btn2_url').val('');
                $('#image').val('');
                $('#imagePreview').attr('src', '/placeholder.webp');
            }
        });
    </script>
@endsection