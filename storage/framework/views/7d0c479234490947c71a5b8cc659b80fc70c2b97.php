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
                                                <a href="<?php echo e(route('property.book', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id])); ?>">
                                                    <button type="button" class="text-success border-0">Book</button>
                                                </a>
                                                <a href="<?php echo e(route('property.hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id])); ?>">
                                                    <button type="button" class="text-danger border-0">Hold</button>
                                                </a>
                                            </div>

                                        </div>
                                    </div><!-- end col -->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\associate\resources\views/scheme/properties.blade.php ENDPATH**/ ?>