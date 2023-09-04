<?php $__env->startSection("content"); ?>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Operator</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">Associates</li>-->
                <!--    </ol>-->
                <!--</div>-->

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                            <div class="page-title-right">
                                <!-- <a href="<?php echo e(URL::to('/add-associate')); ?>" type="button" class="btn btn-success waves-effect waves-light">Add Associate</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                       <table id="myTable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Operator Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Production House</th>
                                 <th>Status</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>


                        <tbody>
                            <?php ($count=1); ?>
                            <?php $__currentLoopData = $associates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $associate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td> <?php echo e($count); ?> </td>
                                <td><?php echo e($associate->name); ?></td>
                                <!-- <td><?php echo e($associate->public_id); ?></td> -->
                                <td><?php echo e($associate->email); ?></td>
                                <td><?php echo e($associate->mobile_number); ?></td>
                                <td><?php echo e($associate->production_name); ?></td>
                                <td class="<?php echo e($associate->status == 1 ? 'text-success' : 'text-danger'); ?>"><?php echo e($associate->status == 1 ? 'Active' : 'Deactive'); ?></td>
                                <!-- <td>
                                    
                                    <?php if($associate->status !=5): ?>
                                    <a onclick="return confirm('Are you sure you want to deactive associate ?')" href="<?php echo e(route('user.deactivate', ['id' => $associate->public_id, 'status' => 1])); ?>" data-toggle="tooltip" data-placement="top" title="Deactivate User"><i class="fas fa-eye text-success" data-toggle="tooltip" data-placement="top" title="Deactivate"></i></a>
                                    <?php else: ?>
                                    <a onclick="return confirm('Are you sure you want to active associate again ?')" href="<?php echo e(route('user.activate', ['id' => $associate->public_id, 'status' => 5])); ?>" data-toggle="tooltip" data-placement="top" title="Deactivate User"><i class="fas fa-eye-slash text-danger" data-toggle="tooltip" data-placement="top" title="Deactivate"></i></a>
                                    <?php endif; ?>
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
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\gksm\resources\views/associate/opertors.blade.php ENDPATH**/ ?>