<?php $__env->startSection('content'); ?>
    <h2>Создать "Способ доставки"</h2>
    <?php echo $__env->make('admin.forms.option_delivery', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>