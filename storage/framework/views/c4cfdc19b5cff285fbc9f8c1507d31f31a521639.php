<?php $__env->startSection('content'); ?>
    <h2>Редактирование предложение</h2>
    <p> <a target="_self" href="<?php echo e(route('admin::good_item_create',['id_good_item_group'=>$model->id_good_item_group])); ?>">
            Создать предложение в этом товаре
        </a></p>

    <br>
    <div id="tabs">
        <ul>
            <li><a href="#object">Предложение</a></li>
            <li><a href="#property">Свойства</a></li>
            <li>

            </li>
        </ul>
        <div id="object">
            <h3> Основные свойства </h3>
            <?php echo $__env->make('admin.forms.item', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div id="property">
            <h3> Дополнительные свойства </h3>
            <?php echo $__env->make('admin.listObjects.property_item', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>


    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>