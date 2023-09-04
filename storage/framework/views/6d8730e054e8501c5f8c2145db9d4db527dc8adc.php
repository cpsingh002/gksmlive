

<?php $__env->startSection("content"); ?>
<style>
    .far{
        font-size:26px;
    }
</style>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Scheme Details</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">DataTables</li>-->
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
                        <form class="needs-validation" method="post" action="<?php echo e(route('property_plot.update')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="scheme_id" value="<?php echo e($property->property_public_id); ?>">
                          <?php  $i=1; ?>
                            <?php $__currentLoopData = json_decode($property->attributes_data); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th><?php echo e($key); ?></th>
                                <td><input type="text" name="atrriu_<?php echo e($i); ?>" value="<?php echo e($attr); ?>" class="form-control"></td>
                                <?php $i++; ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="scheme_id" value="<?php echo e($property->property_public_id); ?>">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                               
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- container-fluid -->

<!-- End Page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\gksm\resources\views/scheme/update-property.blade.php ENDPATH**/ ?>