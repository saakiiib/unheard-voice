@extends('admin.pages.master')
@section('title', 'Testimonials')

@section('content')

    <div class="container-fluid mb-3" id="newBtnSection">
        <button class="btn btn-primary" id="newBtn">
            <i class="ri-add-line me-1"></i> Add New Testimonial
        </button>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1" id="cardTitle">Add New Testimonial</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="testimonialId">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Person Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="e.g. Sarah Jenkins">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Designation / Role</label>
                                <input type="text" class="form-control" id="designation" placeholder="e.g. Service User, Community Volunteer">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Review / Statement <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="review" rows="5" placeholder="Enter review statement here..."></textarea>
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
        <ul class="nav nav-tabs mb-3" id="testimonialTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab">Testimonials List</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sort-tab" data-bs-toggle="tab" data-bs-target="#sort" type="button" role="tab">Sort Testimonials</button>
            </li>
        </ul>

        <div class="tab-content" id="testimonialTabContent">
            <div class="tab-pane fade show active" id="list" role="tabpanel">
                <div class="card">
                    <div class="card-header"><h4 class="card-title mb-0">All Testimonials</h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="testimonialTable" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Review Snippet</th>
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
                        <h4 class="card-title mb-0">Sort Order (Drag & Drop)</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:80px;">Sl</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($testimonials as $index => $item)
                                        <tr data-id="{{ $item->id }}" style="cursor:grab;">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->designation ?? '—' }}</td>
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

            $('#testimonialTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: '{{ route('testimonial.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'designation', name: 'designation' },
                    { data: 'review', name: 'review', orderable: false },
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
                        url: '{{ route('testimonial.updateOrder') }}',
                        method: 'POST',
                        data: { order: order },
                        success: function(res) {
                            showSuccess(res.message);
                            $('#sortable tr').each(function(index) {
                                $(this).find('td:first').text(index + 1);
                            });
                            reloadTable('#testimonialTable');
                        }
                    });
                }
            });

            $('#newBtn').on('click', function() {
                clearForm();
                $('#cardTitle').text('Add New Testimonial');
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
                var id = $('#testimonialId').val();
                var url = id ? '{{ route('testimonial.update') }}' : '{{ route('testimonial.store') }}';

                var formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('designation', $('#designation').val());
                formData.append('review', $('#review').val());
                if (id) formData.append('id', id);

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
                            reloadTable('#testimonialTable');
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
                        $('#testimonialId').val(d.id);
                        $('#name').val(d.name);
                        $('#designation').val(d.designation);
                        $('#review').val(d.review);
                        
                        $('#cardTitle').text('Edit Testimonial');
                        $('#addThisFormContainer').slideDown(300);
                        $('#newBtn').hide();
                        pageTop();
                    }
                });
            });

            $(document).on('change', '.toggle-status', function() {
                var id = $(this).data('id');
                $.post('{{ route('testimonial.toggleStatus') }}', { id: id }, function(res) {
                    reloadTable('#testimonialTable');
                    showSuccess(res.message);
                });
            });

            function clearForm() {
                $('#testimonialId').val('');
                $('#name').val('');
                $('#designation').val('');
                $('#review').val('');
            }
        });
    </script>
@endsection