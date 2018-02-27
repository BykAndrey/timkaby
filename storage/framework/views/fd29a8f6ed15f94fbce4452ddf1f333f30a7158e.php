<?php $__env->startSection('header'); ?>
    <title>Заказ номер <?php echo e($order->id); ?></title>
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('tree'); ?>
    <?php echo $__env->make('user.tree', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('data'); ?>
        <div class="block_good">
            <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="head">
                <h2><a href="">Заказ номер <?php echo e($order->id); ?>.<br> Статус
                    <?php echo $__env->make('user.state',['status'=>$order->status], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    </a></h2>
            </div>
            <div class="profile">
                <table class="order_list">
                    <tr>
                        <th>Фото</th>
                        <th>Название</th>
                        <th>Количество</th>
                        <th>Цена (шт)</th>
                        <th>Полная стоимость</th>

                    </tr>
                    <?php foreach($items as $item): ?>
                        <tr>
                            <td>
                                <img src="/<?php echo e($item->image); ?>" alt="">
                            </td>
                            <td>
                                <a href="<?php echo e($item->url); ?>"><?php echo e($item->name); ?></a>
                            </td>
                            <td>
                                <?php echo e($item->count); ?>

                            </td>
                            <td>
                                <?php echo e($item->price); ?>&nbsp;р.
                            </td>
                            <td>
                                <?php echo e($item->count*$item->price); ?>&nbsp;р.
                            </td>

                        </tr>
                        <?php endforeach; ?>
                </table>
                <div class="order">
                    <h3 class="head">Общая информация</h3>
                    <?php if(Auth::user()->id_role==0): ?>
                        <form action="<?php echo e(route('user::orderState')); ?>" method="post">
                            <?php endif; ?>
                        <?php echo e(csrf_field()); ?>

                    <table>
                        <tr>
                            <td>Имя:</td>
                            <td><?php echo e($order->name); ?></td>
                        </tr>
                        <tr>
                            <td>Телефон:</td>
                            <td><?php echo e($order->phone); ?></td>
                        </tr>

                        <tr>
                            <td>Адрес доставки:</td>
                            <td><?php echo e($order->adress); ?></td>
                        </tr>
                        <tr>
                            <td>Комментарий:</td>
                            <td><?php echo e($order->feature); ?></td>
                        </tr>
                        <?php if(Auth::user()->id_role==0): ?>  <tr>
                            <td>Статус:</td>
                            <td>
                                <input type="hidden" value="<?php echo e($order->id); ?>" name="id">
                                <select name="status" id="" class="common-select common-select_width_full common-select_margin_no">
                                    <option value="-1"
                                            <?php  $order->status==-1?print ('selected'):null  ?>>
                                        Анулирован
                                    </option>

                                    <option value="0"
                                            <?php  $order->status==0?print ('selected'):null  ?>>
                                        В обработке
                                    </option>

                                    <option value="1"
                                            <?php  $order->status==1?print ('selected'):null  ?>>
                                        Доставляется
                                    </option>

                                    <option value="2"
                                            <?php  $order->status==2?print ('selected'):null  ?>>
                                        Выполнено
                                    </option>

                                </select>
                            </td>
                        </tr>
                    <?php endif; ?>
                        <tr>
                            <td>Стоимость товара:</td>
                            <td><?php echo e(sprintf('%.2f',$order->total_price)); ?>&nbsp;р.</td>
                        </tr>
                        <tr>
                            <td>Стоимость доставки:</td>
                            <td><?php echo e(sprintf('%.2f',$order->delivery_price)); ?>&nbsp;р.</td>
                        </tr>
                        <tr>
                            <td>ИТОГО:</td>
                            <td><?php echo e(sprintf('%.2f',$order->total_price+$order->delivery_price)); ?>&nbsp;р.</td>
                        </tr>
                    </table>
                            <?php if(Auth::user()->id_role==0): ?>
                                <input type="submit" value="Сохранить" class="common-but common-but_width_full"/>
                    </form>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>