<?php $__env->startSection("content"); ?>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Booking Reports</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">DataTables</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <?php if($propty_report_details): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <table class="table table-bordered dt-responsive  w-100" id="associateReportTbl">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Customer Name</th>
                                <th>Plot No</th>
                                <th>Scheme Name</th>
                                <th>Customer Number</th>
                                <th>Associate Name</th>
                                <th>Associate Rera Number</th>
                                <th>Booking Time</th>
                                <th>Status</th>
                                <th>View Details</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php ($count=1); ?>
                            <?php $__currentLoopData = $propty_report_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report_property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                            <tr>
                                <td><?php echo e($count); ?></td>
                                <td><?php echo e($report_property->owner_name); ?></td>
                                <td><?php echo e($report_property->plot_no); ?></td>
                                <td><?php echo e($report_property->scheme_name); ?></td>
                                <td><?php echo e($report_property->contact_no); ?></td>
                                <td><?php echo e($report_property->associate_name); ?></td>
                                <td><?php echo e($report_property->associate_rera_number); ?></td>
                                <td><?php echo e(date('d-M-y H:i:s', strtotime($report_property->booking_time))); ?></td>
                                <td class="<?php echo e($report_property->booking_status == 2 ? 'text-success' : 'text-danger'); ?>"><?php echo e($report_property->booking_status == 2 ? 'Booked' : 'Hold'); ?></td>
                                <td class=""><a href="<?php echo e(route('show.report-detail', ['id' => $report_property->property_public_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>


                            </tr>
                            <?php ($count++); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <?php endif; ?>


</div> <!-- container-fluid -->

<!-- End Page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\realstate_dashboard\resources\views/scheme/associate-reports.blade.php ENDPATH**/ ?>