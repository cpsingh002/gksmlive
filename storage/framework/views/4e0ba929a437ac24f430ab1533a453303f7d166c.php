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
                                            <?php if($property->management_hold > 0): ?>
                                            <?php (

                                            $managment_hold = [

                                            1 => 'Rahan',
                                            2 => 'Possession issue',
                                            3 => 'Staff plot',
                                            4=> 'Executive plot',
                                            5 => 'Associate plot',
                                            6 => 'Other'

                                            ]
                                            ); ?>

                                            <?php (

                                            $booking_status = [
                                            2 => 'Booked',
                                            3 => 'Hold'
                                            ]
                                            ); ?>
                                            <ul class="list-group-flush" style="list-style:none;">
                                                <li>
                                                    <a href="#" class="card-link text-success"><?php echo e($managment_hold[$property->management_hold]); ?></a>
                                                </li>
                                                <?php if(Auth::user()->user_type != 4): ?>
                                                <li>
                                                    <a onclick="return confirm('Are you sure you want to cancel this booking ?')" href="<?php echo e(route('cancel.property-cancel',['id' => $property->property_public_id])); ?>" class="card-link text-danger">Cancle</a>
                                                </li>
                                                <a onclick="return confirm('Are you sure you want to complete this booking ?')" href="<?php echo e(route('complete.property-complete',['id' => $property->property_public_id])); ?>" class="card-link text-secondary">Complete</a>
                                                <?php endif; ?>

                                            </ul>
                                            <?php elseif($property->status == 2 || $property->status == 3): ?>


                                            <ul class="list-group-flush" style="list-style:none;">
                                                <li>
                                                    <a href="#" class="card-link text-bg-success"> <?php echo e(@$booking_status[$property->status]); ?></a>
                                                </li>
                                                <?php if(Auth::user()->user_type != 4): ?>
                                                <li>
                                                    <a onclick="return confirm('Are you sure you want to cancel this booking ?')" href="<?php echo e(route('cancel.property-cancel',['id' => $property->property_public_id])); ?>" class="card-link text-bg-danger">Cancle</a>
                                                </li>
                                                <li>
                                                    <a onclick="return confirm('Are you sure you want to complete this booking ?')" href="<?php echo e(route('complete.property-complete',['id' => $property->property_public_id])); ?>" class="card-link text-bg-primary">Complete</a>
                                                </li>
                                                <?php endif; ?>

                                            </ul>

                                            <?php elseif($property->status == 5): ?>
                                            <ul class="list-group-flush" style="list-style:none;">
                                                <li>
                                                    <a href="#" class="card-link text-bg-success">Plot Booked already</a>
                                                </li>
                                            </ul>
                                            <?php else: ?>
                                            <ul class="list-group-flush" style="list-style:none;">
                                                <li>
                                                    <a href="#" class="card-link text-primary">Available</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo e(route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id])); ?>" class="card-link">Click here Book/Hold</a>
                                                </li>
                                                <?php if(Auth::user()->user_type != 4): ?>
                                                <li>
                                                    <a href="<?php echo e(route('for-managment.property-status',['id' => $property->property_public_id])); ?>" class="card-link text-secondary">Management hold</a>
                                                </li>
                                                <?php endif; ?>
                                            </ul>

                                            <?php endif; ?>
                                        </div>
                                    </div>
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
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\realstate_dashboard\resources\views/scheme/properties.blade.php ENDPATH**/ ?>