<?php $__env->startSection('header'); ?>
    <title><?php echo e($page->title); ?> -Timka.by </title>
    <meta name="description" content="<?php echo e($page->meta_description); ?>"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('data'); ?>

    <div class="block_good">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="head">
            <h2><a href=""><?php echo e($page->name); ?></a></h2>
        </div>

        <div><?php echo $page->content; ?></div>
    </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>