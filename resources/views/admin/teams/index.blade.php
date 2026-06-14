@extends('admin.pages.master')
@section('title', 'Team Members')

@section('content')

    <div class="container-fluid mb-3" id="newBtnSection">
        <button class="btn btn-primary" id="newBtn">
            <i class="ri-add-line me-1"></i> Add New Member
        </button>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1" id="cardTitle">Add New Member</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="teamId">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="e.g. Dr. John Doe">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Position / Role <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="position" placeholder="e.g. Executive Director">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Member Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="type">
                                    <option value="Leadership" selected>Leadership</option>
                                    <option value="Advisors">Advisors</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Short Bio / Description</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Enter short bio of the member..."></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Profile Image (Preferred Square 1:1)</label>
                                <input type="file" class="form-control" id="image" accept="image/*" onchange="previewImage(event, '#imagePreview')">
                                <img id="imagePreview" src="{{ asset('placeholder.webp') }}" class="img-thumbnail mt-2 rounded-circle" style="width:120px; height:120px; object-fit:cover; display:block;">
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
        <ul class="nav nav-tabs mb-3" id="teamTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab">Members List</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sort-tab" data-bs-toggle="tab" data-bs-target="#sort" type="button" role="tab">Sort Order</button>
            </li>
        </ul>

        <div class="tab-content" id="teamTabContent">
            <div class="tab-pane fade show active" id="list" role="tabpanel">
                <div class="card">
                    <div class="card-header"><h4 class="card-title mb-0">All Team Members</h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="teamTable" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Type</th>
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
                        <h4 class="card-title mb-0">Sort Members (Drag & Drop)</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:80px;">Sl</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($teams as $index => $member)
                                        <tr data-id="{{ $member->id }}" style="cursor:grab;">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $member->name }}</td>
                                            <td>{{ $member->position }}</td>
                                            <td>
                                                <span class="badge {{ $member->type === 'Leadership' ? 'bg-primary' : 'bg-info' }}">
                                                    {{ $member->type }}
                                                </span>
                                            </td>
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

            $('#teamTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: '{{ route('team.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'position', name: 'position' },
                    { data: 'type', name: 'type' },
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
                        url: '{{ route('team.updateOrder') }}',
                        method: 'POST',
                        data: { order: order },
                        success: function(res) {
                            showSuccess(res.message);
                            $('#sortable tr').each(function(index) {
                                $(this).find('td:first').text(index + 1);
                            });
                            reloadTable('#teamTable');
                        }
                    });
                }
            });

            $('#newBtn').on('click', function() {
                clearForm();
                $('#cardTitle').text('Add New Member');
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
                var id = $('#teamId').val();
                var url = id ? '{{ route('team.update') }}' : '{{ route('team.store') }}';

                var formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('position', $('#position').val());
                formData.append('type', $('#type').val());
                formData.append('description', $('#description').val());
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
                            reloadTable('#teamTable');
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
                        $('#teamId').val(d.id);
                        $('#name').val(d.name);
                        $('#position').val(d.position);
                        $('#type').val(d.type);
                        $('#description').val(d.description);
                        
                        $('#imagePreview').attr('src', d.image ? d.image : '/placeholder.webp');
                        $('#cardTitle').text('Edit Member');
                        $('#addThisFormContainer').slideDown(300);
                        $('#newBtn').hide();
                        pageTop();
                    }
                });
            });

            $(document).on('change', '.toggle-status', function() {
                var id = $(this).data('id');
                $.post('{{ route('team.toggleStatus') }}', { id: id }, function(res) {
                    reloadTable('#teamTable');
                    showSuccess(res.message);
                });
            });

            function clearForm() {
                $('#teamId').val('');
                $('#name').val('');
                $('#position').val('');
                $('#type').val('Leadership');
                $('#description').val('');
                $('#image').val('');
                $('#imagePreview').attr('src', '/placeholder.webp');
            }
        });
    </script>
@endsection