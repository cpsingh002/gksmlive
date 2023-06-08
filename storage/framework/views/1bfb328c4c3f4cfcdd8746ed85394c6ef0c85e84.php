<?php $__env->startComponent('mail::message'); ?>
# Hello
Your booked plot number <?php echo e($mailData['plot_no']); ?> at <?php echo e($mailData['scheme_name']); ?> has been cancelled by <?php echo e($mailData['name']); ?> On GKSM Plot Booking Platform !!

<br>

Thanks,<br><br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home/dmlux/public_html/project/resources/views/Email/bookedplotcancel.blade.php ENDPATH**/ ?>