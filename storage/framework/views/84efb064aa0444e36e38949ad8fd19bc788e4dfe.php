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
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                            <div class="page-title-right">
                                <a href="<?php echo e(URL::to('/add-attribute')); ?>" type="button" class="btn btn-success waves-effect waves-light">Add Attribute</a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Attribute Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td><?php echo e($attribute->public_id); ?></td>
                                <td><?php echo e($attribute->attribute_name); ?></td>
                                <td class="<?php echo e($attribute->status == 1 ? 'text-success' : 'text-danger'); ?>"><?php echo e($attribute->status == 1 ? 'Active' : 'Deactive'); ?></td>
                                <td>
                                    <a href="<?php echo e(route('attribute.edit', ['id' => $attribute->public_id])); ?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt text-primary"></i></a>
                                    <a href="<?php echo e(route('attribute.destroy', ['id' => $attribute->public_id])); ?>" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-recycle text-danger"></i></a>
                                </td>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- container-fluid -->

<!-- End Page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\associate\resources\views/attribute/attributes.blade.php ENDPATH**/ ?>