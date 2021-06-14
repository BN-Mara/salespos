// Call the dataTables jQuery plugin
$(document).ready(function() {
  //$('#dataTable').DataTable();
  $('#dataTable').DataTable({
    dom: 'Blfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
});
