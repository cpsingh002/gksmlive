<?php $__env->startComponent('mail::message'); ?>
# Hello <?php echo e($mailData['name']); ?>,
You have succesfuly  booked plot number <?php echo e($mailData['plot_no']); ?> at <?php echo e($mailData['scheme_name']); ?> On GKSM Plot Booking Platform !!

<br>


Thanks,<br><br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home/dmlux/public_html/project/resources/views/Email/bookedplotdetails.blade.php ENDPATH**/ ?>