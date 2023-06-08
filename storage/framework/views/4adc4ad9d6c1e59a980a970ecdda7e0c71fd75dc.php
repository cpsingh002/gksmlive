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

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">

                        <tbody>
                            <tr>
                                <th>Scheme Name</th>
                                <td><?php echo e($scheme_details[0]->scheme_name); ?></td>
                            </tr>
                            <tr>
                                <th>Total Plot</th>
                                <td><?php echo e($scheme_details[0]->no_of_plot); ?></td>
                            </tr>

                            <tr>
                                <th>Scheme Location</th>
                                <td><?php echo e($scheme_details[0]->location); ?></td>
                            </tr>

                            <tr>
                                <th>Scheme Image</th>
                                <td><a href="<?php echo e(URL::to('/files',$scheme_details[0]->scheme_img)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/files',$scheme_details[0]->scheme_img)); ?>" width="50" /></a></td>

                            </tr>

                            <tr>
                                <th>Scheme Images</th>
                                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="w-25"><a href="<?php echo e(URL::to('/files',$image)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/files',$image)); ?>" width="50" /></a></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>

                            <tr>
                                <th>Scheme Brochure</th>
                                <td><a href="<?php echo e(URL::to('/brochure',$scheme_details[0]->brochure)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/brochure',$scheme_details[0]->brochure)); ?>" width="50" /></a></td>
                            </tr>

                            <tr>
                                <th>Scheme ppt</th>
                                <td><a href="<?php echo e(URL::to('/ppt',$scheme_details[0]->ppt)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/ppt',$scheme_details[0]->ppt)); ?>" width="50" /></a></td>
                            </tr>

                            <tr>
                                <th>Scheme Jda Map</th>
                                <td><a href="<?php echo e(URL::to('/jda_map',$scheme_details[0]->jda_map)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/ppt',$scheme_details[0]->jda_map)); ?>" width="50" /></a></td>
                            </tr>
                            <tr>
                                <th>Scheme Video</th>
                                <td><a href="<?php echo e(URL::to('/video',$scheme_details[0]->video)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/ppt',$scheme_details[0]->video)); ?>" width="50" /></a></td>
                            </tr>

                            <tr>
                                <th>Scheme pra</th>
                                <td><a href="<?php echo e(URL::to('/pra',$scheme_details[0]->pra)); ?>" download target="_blank"><img src="<?php echo e(URL::to('/ppt',$scheme_details[0]->pra)); ?>" width="50" /></a></td>
                            </tr>

                            <tr>
                                <th>Scheme Description</th>
                                <td><?php echo e(strip_tags(htmlspecialchars_decode($scheme_details[0]->scheme_description))); ?></td>
                            </tr>

                            <tr>
                                <th>Bank Name</th>
                                <td><?php echo e($scheme_details[0]->bank_name); ?></td>
                            </tr>

                            <tr>
                                <th>Account Number</th>
                                <td><?php echo e($scheme_details[0]->account_number); ?></td>
                            </tr>

                            <tr>
                                <th>IFSC Code</th>
                                <td><?php echo e($scheme_details[0]->ifsc_code); ?></td>
                            </tr>

                            <tr>
                                <th>Branch Name</th>
                                <td><?php echo e($scheme_details[0]->branch_name); ?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- container-fluid -->

<!-- End Page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\realstate_dashboard\resources\views/scheme/scheme.blade.php ENDPATH**/ ?>