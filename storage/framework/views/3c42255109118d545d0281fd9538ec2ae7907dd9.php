
<?php $__env->startComponent('mail::message'); ?>
# Hello
Plot number <?php echo e($mailData['plot_no']); ?> at <?php echo e($mailData['scheme_name']); ?> has been cancelled and it going to available in 30 min On GKSM Plot Booking Platform !!

<br>

Thanks,<br><br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?><?php /**PATH /home/bookingg/public_html/resources/views/Email/cancelemail.blade.php ENDPATH**/ ?>