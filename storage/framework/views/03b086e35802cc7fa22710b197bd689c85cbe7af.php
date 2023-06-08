<?php $__env->startComponent('mail::message'); ?>
# Hello
Your <?php if($mailData['status']==2): ?> Booked <?php else: ?> Hold <?php endif; ?> plot number <?php echo e($mailData['plot_no']); ?> at <?php echo e($mailData['scheme_name']); ?> has been cancelled by <?php echo e($mailData['name']); ?> On GKSM Plot Booking Platform !!

<br>

Thanks,<br><br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home/bookingg/public_html/resources/views/Email/bookedplotcancel.blade.php ENDPATH**/ ?>