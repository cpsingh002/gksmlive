<?php $__env->startComponent('mail::message'); ?>
# Hello,

Your booked plot number <?php echo e($mailData['plot_no']); ?> at <?php echo e($mailData['scheme_name']); ?> has been completed by <?php echo e($mailData['name']); ?> On GKSM Plot Booking Platform !!
<br>


Thanks,<br><br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home/bookingg/public_html/resources/views/Email/bookedplotcomplete.blade.php ENDPATH**/ ?>