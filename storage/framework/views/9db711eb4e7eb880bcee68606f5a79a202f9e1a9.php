

<?php $__env->startSection("content"); ?>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Complete Booking Details</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">Report Details</li>-->
                <!--    </ol>-->
                <!--</div>-->

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">
                   
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">

                        <tbody>
                            <tr>
                                <th>Scheme Name</th>
                                <td><?php echo e($propty_report_detail->scheme_name); ?></td>
                            </tr>

                            <tr>
                                <th>Plot Number</th>
                                <td><?php echo e($propty_report_detail->plot_no); ?></td>
                            </tr>


                            <tr>
                                <th>Name</th>
                                <td><?php echo e($propty_report_detail->associate_name); ?></td>
                            </tr>

                            <tr>
                                <th>Associate Number</th>
                                <td><?php echo e($propty_report_detail->associate_number); ?></td>
                            </tr>

                            <tr>
                                <th>Associate Rera Number</th>
                                <td><?php echo e($propty_report_detail->associate_rera_number); ?></td>
                            </tr>
                            <tr>
                                <th>Customer Name</th>
                                <td><?php echo e($propty_report_detail->owner_name); ?></td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td><?php echo e($propty_report_detail->contact_no); ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><?php echo e($propty_report_detail->address); ?></td>
                            </tr>
                            <tr>
                                <th>Pan Card</th>
                                <td><?php echo e($propty_report_detail->pan_card); ?> <?php if($propty_report_detail->pan_card_image !=''): ?><a href="<?php echo e(URL::to('/customer/pancard',$propty_report_detail->pan_card_image)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/pancard',$propty_report_detail->pan_card_image)); ?>" class="ms-2" style="height:25px;width:45px;"></a><?php endif; ?> </td>
                            </tr>
                            <tr>
                                <th>Addhar Card</th>
                                <td><?php if($propty_report_detail->adhar_card !=''): ?><a href="<?php echo e(URL::to('/customer/aadhar',$propty_report_detail->adhar_card)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/aadhar',$propty_report_detail->adhar_card)); ?>" style="height:25px;width:45px;" class="ms-2"></a><?php endif; ?></td>
                            </tr>
                            <tr>
                                <th>Cheque_photo</th>
                                <td><?php if($propty_report_detail->cheque_photo !=''): ?><a href="<?php echo e(URL::to('/customer/cheque',$propty_report_detail->cheque_photo)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/cheque',$propty_report_detail->cheque_photo)); ?>" style="height:25px;width:45px;" class="ms-2"></a><?php endif; ?></td>
                            </tr>
                            <tr>
                                <th>Attachment</th>
                                <td><?php if($propty_report_detail->attachment !=''): ?><a href="<?php echo e(URL::to('/customer/attach',$propty_report_detail->attachment)); ?>" download target="_blank"><i class='far fa-file-alt'></i></a><?php endif; ?></td>
                            </tr>
                            

                        </tbody>
                    </table>
                    </div>
                </div>
                
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <?php if($propty_report_detail->cancel_reason !=''): ?>
     <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18"> Cancel Report Details</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">Report Details</li>-->
                <!--    </ol>-->
                <!--</div>-->

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">
                   
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">

                        <tbody>
                            <tr>
                                <th>Reason</th>
                                <td><?php echo e($propty_report_detail->cancel_reason); ?></td>
                            </tr>
                            
                             <tr>
                                <th>Person</th>
                                <td><?php echo e($propty_report_detail->cancel_by); ?></td>
                            </tr>
                             <tr>
                                <th>Cancel Time</th>
                                <td><?php echo e(date('d-M-y H:i:s', strtotime($propty_report_detail->cancel_time))); ?></td>
                            </tr>

                        </tbody>
                    </table>
                    </div>
                </div>
                
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <?php endif; ?>
    
        <?php if(isset($other_owner[0])): ?>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Other Owners Report Details</h4>

                

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">

                        <tbody>
                            
                            <tr>
                                <th>SN</th>
                                <th>Customer Name</th>
                                <th>Contact Number</th>
                                <th>Address</th>
                                <th>Pan Card</th>
                                <th>Addhar Card</th>
                                <th>Cheque_photo</th>
                                <th>Attachment</th>
                                
                            </tr>
                            <?php $sn=1; ?>
                              <?php $__currentLoopData = $other_owner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                  <th><?php echo e($sn); ?></th>
                                  <td><?php echo e($list->owner_name); ?></td>
                                  <td><?php echo e($list->contact_no); ?></td>
                                  <td><?php echo e($list->address); ?></td>
                                  <td><?php echo e($list->pan_card); ?> <?php if($list->pan_card_image !=''): ?><a href="<?php echo e(URL::to('/customer/pancard',$list->pan_card_image)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/pancard',$list->pan_card_image)); ?>"  class="ms-2" style="height:25px;width:45px;"></a><?php endif; ?></td>
                                  <td>
                                    <?php if($list->adhar_card !=''): ?><a href="<?php echo e(URL::to('/customer/aadhar',$list->adhar_card)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/aadhar',$list->adhar_card)); ?>"  style="height:25px;width:45px;"></a><?php endif; ?></td>
                                  <td><?php if($list->cheque_photo !=''): ?><a href="<?php echo e(URL::to('/customer/cheque',$list->cheque_photo)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/customer/cheque',$list->cheque_photo)); ?>" style="height:25px;width:45px;"></a><?php endif; ?></td>
                                  <td><?php if($list->attachment !=''): ?><a href="<?php echo e(URL::to('/customer/attach',$list->attachment)); ?>" download target="_blank"><i class='far fa-file-alt'></i></a><?php endif; ?></td>
                                  
                                </tr>
                                <?php $sn++; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <?php endif; ?>


</div> <!-- container-fluid -->

<!-- End Page-content -->

 
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bookingg/public_html/resources/views/scheme/report-detail.blade.php ENDPATH**/ ?>