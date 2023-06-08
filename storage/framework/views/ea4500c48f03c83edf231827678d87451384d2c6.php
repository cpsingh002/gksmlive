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

                                            <form method="post" action="<?php echo e(route('property.status')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="btn-group mb-3" role="group">
                                                    <input type="hidden" value="<?php echo e($property->scheme_id); ?>" name="scheme_id" />
                                                    <input type="hidden" value="<?php echo e($property->property_public_id); ?>" name="property_id" />
                                                    <input type="hidden" value="1" name="property_status" />
                                                    <button type="submit" class="btn <?php echo e($property->property_status == 1 ? 'btn-success' : 'btn-primary'); ?>  w-xs">
                                                        <i class="mdi mdi-thumb-up"></i>
                                                    </button>
                                                </div>
                                            </form>
                                            <form method="post" action="<?php echo e(route('property.status')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="btn-group mb-3" role="group">
                                                    <input type="hidden" value="<?php echo e($property->scheme_id); ?>" name="scheme_id" />
                                                    <input type="hidden" value="<?php echo e($property->property_public_id); ?>" name="property_id" />
                                                    <input type="hidden" value="2" name="property_status" />
                                                    <button type="submit" class="btn  <?php echo e($property->property_status == 2 ? 'btn-warning' : 'btn-info'); ?>  w-xs">
                                                        <i class="mdi mdi-thumb-down"></i>
                                                    </button>
                                                </div>
                                            </form>


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
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\realestate\resources\views/scheme/properties.blade.php ENDPATH**/ ?>