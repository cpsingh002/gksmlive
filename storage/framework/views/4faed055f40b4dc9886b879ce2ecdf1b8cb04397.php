<?php $__env->startSection("content"); ?>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Associates</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">Associates</li>-->
                <!--    </ol>-->
                <!--</div>-->

            </div>
        </div>
        <div class="col-md-4 col-12">
            <?php if(session('status')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong> <?php echo e(session('status')); ?></strong>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
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
                                <a href="<?php echo e(URL::to('/add-associate')); ?>" type="button" class="btn btn-success waves-effect waves-light">Add Associate</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                       <table id="myTable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Associate Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Rera Number</th>
                                <th>Team</th>
                                <th>Associate Uplinner Name</th>
                                <th>Associate Uplinner Rera Number</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php ($count=1); ?>
                            <?php $__currentLoopData = $associates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $associate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            
                            <tr>
                                <td> <?php echo e($count); ?> </td>
                                <td><?php echo e($associate->name); ?></td>
                                <!-- <td><?php echo e($associate->public_id); ?></td> -->
                                <td><?php echo e($associate->email); ?></td>
                                <td><?php echo e($associate->mobile_number); ?></td>
                                <td><?php echo e($associate->associate_rera_number ? $associate->associate_rera_number : '-'); ?></td>
                                <td><?php echo e($associate->team_name); ?></td>
                                 <td><?php echo e($associate->applier_name); ?></td>
                                <td><?php echo e($associate->applier_rera_number); ?></td>
                                <td class="<?php echo e($associate->status == 1 ? 'text-success' : 'text-danger'); ?>"><?php echo e($associate->status == 1 ? 'Active' : 'Deactive'); ?></td>
                                <td>
                                    <a href="<?php echo e(route('edit-user.user', ['id' => $associate->public_id])); ?>"><i class="fas fa-pencil-alt text-primary" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                    <a onclick="return confirm('Are you sure you want to delete associate ?')" href="<?php echo e(route('user.destroy', ['id' => $associate->public_id])); ?>" data-toggle="tooltip" data-placement="top" title="Delete User"><i class="fas fa-recycle text-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                    <?php if($associate->status == 1): ?>
                                    <a href="<?php echo e(route('view.user', ['id' => $associate->public_id])); ?>" data-toggle="tooltip" data-placement="top" title="View Info"><i class="fas fa-user-alt text-success"></i></a>
                                    <?php endif; ?>
                                    <?php if($associate->status !=5): ?>
                                    <a onclick="return confirm('Are you sure you want to deactive associate ?')" href="<?php echo e(route('user.deactivate', ['id' => $associate->public_id, 'status' => 1])); ?>" data-toggle="tooltip" data-placement="top" title="Deactivate User"><i class="fas fa-eye text-success" data-toggle="tooltip" data-placement="top" title="Deactivate"></i></a>
                                    <?php else: ?>
                                    <a onclick="return confirm('Are you sure you want to active associate again ?')" href="<?php echo e(route('user.activate', ['id' => $associate->public_id, 'status' => 5])); ?>" data-toggle="tooltip" data-placement="top" title="Deactivate User"><i class="fas fa-eye-slash text-danger" data-toggle="tooltip" data-placement="top" title="Deactivate"></i></a>
                                    <?php endif; ?>
                                    
                                    <a onclick="change_password('<?php echo e($associate->public_id); ?>')"><i class="fa fa-unlock-alt text-info" data-toggle="tooltip" data-placement="top" title="Change Password"></i></a>
                                      <!--<input type="button" id="ImageHosting" value="To Image Hosting" onclick="ImageHosting_Click()"/>-->

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
    
    
    <div id="myModal123" class="modal fade show mt-5 pt-5" tabindex="-1" aria-labelledby="myModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form role="form" method="post" action="<?php echo e(url('associates/change-password')); ?>">
                         <?php echo csrf_field(); ?>
                <div class="modal-body">
                <input type="hidden" name="id"  id="extendid"/>
                        <div class="form-group" >
                            <label>Password</label>
                            <input type="password" class="form-control mb-2"  name="password" placeholder="password"/>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary ">Submit</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
   function change_password(id){
    var ghh = id;
   
        $("#extendid").val(ghh);
     //alert(ghh);
    $('#myModal123').modal('show');
}
</script>









</div> <!-- container-fluid -->

<!-- End Page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("dashboard.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\gksm\resources\views/associate/associates.blade.php ENDPATH**/ ?>