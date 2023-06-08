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

                                    <div class="col-md-4">
                                        <div class="card <?php echo e(isset($color[$property->status]) ? $color[$property->status] : 'out of borders'); ?>" style="width: 18rem;">

                                            <div class="card-body">
                                                <a href="<?php echo e(route('view.property', ['id' => $property->property_public_id])); ?>">
                                                    <h5 class="card-title">Plot No <?php echo e($property->plot_no); ?></h5>
                                                </a>
                                                <p class="card-text"><?php echo e($property->description); ?></p>
                                            </div>
                                            <?php if(json_decode($property->attributes_data)): ?>
                                            <ul class="list-group list-group-flush">
                                                <?php $__currentLoopData = json_decode($property->attributes_data); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="list-group-item"><?php echo e($key); ?> -> <?php echo e($attr); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <!-- <li class="list-group-item">A second item</li>
                                                <li class="list-group-item">A third item</li> -->
                                            </ul>
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <?php if($property->status == 1): ?>
                                                <a href="#" class="card-link text-primary">Available</a>
                                                <?php elseif($property->status == 2): ?>
                                                <a href="#" class="card-link text-success">Booked</a>
                                                <?php elseif($property->status == 3): ?>
                                                <a href="#" class="card-link text-danger">Hold</a>
                                                <?php else: ?>
                                                <a href="#" class="card-link text-warning">Cancel</a>
                                                <?php endif; ?>
                                                <a href="<?php echo e(route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id])); ?>" class="card-link">Click here Book/Hold</a>
                                            </div>
                                            <?php if($property->status == 2 || $property->status == 3): ?>
                                            <div class="card-body">

                                                <a  onclick="return confirm('Are you sure you want to cancel this booking ?')" href="<?php echo e(route('cancel.property-cancel',['id' => $property->property_public_id])); ?>" class="card-link text-danger">Cancle</a>
                                                <a href="<?php echo e(route('for-managment.property-status',['id' => $property->property_public_id])); ?>" class="card-link text-secondary">Manage to hold</a>

                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <!-- 
                                    <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-xl-2">

                                        <a href="<?php echo e(route('view.property', ['id' => $property->property_public_id])); ?>">
                                            <h5 class="font-size-15 mb-3">Plot No <?php echo e($property->plot_no); ?></h5>
                                        </a>

                                        <div>
                                            <?php if($property->status == 1): ?>
                                            <button type="button" class="btn btn-outline-success">Plot No <?php echo e($property->plot_no); ?></button>
                                            <?php elseif($property->status == 2): ?>
                                            <button type="button" class="btn btn-outline-danger">Plot No <?php echo e($property->plot_no); ?></button>
                                            <?php elseif($property->status == 3): ?>
                                            <button type="button" class="btn btn-outline-warning">Plot No <?php echo e($property->plot_no); ?></button>
                                            <?php else: ?>
                                            <button type="button" class="btn btn-outline-secondary">Plot No <?php echo e($property->plot_no); ?></button>
                                            <?php endif; ?>
                                            <input type="hidden" value="1" name="property_status" />
                                            <div class="mt-2" role="group" aria-label="Basic example">
                                                <?php if($property->status == 1): ?>
                                                <button type="button" class="text-success border-0 ">Booked</button>
                                                <?php else: ?>
                                                <a href="<?php echo e(route('property.book', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id])); ?>">
                                                    <button type="button" class="text-success border-0">Book</button>
                                                </a>
                                                <?php endif; ?>
                                                <?php if($property->status == 1): ?>
                                                <button type="button" class="text-danger border-0 disabled">Hold</button>
                                                <?php else: ?>
                                                <a href="<?php echo e(route('property.hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id])); ?>">
                                                    <button type="button" class="text-danger border-0">Hold</button>
                                                </a>
                                                <?php endif; ?>

                                            </div>

                                        </div>
                                    </div> -->
                                    <!-- end col -->
                                    <!-- <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->

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
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admin\resources\views/scheme/properties.blade.php ENDPATH**/ ?>