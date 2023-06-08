

<?php $__env->startSection("content"); ?>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Property Delete Reason Form</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>-->
                <!--        <li class="breadcrumb-item active">Form Validation</li>-->
                <!--    </ol>-->
                <!--</div>-->

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="offset-xl-2 col-xl-8">
            <div class="card">

                <div class="card-body">
                    <form class="needs-validation" method="post" action="<?php echo e(route('delete.property')); ?>" novalidate>
                        <?php echo csrf_field(); ?>
                        <input type="hidden" value="6" name="booking_status" />
                        <input type="hidden" value="<?php echo e($property_details->property_public_id); ?>" name="property_public_id" />
                        <input type="hidden" value="<?php echo e($property_details->plot_no); ?>" name="plot_no" />
                        <input type="hidden" value="<?php echo e($property_details->scheme_id); ?>" name="scheme_id" />
                        <div class="row">
                            <!-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Select Production</label>
                                    <select class="form-control" name="managment_hold_id">
                                    
                                        <option value="1">Rahan</option>
                                        <option value="2">Possession issue</option>
                                        <option value="3">Staff plot</option>
                                        <option value="4"> Executive plot</option>
                                        <option value="5">Associate plot</option>
                                        <option value="6">Other</option>

                                    </select>
                                </div>
                            </div> -->



                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Delete Reason</label>
                                    <input type="text" name="other_info" class="form-control"  class="form-control <?php $__errorArgs = ['other_info'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                
                                    <?php $__errorArgs = ['other_info'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <!-- <div class="valid-feedback">
                                        Looks good!
                                    </div> -->
                                </div>
                            </div>


                            <!-- end col -->
                        </div>

                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->


    </div>
    <!-- end row -->

</div> <!-- container-fluid -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bookingg/public_html/resources/views/property/property-delete-reson.blade.php ENDPATH**/ ?>