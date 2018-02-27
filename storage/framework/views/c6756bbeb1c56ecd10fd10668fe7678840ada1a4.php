<?php $__env->startSection('data'); ?>

    <div class="block_good">
        <div class="head">
            <h2>Пароль изменен</h2>
        </div>
        <div class="profile">
            <h2>Пароль успешно изменен</h2>
            <a href="<?php echo e(route('user::profile')); ?>"> <span class="common-but">К профилю</span></a>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>