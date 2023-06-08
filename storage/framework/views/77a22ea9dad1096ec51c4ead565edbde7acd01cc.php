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
                                <td><a href="<?php echo e(URL::to('/files',$scheme_details[0]->scheme_img)); ?>" download target="_blank"><?php echo e($scheme_details[0]->scheme_img); ?></a></td>
                                <!-- <td><img src="<?php echo e(URL::to('/files',$scheme_details[0]->scheme_img)); ?>" width="50"/></td> -->
                            </tr>

                            <tr>
                                <th>Scheme Brochure</th>
                                <td><a href="<?php echo e(URL::to('/brochure',$scheme_details[0]->brochure)); ?>" download target="_blank"><?php echo e($scheme_details[0]->brochure); ?></a></td>
                            </tr>

                            <tr>
                                <th>Scheme ppt</th>
                                <td><a href="<?php echo e(URL::to('/ppt',$scheme_details[0]->brochure)); ?>" download target="_blank"><?php echo e($scheme_details[0]->ppt); ?></a></td>
                            </tr>

                            <tr>
                                <th>Scheme Jda Map</th>
                                <td><a href="<?php echo e(URL::to('/jda_map',$scheme_details[0]->brochure)); ?>" download target="_blank"><?php echo e($scheme_details[0]->jda_map); ?></a></td>
                            </tr>

                            <tr>
                                <th>Scheme Description</th>
                                <td><?php echo e($scheme_details[0]->scheme_description); ?></td>
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
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\associate\resources\views/scheme/scheme.blade.php ENDPATH**/ ?>