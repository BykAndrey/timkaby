<?php $__env->startSection('header'); ?>
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('data'); ?>
    <div class="block_good">
        <div class="head"></div>
        <div>
            <h1>Спасибо за покупку</h1>
            <p class="help">Наш специалист свяжется с вами в ближайшее время</p>
            <a href="<?php echo e(route('home')); ?>">
                <div class="common-but">
                    На главную
                </div>
            </a>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>