<?php $__env->startSection('content'); ?>
    <h2>Информационные страницы</h2>
    <ul class="controllers_list">
        <li><a href="<?php echo e(route('admin::info_page_create')); ?>">Добавить страницу</a></li>
    </ul>
    <table>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Название
                </th>
                <th>
                    Дата создания
                </th>
                <th>
                    Активный
                </th>
                <th>
                    Редактировать
                </th>
                <th>
                    Удалить
                </th>
            </tr>



        <?php foreach($items as $item): ?>
            <tr>
                <td>
                    <?php echo e($item->id); ?>

                </td>
                <td>
                    <?php echo e($item->name); ?>

                </td>
                <td>
                    <?php echo e($item->created_at); ?>

                </td>
                <td>

                    <?php echo e($item->is_active); ?>

                </td>
                <td>
                    <a href="<?php echo e(route('admin::info_page_edit',['id'=>$item->id])); ?>">Редактировать</a>
                </td>
                <td>
                    <a href="<?php echo e(route('admin::info_page_delete',['id'=>$item->id])); ?>">Удалить</a>
                </td>
            </tr>
            <?php endforeach; ?>
    </table>
    <?php echo $__env->make('home.parts.elements.paginate',[
   'current_page'=>$current_page,
   'max_page'=>$max_page,
   'route'=>'admin::info_page'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>