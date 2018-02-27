<?php $__env->startSection('content'); ?>
    <h2>Список товаров</h2>
    <ul class="controllers_list">
        <li><a href="<?php echo e(route('admin::option_delivery_create')); ?>">Создать новый товар</a></li>
    </ul>
    <table class="list">
        <colgroup>
            <col width="1%" span="1" style="background-color:#deffda">
            <col width="10%" span="1" style="background-color:#cedeff">

            <col width="10%" span="1" style="background-color:#deffda">
            <col width="5%" span="1" style="background-color:#cedeff">

            <col width="1%" span="1" style="background-color:#deffda">
            <col width="1%" span="1" style="background-color:#cedeff">
            <col width="1%" span="1" style="background-color:#deffda">
        </colgroup>
        <tr>
            <th>ID</th>

            <th>Name</th>
            <th>Price</th>
            <th>Text price</th>
            <th>Edit</th>
            <th>Delete</th>


        </tr>
        <?php foreach($items as $item): ?>
            <tr>
                <td><?php echo e($item->id); ?></td>

                <td><?php echo e($item->name); ?></td>
                <td><?php echo e($item->price); ?></td>
                <td><?php echo e($item->text_price); ?></td>
                <td><a href="<?php echo e(route('admin::option_delivery_edit',['id'=>$item->id])); ?>">Изменить</a>
                </td><td><a href="<?php echo e(route('admin::option_delivery_delete',['id'=>$item->id])); ?>">Удалить</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php echo $__env->make('home.parts.elements.paginate',[
    'current_page'=>$current_page,
    'max_page'=>$max_page,
    'route'=>'admin::option_delivery'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>