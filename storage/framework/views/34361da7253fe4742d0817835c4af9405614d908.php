

<?php $__env->startSection("content"); ?>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Teams</h4>

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
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                            <div class="page-title-right">
                                <a href="<?php echo e(URL::to('/add-team')); ?>" type="button" class="btn btn-success waves-effect waves-light">Add Team</a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Team Name</th>
                                <th>Team Description</th>
                                <th>Super Team</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                        <?php ($count=1); ?>
                            <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td><?php echo e($count); ?></td>
                                <td><?php echo e($attribute->team_name); ?></td>
                                <td><?php echo e($attribute->team_description); ?></td>
                                <td >
                                <?php if($attribute->super_team==1): ?>
                                    <a href="<?php echo e(route('superteam.status',['id'=>$attribute->public_id,'status'=>0])); ?>" data-toggle="tooltip" data-placement="top" title="Change Status" class="text-success">YES</a>
                                 <?php elseif($attribute->super_team==0): ?>
                                    <a href="<?php echo e(route('superteam.status',['id'=>$attribute->public_id,'status'=>1])); ?>" data-toggle="tooltip" data-placement="top" title="Change Status" class="text-warning">NO</a>
                                <?php endif; ?>
                                </td>
                                <td >
                                <?php if($attribute->status==1): ?>
                                    <a href="<?php echo e(route('team.status',['id'=>$attribute->public_id,'status'=>0])); ?>" data-toggle="tooltip" data-placement="top" title="Change Status" class="text-success">Active</a>
                                 <?php elseif($attribute->status==0): ?>
                                    <a href="<?php echo e(route('team.status',['id'=>$attribute->public_id,'status'=>1])); ?>" data-toggle="tooltip" data-placement="top" title="Change Status" class="text-warning">Deactive</a>
                                <?php endif; ?>
                                <!-- <a href="<?php echo e(route('attribute.edit', ['id' => $attribute->public_id])); ?>" data-toggle="tooltip" data-placement="top" title="Change Status"><?php echo e($attribute->status == 1 ? 'Active' : 'Deactive'); ?></a> --> </td> 
                                <td>
                                    <a href="<?php echo e(route('team.edit', ['id' => $attribute->public_id])); ?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt text-primary"></i></a>
                                    <!-- <a onclick="return confirm('Are you sure you want to delete ?')" href="<?php echo e(route('attribute.destroy', ['id' => $attribute->public_id])); ?>" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-recycle text-danger"></i></a> -->
                                    <a  href="<?php echo e(route('team.view', ['id' => $attribute->public_id])); ?>" data-toggle="tooltip" data-placement="top" title="view"><i class="fas fa-user-alt text-success"></i></a>
                                </td>

                            </tr>
                            <?php ($count++); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bookingg/public_html/resources/views/team/team.blade.php ENDPATH**/ ?>