<?php $__env->startSection("content"); ?>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">DataTables</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">DataTables</li>
                    </ol>
                </div>

            </div>
        </div>
        <div class="col-4">
            <?php if(session('status')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong> <?php echo e(session('status')); ?></strong>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?php if(Auth::user()->user_type == 1 || Auth::user()->user_type ==2 || Auth::user()->user_type == 3): ?>
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                            <div class="page-title-right">
                                <a href="<?php echo e(URL::to('/add-scheme')); ?>" type="button" class="btn btn-success waves-effect waves-light">Add Scheme</a>
                            </div>

                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">

                    <table id="myTable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Production Name</th>
                                <th>Scheme Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php ($count=1); ?>
                            <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td> <?php echo e($count); ?> </td>
                                <!-- <td><?php echo e($scheme->scheme_public_id); ?></td> -->
                                <td><?php echo e($scheme->production_name); ?></td>
                                <td><?php echo e($scheme->scheme_name); ?></td>
                                <td class="<?php echo e($scheme->scheme_status == 1 ? 'text-success' : 'text-danger'); ?>"><?php echo e($scheme->scheme_status == 1 ? 'Active' : 'Deactive'); ?></td>
                                <td>
                                    <?php if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2 || Auth::user()->user_type == 3): ?>
                                    <a href="<?php echo e(route('scheme.edit', ['id' => $scheme->scheme_public_id])); ?>" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-pencil-alt text-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                        </i></a>
                                    <a onclick="return confirm('Are you sure you want to delete ?')" href="<?php echo e(route('scheme.destroy', ['id' => $scheme->scheme_public_id])); ?>" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-recycle text-danger"></i></a>

                                    <a href="<?php echo e(route('view.scheme', ['id' => $scheme->scheme_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view property"><i class="fas fa-house-user text-success"></i></a>

                                    <a href="<?php echo e(route('show.scheme', ['id' => $scheme->scheme_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view scheme"><i class="fas fa-home text-info"></i></a>
                                    <a href="<?php echo e(route('list_view.scheme', ['id' => $scheme->scheme_id])); ?>" ata-toggle="tooltip" data-placement="top" title="list view"><i class="fas fa-bars text-info"></i></a>
                                    <?php else: ?>
                                    <a href="<?php echo e(route('view.scheme', ['id' => $scheme->scheme_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view property"><i class="fas fa-house-user text-success"></i></a>
                                    <a href="<?php echo e(route('list_view.scheme', ['id' => $scheme->scheme_id])); ?>" ata-toggle="tooltip" data-placement="top" title="list view"><i class="fas fa-bars text-info"></i></a>
                                    <a href="<?php echo e(route('show.scheme', ['id' => $scheme->scheme_id])); ?>" ata-toggle="tooltip" data-placement="top" title="view scheme"><i class="fas fa-home text-info"></i></a>
                                    <?php endif; ?>
                                </td>

                            </tr>
                            <?php ($count++); ?>
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
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\realstate_dashboard\resources\views/scheme/schemes.blade.php ENDPATH**/ ?>