

<?php $__env->startSection("content"); ?>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Associate Requests</h4>

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

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                    <table id="myTable" class="table table-bordered dt-responsive table-responsive  w-100">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Associate Name</th>
                                <th>Associate Contact Number</th>
                                <th>Associate Rera Number</th>
                                <th>Associate Email</th>
                                <th>Associate Uplinner Name</th>
                                <th>Associate Uplinner Rera Number</th>
                                <th>Team</th>
                                <th>Request Status</th>

                                <th>Approved</th>
                                <th>Cancelled</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php ($count=1); ?>
                            <?php $__currentLoopData = $associates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $associate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td> <?php echo e($count); ?> </td>
                                <td><?php echo e($associate->name); ?></td>
                                <td><?php echo e($associate->mobile_number); ?></td>
                                <td><?php echo e($associate->associate_rera_number); ?></td>
                                <td><?php echo e($associate->email); ?></td>
                                <td><?php echo e($associate->applier_name); ?></td>
                                <td><?php echo e($associate->applier_rera_number); ?></td>
                                <td><?php echo e($associate->team_name); ?></td>

                                <td class="<?php echo e($associate->status == 1 ? 'text-success' : 'text-danger'); ?>"><?php echo e($associate->status == 1 ? 'Approved' : 'Pending'); ?></td>
                                <td>
                                    <form method="post" action="<?php echo e(route('associate.approved', ['userid' => $associate->public_id])); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-sm btn-success">Approved</button>
                                    </form>

                                </td>
                                <td>
                                    <form method="post" action="<?php echo e(route('associate.cancelled')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="cancel_id" value="<?php echo e($associate->public_id); ?>" />
                                        <button class="btn btn-sm btn-danger">Cancelled</button>
                                    </form>
                                </td>

                                <!-- <td>
                                    <a href=""><i class="fas fa-pencil-alt text-primary" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                    <i class="fas fa-recycle text-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                                    <a href="<?php echo e(route('view.user', ['id' => $associate->public_id])); ?>" data-toggle="tooltip" data-placement="top" title="View Info"><i class="fas fa-user-alt text-success"></i></a>
                                </td> -->

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


</div> <!-- container-fluid -->

<!-- End Page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bookingg/public_html/resources/views/users/pending-request.blade.php ENDPATH**/ ?>