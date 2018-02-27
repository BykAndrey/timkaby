<?php $__env->startSection('content'); ?>
    <h2>Список товаров</h2>
    <ul class="controllers_list">
        <li><a href="<?php echo e(route('admin::good_item_create')); ?>">Создать новый товар</a></li>
    </ul>
    <table class="list">
        <colgroup>
            <col width="1%" span="1" style="background-color:#deffda">
            <col width="10%" span="1" style="background-color:#cedeff">

            <col width="10%" span="1" style="background-color:#deffda">
            <col width="5%" span="1" style="background-color:#cedeff">

            <col width="1%" span="1" style="background-color:#deffda">
            <col width="1%" span="1" style="background-color:#cedeff">
            <col width="1%" span="1" style="background-color:#cedeff">
            <col width="1%" span="1" style="background-color:#cedeff">
            <col width="1%" span="1" style="background-color:#cedeff">
            <col width="1%" span="1" style="background-color:#deffda">
        </colgroup>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>

            <th>Price</th>
            <th>Discount
                <a href="<?php echo e(route('admin::good_item',['page'=>1,
                'sortby'=>'discount-desc'
                ])); ?>">убв</a>
                <a href="<?php echo e(route('admin::good_item',['page'=>1,
                'sortby'=>'discount-asc'
                ])); ?>">возр</a>
            </th>
            <th>New</th>
            <th>Active
                <a href="<?php echo e(route('admin::good_item',['page'=>1,
                'sortby'=>'is-active-desc'
                ])); ?>">убв</a>
                <a href="<?php echo e(route('admin::good_item',['page'=>1,
                'sortby'=>'is-active-asc'
                ])); ?>">возр</a>
            
            
            </th>

            <th>
                Date
                <a href="<?php echo e(route('admin::good_item',['page'=>1,
                'sortby'=>'created-at-desc'
                ])); ?>">убв</a>
                <a href="<?php echo e(route('admin::good_item',['page'=>1,
                'sortby'=>'created-at-asc'
                ])); ?>">возр</a>
            </th>
            <th>Edit</th>
            <th>Delete</th>


        </tr>
        <?php foreach($items as $item): ?>
            <tr>
                <td><?php echo e($item->id); ?></td>
                <td>
                    <img src="<?php echo e(URL::asset($item->image)); ?>" alt="image" width="150">
                </td>
                <td><?php echo e($item->name); ?><br>
                <i><?php echo e($item->item_group); ?></i></td>

                <td>
                    <input type="text" onblur="setItemPrice(<?php echo e($item->id); ?>,this)" value="<?php echo e($item->price); ?>">
                </td>
                <td>
                    <input type="text" onblur="setItemDiscount(<?php echo e($item->id); ?>,this)" value="<?php echo e($item->discount); ?>">

                </td>

                <td>
                    <?php if($item->is_new==1): ?>
                        <div class="but but_green" onclick="setItemNew(<?php echo e($item->id); ?>,this)">

                        </div>
                    <?php else: ?>
                        <div class="but but_red" onclick="setItemNew(<?php echo e($item->id); ?>,this)">
                        </div>
                    <?php endif; ?>
                </td>


                <td>
                    <?php if($item->is_active==1): ?>
                        <div class="but but_green" onclick="setItemActive(<?php echo e($item->id); ?>,this)">

                        </div>
                    <?php else: ?>
                        <div class="but but_red" onclick="setItemActive(<?php echo e($item->id); ?>,this)">
                        </div>
                    <?php endif; ?>
                </td>

                <td><?php echo e($item->created_at); ?></td>
                <td>
                    <a href="<?php echo e(route('admin::good_item_edit',['id'=>$item->id])); ?>">Изменить</a>
                </td>
                <td><a href="<?php echo e(route('admin::good_item_delete',['id'=>$item->id])); ?>">Удалить</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php echo $__env->make('home.parts.elements.paginate',[
    'current_page'=>$current_page,
    'max_page'=>$max_page,
    'route'=>'admin::good_item',
    'routeParams'=>[
        'sortby'=>$sortby
    ]
    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(URL::asset('/static/js/admin/admin_item.js')); ?>"></script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>