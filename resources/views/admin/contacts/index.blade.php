@extends('admin.pages.master')

@section('title', 'Contacts')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Contacts</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table id="contactTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contact Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> <span id="v_name"></span></p>
                        <p><strong>Email:</strong> <span id="v_email"></span></p>
                        <p><strong>Phone:</strong> <span id="v_phone"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Subject:</strong> <span id="v_subject"></span></p>
                        <p><strong>Submitted:</strong> <span id="v_date"></span></p>
                        <p><strong>Status:</strong> <span id="v_status"></span></p>
                    </div>
                </div>
                <hr>
                <p><strong>Message:</strong></p>
                <div class="border p-3 bg-light" id="v_message" style="white-space: pre-wrap; min-height: 80px;"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#contactTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: { url: "{{ route('contacts.index') }}" },
        columns: [
            { data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'date',         name: 'created_at' },
            { data: 'name',         name: 'name' },
            { data: 'email',        name: 'email' },
            { data: 'phone',        name: 'phone',    defaultContent: '-' },
            { data: 'subject',      name: 'subject',  defaultContent: '-' },
            { data: 'status',       name: 'status',   orderable: false, searchable: false },
            { data: 'action',       name: 'action',   orderable: false, searchable: false }
        ],
        order: [[1, 'desc']],
        pageLength: 15
    });

    $(document).on('click', '.viewBtn', function () {
        var id = $(this).data('id');
        $.get("{{ url('/admin/contacts') }}/" + id, function (res) {
            $('#v_name').text(res.name || '-');
            $('#v_email').text(res.email || '-');
            $('#v_phone').text(res.phone || '-');
            $('#v_subject').text(res.subject || '-');
            $('#v_date').text(res.formatted_date || '-');
            $('#v_status').text(res.status ? res.status.replace('_', ' ').toUpperCase() : '-');
            $('#v_message').text(res.message || 'No message provided');
            $('#viewModal').modal('show');
        }).fail(function () {
            showError('Failed to load contact details.');
        });
    });

    $(document).on('change', '.status-select', function () {
        var id     = $(this).data('id');
        var status = $(this).val();
        $.post("{{ route('contacts.toggleStatus') }}", { id: id, status: status }, function (res) {
            showSuccess(res.message);
        }).fail(function () {
            showError('Failed to update status.');
        });
    });

});
</script>
@endsection