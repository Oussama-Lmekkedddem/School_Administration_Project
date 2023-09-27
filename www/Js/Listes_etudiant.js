
   $(document).ready(function () {
     $('#dtBasicExample').DataTable();
     $('.dataTables_length').addClass('bs-select');
   });



   dTable=$('#myTable').DataTable({
    "bLengthChange": false,
    "lengthMenu": [4],
    "columnDefs": [
    {"className": "dt-center", "targets": "_all"}
  ],
    "dom":"lrtip"
});

$('#myCustomSearchBox').keyup(function(){  
  dTable.search($(this).val()).draw();
})


$(document).ready(function () {
$('#dtBasicExample2').DataTable();
$('.dataTables_length').addClass('bs-select');
});

   dTable2=$('#myTable').DataTable({
    "bLengthChange": false,
    "lengthMenu": [4],
    "columnDefs": [
    {"className": "dt-center", "targets": "_all"}
  ],
    "dom":"lrtip"
});

$('#myCustomSearchBox').keyup(function(){  
  dTable2.search($(this).val()).draw();
})


$(document).ready(function () {
$('#dtBasicExample2').DataTable();
$('.dataTables_length').addClass('bs-select');
});

