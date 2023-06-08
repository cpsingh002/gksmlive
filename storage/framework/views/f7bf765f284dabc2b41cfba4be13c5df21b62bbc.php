

<?php $__env->startSection("content"); ?>
<style>
    .main-content{
        overflow:visible;
    }
    .chosen-container-single .chosen-single{
        height:38px;
        padding-top:7px;
        background:white;
    }
    .chosen-container-single .chosen-single div b {
    display: block;
    width: 100%;
    height: 100%;
    background: url(chosen-sprite.png) no-repeat 0 9px;
}
</style>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Scheme Booking Reports</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">DataTables</li>-->
                <!--    </ol>-->
                <!--</div>-->

            </div>
        </div>
    </div>
    <!-- end page title -->
    <form method="post" action="<?php echo e(route('scheme.get-reports')); ?>">
        <div class="row mt-3 mb-3">

            <?php echo csrf_field(); ?>
            <div class="col-6 col-md-3">
                <select class="form-control schedfdf" name="scheme_id">
                    <option>Select Scheme</option>
                    <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($scheme->id); ?>">
                        <?php echo e($scheme->scheme_name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-3">
                <input type="submit" class="btn btn-success" value="Get Report" />
            </div>

        </div>
    </form>

    <?php if(isset($book_properties)): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered dt-responsive  w-100">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Customer Name</th>
                                <th>Plot No</th>
                                <th>Scheme Name</th>
                                <th>Customer Number</th>
                                <th>Name</th>
                                <th>Associate Rera Number</th>
                                <th>Booking Time</th>
                                <th>Status</th>
                                <th>View Detail</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php ($count=1); ?>
                            <?php $__currentLoopData = $book_properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book_property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          
                            <tr>
                                <td><?php echo e($count); ?></td>
                                <td><?php echo e($book_property->owner_name); ?></td>
                                <td><?php echo e($book_property->plot_no); ?></td>
                                <td><?php echo e($book_property->scheme_name); ?></td>
                                <td><?php echo e($book_property->contact_no); ?></td>
                                <td><?php echo e($book_property->associate_name); ?></td>
                                <td><?php echo e($book_property->associate_rera_number); ?></td>
                                <td><?php echo e(date('d-M-y H:i:s', strtotime($book_property->booking_time))); ?></td>
                                 <?php if($book_property->property_status==3): ?>
                                <td class="text-dark fw-bold">Deleted</td>
                                <td class=""><a href="<?php echo e(route('show.report-detail', ['id' => $book_property->property_public_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                                <?php else: ?>
                                <?php if($book_property->booking_status == 2): ?>
                                <td class="text-success fw-bold">Booked</td>
                                <td class=""><a href="<?php echo e(route('show.report-detail', ['id' => $book_property->property_public_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                                <?php elseif($book_property->booking_status == 3): ?>
                                <td class="text-danger fw-bold">Hold</td>
                                <td class=""><a href="<?php echo e(route('show.report-detail', ['id' => $book_property->property_public_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                                <?php elseif($book_property->booking_status == 4): ?>
                                <td class="text-danger">Canceled</td>
                                <td class=""><a href="<?php echo e(route('show.report-detail', ['id' => $book_property->property_public_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                                <?php elseif($book_property->booking_status == 5): ?>
                                <td class="fw-bold" style="color:darkgreen;">Complete</td>
                                <td class=""><a href="<?php echo e(route('show.report-detail', ['id' => $book_property->property_public_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                               <?php elseif(($book_property->booking_status == 1) || ($book_property->booking_status == 0)): ?>
                                <td class="text-primary fw-bold">Avalible</td>
                                <td class=""><a href="<?php echo e(route('show.report-detail', ['id' => $book_property->property_public_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                                <?php else: ?>
                                <td class="text-primary">Management Hold</td>
                                <td class=""><a href="<?php echo e(route('show.report-detail', ['id' => $book_property->property_public_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                                <?php endif; ?>
                                <?php endif; ?>


                                <!-- <td class="<?php echo e($book_property->booking_status == 2 ? 'text-success' : 'text-danger'); ?>"><?php echo e($book_property->booking_status == 2 ? 'Booked' : 'Hold'); ?></td>
                                <td class=""><a href="<?php echo e(route('show.report-detail', ['id' => $book_property->property_public_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td> -->

                            </tr>
                            <?php ($count++); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <?php endif; ?>




</div> <!-- container-fluid -->

<!-- End Page-content -->

<?php $__env->startPush('scripts'); ?>
<script>
    $('.schedfdf').chosen();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<!-- <script>
    jQuery('.schedfdf').chosen();
</script> -->
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bookingg/public_html/resources/views/scheme/reports.blade.php ENDPATH**/ ?>