$(document).ready(function () {
    // table
    if ($.fn.DataTable.isDataTable("#withdrawalsTable,#cryptoTable,#tabledata1,#tabledata2,#tabledata3,#tabledata4")) {
        $("#withdrawalsTable,#cryptoTable,#tabledata1,#tabledata2,#tabledata3,#tabledata4").DataTable().destroy(); // Destroy existing DataTable instance
    }

    $("#withdrawalsTable,#cryptoTable,#tabledata1,#tabledata2,#tabledata3,#tabledata4").DataTable({
        "paging": true, // Enable pagination
        "searching": true, // Enable search filter
        "ordering": true, // Enable sorting
        "lengthMenu": [5, 10, 25, 50], // Rows per page
        "pageLength": 10, // Default rows per page
        "info": true, // Show info like "Page 1 of 3"
    });
});