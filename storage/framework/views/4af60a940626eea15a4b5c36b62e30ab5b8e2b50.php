
<script src="<?php echo e(url('')); ?>/assets/libs/jquery/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

<script src="<?php echo e(url('')); ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(url('')); ?>/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo e(url('')); ?>/assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo e(url('')); ?>/assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo e(url('')); ?>/assets/libs/feather-icons/feather.min.js"></script>
<!-- pace js -->
<script src="<?php echo e(url('')); ?>/assets/libs/pace-js/pace.min.js"></script>

<!-- dashboard init -->
<script src="<?php echo e(url('')); ?>/assets/js/pages/dashboard.init.js"></script>

<script src="<?php echo e(url('')); ?>/assets/js/app.js"></script>
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });

        $('#associateReportTbl').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
    });
    // let table = new DataTable('#myTable');
    // let associateReportTbl = new DataTable('#associateReportTbl');
</script>

<script>
    $('#button1').on('click', function() {          
        $('#myModal').modal('show');
});

$('.btn-close').on('click',function(){
  $('#myModal').modal('hide');
});
</script>
<?php /**PATH /home/bookingg/public_html/resources/views/dashboard/script.blade.php ENDPATH**/ ?>