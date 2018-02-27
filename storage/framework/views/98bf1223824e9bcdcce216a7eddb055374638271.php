<?php $__env->startSection('header'); ?>
    <title>Мои заказы</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('tree'); ?>
    <?php echo $__env->make('user.tree', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('data'); ?>
    <div class="block_good">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="head">
            <h2>Мои заказы</h2>
        </div>
        <div class="profile" id="profile">
            <table class="order_list">
                <colgroup>
                    <col width="5%">
                    <col width="25%">
                    <col width="25%">
                    <col width="20%">
                </colgroup>
                <tr>
                    <th>
                        Номер заказа
                    </th>
                    <th>
                        Дата
                    </th>
                    <th>Стоимость</th>
                    <th>Количество</th>
                    <th>
                        Статус заказа
                    </th>
                </tr>
                <?php foreach($my_orders as $order): ?>
                    <tr>
                        <td>
                            <?php echo e($order->id); ?>

                        </td>
                        <td>
                            <a href="<?php echo e(route('user::myorder',['id'=>$order->id])); ?>">
                                <?php echo e($order->created_at); ?>

                            </a>
                        </td>
                        <td>
                            <?php echo e($order->total_price); ?> р.
                        </td>
                        <td>
                            <?php echo e($order->count); ?>

                        </td>
                        <td>
                            <?php echo $__env->make('user.state',['status'=>$order->status], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <div class="paginate">
                <?php if($current_page!=1): ?>
                <a href="<?php echo e(route($route,['page'=>$current_page-1])); ?>">
                    <div class="point"><<</div>
                </a>
                <?php endif; ?>
                <?php for($i=-1;$i<3;$i++): ?>
                    <?php if(($current_page+$i)!=0): ?>

                        <?php if(($max_page>=$current_page+$i)): ?>

                            <a href="<?php echo e(route($route,['page'=>$current_page+$i])); ?>">
                                <div class="point <?php echo e($i==0?print(' selected '):null); ?>"><?php echo e($current_page+$i); ?></div>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if($max_page>$current_page+1): ?>
                <a href="<?php echo e(route($route,['page'=>$current_page+1])); ?>">
                    <div class="point">>></div>
                </a>
                    <?php endif; ?>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>