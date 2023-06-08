<?php $__env->startSection("content"); ?>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Report Details</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Report Details</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">

                        <tbody>
                            <tr>
                                <th>Scheme Name</th>
                                <td><?php echo e($propty_report_detail->scheme_name); ?></td>
                            </tr>

                            <tr>
                                <th>Plot Number</th>
                                <td><?php echo e($propty_report_detail->plot_no); ?></td>
                            </tr>


                            <tr>
                                <th>Associate Name</th>
                                <td><?php echo e($propty_report_detail->associate_name); ?></td>
                            </tr>

                            <tr>
                                <th>Associate Number</th>
                                <td><?php echo e($propty_report_detail->associate_number); ?></td>
                            </tr>

                            <tr>
                                <th>Associate Rera Number</th>
                                <td><?php echo e($propty_report_detail->associate_rera_number); ?></td>
                            </tr>
                            <?php if(Auth::user()->user_type == 3): ?>
                            <?php if($propty_report_detail->booking_status == 4): ?>
                            <!--<tr>-->
                            <!--    <th>Your Plot Booking Status Is </th>-->
                            <!--    <td><a href="#" class="btn btn-outline-danger">Cancelled</a></td>-->
                            <!--</tr>-->
                            <?php else: ?>
                            <!--<tr>-->
                            <!--    <th>If you want to cancel this booking then click on cancel button</th>-->
                            <!--    <td><a href="<?php echo e(route('cancel.property-cancel', ['id' => $propty_report_detail->property_public_id])); ?>" class="btn btn-danger">Cancel</a></td>-->
                            <!--</tr>-->
                            <?php endif; ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- container-fluid -->

<!-- End Page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dmlux/public_html/project/resources/views/scheme/report-detail.blade.php ENDPATH**/ ?>