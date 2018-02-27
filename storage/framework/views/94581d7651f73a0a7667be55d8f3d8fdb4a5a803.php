<?php $__env->startSection('header'); ?>
    <title><?php echo e($articul->title); ?> Timka.by</title>
    <meta name="description" content="<?php echo e($articul->meta_description); ?>">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('data'); ?>
    <div class="block_good">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="head">
            <h2><?php echo e($articul->name); ?></h2>
        </div>

        <div class="news">
       <?php echo $articul->content; ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>