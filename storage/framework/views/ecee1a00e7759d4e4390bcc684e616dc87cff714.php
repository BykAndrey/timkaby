<?php $__env->startSection('content'); ?>
    <h2>Создать Пользователя</h2>
    <?php echo $__env->make('admin.forms.users', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $('#phone').mask('+375 (99) 999-99-99');
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>