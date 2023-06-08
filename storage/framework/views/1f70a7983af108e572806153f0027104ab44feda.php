<?php $__env->startSection("content"); ?>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Holding Reports</h4>

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

    <div class="row">
        <div class="col-12">
            <div class="card">
               
                <div class="card-body">

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Associate Number</th>
                                <th>Customer Name</th>
                                <th>Customer Number</th>
                                <th>Status</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php $__currentLoopData = $holding_properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hold_property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td><?php echo e($hold_property->public_id); ?></td>
                                <td><?php echo e($hold_property->associate_name); ?></td>
                                <td><?php echo e($hold_property->owner_name); ?></td>
                                <td><?php echo e($hold_property->contact_no); ?></td>
                                <td class="<?php echo e($hold_property->status == 1 ? 'text-success' : 'text-danger'); ?>"><?php echo e($hold_property->status == 1 ? 'Booked' : 'Hold'); ?></td>
                              
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- container-fluid -->

<!-- End Page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\associate\resources\views/scheme/holding-reports.blade.php ENDPATH**/ ?>