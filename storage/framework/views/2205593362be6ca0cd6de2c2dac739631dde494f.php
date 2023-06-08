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
    <?php if(isset($book_properties)): ?>
    <?php if(isset($users)): ?>
    <form method="post" action="<?php echo e(route('scheme.get-associate-reports')); ?>">
        <div class="row mt-3 mb-3">

            <?php echo csrf_field(); ?>
            <div class="col-3">
                <select class="form-control" name="user_id">
                    <option>Select User</option>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->public_id); ?>"><?php echo e($user->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="col-3">
                <button class="btn btn-success">Get Reports</button>
            </div>


        </div>
    </form>
    <?php endif; ?>
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
                            <?php $__currentLoopData = $book_properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book_property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td><?php echo e($book_property->public_id); ?></td>
                                <td><?php echo e($book_property->associate_name); ?></td>
                                <td><?php echo e($book_property->owner_name); ?></td>
                                <td><?php echo e($book_property->contact_no); ?></td>
                                <td class="<?php echo e($book_property->booking_status == 1 ? 'text-success' : 'text-danger'); ?>"><?php echo e($book_property->booking_status == 1 ? 'Booked' : 'Hold'); ?></td>

                            </tr>
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
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\associate\resources\views/scheme/associate-reports.blade.php ENDPATH**/ ?>