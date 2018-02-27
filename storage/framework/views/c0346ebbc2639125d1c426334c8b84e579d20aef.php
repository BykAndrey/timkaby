<?php $__env->startSection('content'); ?>
    <h2>Создание фильтра свойства
        <a href="<?php echo e(route('admin::good_property_category_edit',['id'=>$property->id])); ?>"><u><i><?php echo e($property->name); ?></i></u></a>
        в категории
        <a href="<?php echo e(route('admin::good_category_edit',['id'=>$category->id])); ?>"><u><i><?php echo e($category->name); ?></i></u></a> </h2>

    <?php echo Form::open(['route'=>'admin::good_filter_category_create','method'=>'post']); ?>

    <table class="create">
        <tr><th>Поле</th><th>Значение</th></tr>
        <tr>
            <td>
                <?php echo Form::label('id_good_category','Категория'); ?>

            </td>
            <td>
                <?php echo Form::select('id_good_category',[]); ?>

            </td>
        </tr>
        <tr>
            <td>
                <?php echo Form::label('id_good_category','Свойство'); ?>

            </td>
            <td>
                <?php echo Form::select('id_good_category',[]); ?>

            </td>
        </tr>
        <tr>
            <td>
                <?php echo Form::label('name','Название'); ?>

            </td>
            <td>
                <?php echo Form::text('name'); ?>

            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Сохранить" class='save'>
            </td>
            <td>

            </td>
        </tr>
    </table>
    <?php echo Form::close(); ?>

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>