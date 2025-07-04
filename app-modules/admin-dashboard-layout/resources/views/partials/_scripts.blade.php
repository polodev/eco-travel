<!-- jQuery (if needed for DataTables and other plugins) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.tailwindcss.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.tailwindcss.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- Flatpickr for Date Pickers -->
<script src="{{ asset('vendor/flatpickr/flatpickr.min.js') }}"></script>

<!-- Select2 for Enhanced Select Elements -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Common DataTable Helper Functions -->
<script>
    // Enhanced page navigation helper for DataTables with URL parameter support
    function dataTableNavigate(dataTableName) {
        // Handle initial page load from URL parameter
        var params_for_datatable_page_number = new URLSearchParams(window.location.search);
        var dt_page_number = parseInt(params_for_datatable_page_number.get('page'));
        if (dt_page_number) {
            dt_page_number--;
            dataTableName.on('init.dt', function(e) {
                dataTableName.page(dt_page_number).draw(false);
            });
        }

        // Update URL when page changes
        const searchURL = new URL(window.location);
        dataTableName.on('draw.dt', function() {
            var info = dataTableName.page.info();
            searchURL.searchParams.set('page', (info.page + 1));
            window.history.replaceState({}, '', searchURL);
            
            // Update the page number input field
            $('#datatable-page-number').val(info.page + 1);
        });

        // Go to specific page when button is clicked
        $('#datatable-page-number-button').on('click', function() {
            var page_number = parseInt($('#datatable-page-number').val());
            if (page_number && page_number > 0) {
                page_number--;
                dataTableName.page(page_number).draw(false);
            }
        });

        // Handle enter key press on page number input
        $('#datatable-page-number').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                $('#datatable-page-number-button').click();
            }
        });
    }

    // Common CSRF token setup for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>