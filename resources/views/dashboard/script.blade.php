
<script src="{{url('')}}/assets/libs/jquery/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

<script src="{{url('')}}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{url('')}}/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="{{url('')}}/assets/libs/simplebar/simplebar.min.js"></script>
<script src="{{url('')}}/assets/libs/node-waves/waves.min.js"></script>
<script src="{{url('')}}/assets/libs/feather-icons/feather.min.js"></script>
<!-- pace js -->
<script src="{{url('')}}/assets/libs/pace-js/pace.min.js"></script>


<script src="{{url('')}}/assets/js/pages/pass-addon.init.js"></script>

<!-- dashboard init -->
<script src="{{url('')}}/assets/js/pages/dashboard.init.js"></script>

<script src="{{url('')}}/assets/js/app.js"></script>
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>







<script>
jQuery.noConflict();
    $(document).ready(function() {
        $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'pageLength',
                {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
            ]
        });
        
        $('#myTablelist').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'pageLength'
            ],
            "order": [[ 5, 'asc' ]]
        });
        
        
         $('#datatable1').DataTable({
            dom: 'Bfrtip',
            
            "order": [[ 5, 'asc' ]]
        });

        
    });
   
</script>

<script>
    jQuery('#button1').on('click', function() {          
       jQuery('#myModal').modal('show');
});

jQuery('.btn-close').on('click',function(){
  jQuery('#myModal').modal('hide');
});


// $('.change_password_btn').on('click', function() {          
//         $('#myModal-pass').modal('show');
// });

</script>
<script>
let minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    let min = minDate.val();
    let max = maxDate.val();
    //alert(min);
    let date = new Date(data[8]);
 //alert(date);
    if (
        (min === null && max === null) ||
        (min === null && date <= max) ||
        (min < date && max === null) ||
        (min <= date && date <= max)
    ) {
        return true;
    }
    return false;
});
 
// Create date inputs
minDate = new DateTime('#min', {
    format: 'MMMM Do YYYY'
});
maxDate = new DateTime('#max', {
    format: 'MMMM Do YYYY'
});
jQuery.noConflict();
  $(document).ready(function() {
      

  var table = $('#associateReportTbl').DataTable( {
        dom: 'Bfrtip',
        columnDefs: [
            {
                "targets": [10],
                "visible": true
            }
        ],
        buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'pageLength',
                {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
        ]
    });
    $('.status-dropdown').on('change', function(e){
      var status = $(this).val();
      
      $('.status-dropdown').val(status)
      
      table.column(9).search(status).draw();
    });
    
    
    document.querySelectorAll('#min, #max').forEach((el) => {
    el.addEventListener('change', () => table.draw());
});
    
    });
        
</script>
 

