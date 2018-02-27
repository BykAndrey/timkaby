<?php $__env->startSection('content'); ?>
    <p class="pay_attention">Все связанные данные будут автоматически удалены</p>
    <p class="warning">Вы уверены? </p>
    <form action="<?php echo e($route); ?>" method="post">
        <?php echo e(csrf_field()); ?>

        <input type="submit" class="save" value="Удалить <?php echo e($name); ?>">
    </form>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>