<?php $__env->startComponent('mail::message'); ?>
# Hello <?php echo e($mailData['name']); ?> , 
your one time  login password is  <b><?php echo e($mailData['rand_id']); ?> </b>
<br>
<br> Please Login On GKSM Plot Booking Platform and and change your password !!
<br>
<br>


Thanks,<br><br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?><?php /**PATH /home/dmlux/public_html/project/resources/views/Email/forgot_password.blade.php ENDPATH**/ ?>