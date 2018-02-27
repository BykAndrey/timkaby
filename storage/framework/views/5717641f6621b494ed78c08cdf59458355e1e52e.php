<?php $__env->startSection('content'); ?>

    <div>
        <form action="<?php echo e(route('admin::load_goods')); ?>" method="post">
            <?php echo e(csrf_field()); ?>

            <input type="text" name="name">
            <?php echo Form::select('id_good_category', $category_list,old('') ); ?>

            <input type="submit">
        </form>
    </div>

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>