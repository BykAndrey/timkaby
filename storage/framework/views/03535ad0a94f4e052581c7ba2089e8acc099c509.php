<?php $__env->startSection('content'); ?>
    <h2>Список Пользователей</h2>
    <ul class="controllers_list">
        <li><a href="<?php echo e(route('admin::users_create')); ?>">Добавить Пользователя</a></li>
    </ul>
    <table class="list">
        <caption>
            <th>
                ID
            </th>
            <th>
                Имя
            </th>
            <th>

            </th>
            <th></th>
        </caption>
        <?php foreach($users as $item): ?>
            <tr>
                <td>
                    <?php echo e($item->id); ?>


                </td>
                <td>
                    <?php echo e($item->name); ?>


                </td>
                <td>
                    <a href="<?php echo e(route('admin::users_edit',['id'=>$item->id])); ?>"> Редактировать</a>
                </td>
                <td>

                    <a href="<?php echo e(route('admin::good_brand_delete',['id'=>$item->id])); ?>">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php echo $__env->make('home.parts.elements.paginate',[
   'current_page'=>$current_page,
   'max_page'=>$max_page,
   'route'=>'admin::users'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>