/* ============================================
   Nexora - Users Page JavaScript
   ============================================ */

$(document).ready(function () {

    // ---- Users DataTable ----
    var usersTable = $('#usersTable').DataTable({
        pageLength: 10,
        lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
        language: {
            search: '_INPUT_',
            searchPlaceholder: 'Search users...',
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next: '<i class="fas fa-chevron-right"></i>'
            }
        },
        order: [[4, 'desc']],
        columnDefs: [
            { orderable: false, targets: [5] }
        ]
    });

    // ---- Select2 in Modal ----
    $('.select2-modal').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#addUserModal')
    });

    // ---- Delete User (SweetAlert2) ----
    $(document).on('click', '.btn-delete', function () {
        var $row = $(this).closest('tr');
        var userName = $row.find('.fw-semibold').first().text();

        Swal.fire({
            title: 'Delete User?',
            html: 'Are you sure you want to delete <strong>' + userName + '</strong>?<br>This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash-alt me-1"></i> Yes, delete',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'rounded-4'
            }
        }).then(function (result) {
            if (result.isConfirmed) {
                usersTable.row($row).remove().draw();
                toastr.success(userName + ' has been deleted.', 'Deleted');
            }
        });
    });

    // ---- Save New User ----
    $('#saveUserBtn').on('click', function () {
        var modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
        modal.hide();
        toastr.success('New user has been added successfully!', 'Success');
    });

    // ---- Update User ----
    $('#updateUserBtn').on('click', function () {
        var modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
        modal.hide();
        toastr.info('User information has been updated.', 'Updated');
    });

});
