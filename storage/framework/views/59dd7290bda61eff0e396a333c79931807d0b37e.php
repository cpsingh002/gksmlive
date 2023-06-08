

<?php $__env->startSection("content"); ?>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18"><?php echo e($scheme_detail->scheme_name); ?></h4>

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
                <div class="card-header">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card-body">
                                <div class="row g-4">



                                    <table class="table" id="myTable">
                                        <thead>
                                            <tr>
                                                <td>Plot No</td>
                                                <td>Scheme Name</td>
                                                <td>Attributes</td>
                                                <td>Description</td>
                                                <td>Actions</td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php (
                                            $color =
                                            [
                                            1 => 'border-primary',
                                            2 => 'border-success',
                                            3 => 'border-danger',
                                            4 => 'border-warning'
                                            ]
                                            ); ?>
                                            <tr>
                                                <td><?php echo e($property->plot_no); ?></td>
                                                <td><?php echo e($property->scheme_name); ?></td>
                                                <td>
                                                    <?php if(json_decode($property->attributes_data)): ?>

                                                    <?php $__currentLoopData = json_decode($property->attributes_data); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span><?php echo e($key); ?> -> <?php echo e($attr); ?> &nbsp</span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <!-- <li class="list-group-item">A second item</li>
                                                <li class="list-group-item">A third item</li> -->

                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($property->description); ?></td>
                                                <?php if($property->status == 5): ?>
                                                <td>
                                                    <a href="#" class="card-link text-primary">Completed</a>

                                                </td>
                                                <?php else: ?>
                                                <td>
                                                    <?php if($property->status == 1): ?>
                                                    <a href="#" class="card-link text-primary">Available</a>
                                                    <a href="<?php echo e(route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id])); ?>" class="card-link">Click here Book/Hold</a>
                                                    <?php if(Auth::user()->user_type != 4): ?>
                                                    <a href="<?php echo e(route('for-managment.property-status',['id' => $property->property_public_id])); ?>" class="card-link text-secondary">Management hold</a>
                                                    <?php endif; ?>
                                                    <?php elseif($property->status == 2): ?>
                                                    <a href="#" class="card-link text-success">Booked</a>
                                                    <?php elseif($property->status == 3): ?>
                                                    <a href="#" class="card-link text-danger">Hold</a>
                                                    <a href="<?php echo e(route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id])); ?>" class="card-link">Click here Book/Hold</a>
                                                    <?php else: ?>
                                                    <?php if(Auth::user()->user_type != 4): ?>
                                                    <a href="#" class="card-link text-warning">Cancel</a>
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>

                                    </table>


                                </div><!-- end row -->
                            </div><!-- end card-body -->
                        </div><!-- end col -->
                    </div><!-- end row -->


                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- container-fluid -->

<!-- End Page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\realstate_dashboard\resources\views/scheme/list_properties.blade.php ENDPATH**/ ?>