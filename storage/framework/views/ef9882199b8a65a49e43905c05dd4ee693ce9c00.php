<?php $__env->startSection('content'); ?>
    <h2>Создание нового товара</h2>
    <?php echo $__env->make('admin.forms.item_group', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    <script src="<?php echo e(URL::asset('/static/js/admin/admin_item_group.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>