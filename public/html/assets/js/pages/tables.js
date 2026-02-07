/* ============================================
   Nexora - Tables Page JavaScript
   ============================================ */

$(document).ready(function () {

    // ---- Advanced DataTable with Export Buttons ----
    $('#advancedTable').DataTable({
        dom: '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"B>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-sm btn-nx-secondary me-1',
                text: '<i class="fas fa-copy me-1"></i> Copy'
            },
            {
                extend: 'csv',
                className: 'btn btn-sm btn-nx-secondary me-1',
                text: '<i class="fas fa-file-csv me-1"></i> CSV'
            },
            {
                extend: 'excel',
                className: 'btn btn-sm btn-nx-secondary me-1',
                text: '<i class="fas fa-file-excel me-1"></i> Excel'
            },
            {
                extend: 'pdf',
                className: 'btn btn-sm btn-nx-secondary me-1',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF'
            },
            {
                extend: 'print',
                className: 'btn btn-sm btn-nx-secondary',
                text: '<i class="fas fa-print me-1"></i> Print'
            }
        ],
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        language: {
            search: '_INPUT_',
            searchPlaceholder: 'Search records...',
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next: '<i class="fas fa-chevron-right"></i>'
            }
        },
        responsive: true,
        order: [[0, 'asc']]
    });

});
