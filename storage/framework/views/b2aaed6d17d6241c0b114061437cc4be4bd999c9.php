

<?php $__env->startSection("content"); ?>
<style>
    .card{
        box-shadow: 0px 7px 10px 0px;
}
    
    .shadow-green{
        box-shadow: 0px 7px 10px 0px rgb(97 229 177);
    }
    .shadow-red{
        box-shadow: 0px 7px 10px 0px rgb(213 36 36);
    }
    .shadow-blue{
           box-shadow: 0px 7px 10px 0px rgb(36 107 213);
           color:darkblue;

    }
    .shadow-violet{
        box-shadow: 0px 7px 10px 0px rgb(100 51 217);
        color:darkviolet;
        border-color:darkviolet;
    }
    .shadow-teal{
         box-shadow: 0px 7px 10px 0px darkgreen;
       border-color:darkgreen;
    }
</style>

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

$booking_status = [
2 => 'Booked',
3 => 'Hold'
]
); ?>


<?php (

      $managment_color = [
        0 =>'aaa',
        1 => 'Rahan',
        2 => 'border-success shadow-green',
        3 => 'border-danger shadow-red',
        4=>  'shadow-violet',
        5 => 'shadow-teal',
        6 => 'border-info shadow-blue',
        ]
       ); ?>

                              <div class="col-md-4">
                                        <!--<div class="card <?php echo e(isset($color[$property->status]) ? $color[$property->status] : 'out of borders'); ?>" style="width: 18rem;">-->
                                            
                                         <!--<div class="card <?php if($property->status == 2): ?> border-success <?php elseif($property->status == 3): ?> border-danger <?php endif; ?>" style="width: 18rem;">-->
                                            <div class="card <?php echo e($managment_color[$property->status]); ?>">
                                            <div class="card-body">
                                                 <h5 class="card-title">Plot No <?php echo e($property->plot_no); ?></h5>
                                                <!-- <a href="<?php echo e(route('view.property', ['id' => $property->property_public_id])); ?>">
                                                    <h5 class="card-title">Plot No <?php echo e($property->plot_no); ?></h5>
                                                </a> -->
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
                                                    <a href="#" class="card-link  fw-bold" style="color:blue;"><?php echo e($managment_hold[$property->management_hold]); ?></a>
                                                    <p>
                                                        <?php echo e($property->other_info); ?>

                                                    </p>
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
                                                    <!--<a href="#" class="card-link text-success"><?php echo e(@$booking_status[$property->status]); ?></a>-->
                                                    
                                                    <a href="#" class="card-link fw-bold <?php if($property->status == 2): ?>text-success <?php else: ?>text-danger <?php endif; ?>"><?php echo e(@$booking_status[$property->status]); ?></a>
                                                </li>
                                                <?php if(Auth::user()->user_type != 4): ?>
                                                <li>
                                                    <a onclick="return confirm('Are you sure you want to cancel this booking ?')" href="<?php echo e(route('cancel.property-cancel',['id' => $property->property_public_id])); ?>" class="card-link ">Cancle</a>
                                                </li>
                                                <li>
                                                    <a onclick="return confirm('Are you sure you want to complete this booking ?')" href="<?php echo e(route('complete.property-complete',['id' => $property->property_public_id])); ?>" class="card-link ">Complete</a>
                                                </li>
                                                <?php elseif($property->status == 3 &&  Auth::user()->public_id  == $property->user_id ): ?>
                                                <li>
                                                    <a href="<?php echo e(route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id])); ?>" class="card-link">Click here Book/Hold</a>
                                                </li>
                                                
                                                <?php endif; ?>

                                            </ul>
                                            

                                            <?php elseif($property->status == 5): ?>
                                            <ul class="list-group-flush" style="list-style:none;">
                                                <li>
                                                    <a class="card-link fw-bold" style="color:darkgreen">Completed</a>
                                                </li>
                                            </ul>
                                            <?php elseif($property->status == 4): ?>
                                            <ul class="list-group-flush" style="list-style:none;">
                                                <li>
                                                    <a class="card-link  fw-bold">To Be Released</a>
                                                </li>
                                            </ul>
                                            <?php else: ?>
                                            <ul class="list-group-flush" style="list-style:none;">
                                                <li>
                                                    <a class="card-link text-primary fw-bold">Available</a>
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
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dmlux/public_html/project/resources/views/scheme/properties.blade.php ENDPATH**/ ?>