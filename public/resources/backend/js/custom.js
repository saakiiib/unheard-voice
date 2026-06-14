function pagetop() {
    window.scrollTo({
        top: 130,
        behavior: 'smooth',
    });
}

// Success
function showSuccess(msg) {
    setTimeout(() => {
        Swal.fire({
            icon: 'success',
            title: msg ?? 'Success!',
            showConfirmButton: false,
            timer: 1200
        });
    }, 300);
}

// Error
function showError(msg) {
    setTimeout(() => {
        Swal.fire({
            icon: 'error',
            title: msg ?? 'Something went wrong!',
            showConfirmButton: false,
            timer: 2000
        });
    }, 300);
}

//reload
function reload(ms = 2000) {
    setTimeout(() => {
        location.reload();
    }, ms);
}

function pageTop() {
    window.scrollTo({
        top: 50,
        behavior: 'smooth',
    });
}

// Preview image
function previewImage(event, imgSelector) {
  if (event.target.files && event.target.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $(imgSelector).attr('src', e.target.result).show();
    };
    reader.readAsDataURL(event.target.files[0]);
  }
}

$(document).ready(function () {

  //Selct2
  $('.select2').select2({
      width: '100%'
  });

   //summernote
    $('.summernote').summernote({
        height: 300,
        toolbar: [
            ['style', ['style', 'bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['font', ['fontname', 'fontsize', 'color', 'forecolor', 'backcolor', 'superscript', 'subscript']],
            ['para', ['ul', 'ol', 'paragraph', 'height']],
            ['insert', ['link', 'picture', 'video', 'table', 'hr', 'codeview', 'linkDialogShow']],
            ['misc', ['fullscreen', 'undo', 'redo', 'help']]
        ],
        popover: {
            image: [
                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone', 'floatLeft', 'floatRight', 'floatNone', 'removeMedia']],
                ['custom', ['imageAttributes']],
                ['remove', ['removeMedia']]
            ],
            link: [
                ['link', ['linkDialogShow', 'unlink']]
            ],
            table: [
                ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                ['delete', ['deleteRow', 'deleteCol', 'deleteTable']]
            ],
            air: [
                ['color', ['color']],
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']]
            ]
        },
        dialogsInBody: true,
    });

});

let deleteUrl = '';
let tableSelector = null;
let deleteMethod = 'DELETE';

$(document).on('click', '.deleteBtn', function() {
    deleteUrl = $(this).data('delete-url');
    tableSelector = $(this).data('table') || null;
    deleteMethod = $(this).data('method') || 'DELETE';
    $('#confirmDeleteModal').modal('show');
});

$('#confirmDeleteBtn').on('click', function() {
    if (!deleteUrl) return;

    $.ajax({
        url: deleteUrl,
        method: deleteMethod,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response, textStatus, xhr) {
            if (xhr.status === 200) {
                showSuccess(response.message ?? 'Deleted successfully!');
                $('#confirmDeleteModal').modal('hide');
                reloadTable(tableSelector);
            }
        },
        error: function(xhr) {
            let message = xhr.responseJSON?.message ?? "Something went wrong!";
            showError(message);
            $('#confirmDeleteModal').modal('hide');
        }
    });
});

function reloadTable(tableSelector = null) {
    let table;

    if (tableSelector) {
        table = $(tableSelector).DataTable();
    } else {
        table = $('table.dataTable:visible').DataTable();
    }

    if (table) {
        table.ajax.reload(null, false);
    }
}

window.showLoader = function () {
    Swal.fire({
        title: 'Loading',
        html: '<p>Please wait...</p>',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => Swal.showLoading()
    });
};

window.hideLoader = function () {
    Swal.close();
};

$(document).on('click', '.loader-btn', function () {
    showLoader();
});

$(document).ajaxComplete(function () {
    hideLoader();
});