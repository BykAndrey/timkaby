<?php $__env->startSection('header'); ?>
    <title>Понравившиеся товары</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('tree'); ?>
    <?php echo $__env->make('user.tree', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('data'); ?>
    <div class="block_good">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="head">
            <h2>Избранное</h2>

        </div>
        <div class="profile">
            <div class="help">При новой скидке Вы получите уведомление на указанный еmail.</div>
            <?php if(count($listLikeGoods)==0): ?>
                <div class="help help-error">У Вас нет понравившихся товаров.</div>
                <?php endif; ?>
            <table class="order_list">
                <tr>
                    <th>Картинка</th>
                    <th>Название</th>
                    <th>Стоимость</th>
                    <th>Удалить</th>
                </tr>
                <?php foreach($listLikeGoods as $item): ?>
                    <tr>
                        <td><img src="/<?php echo e($item->image); ?>" alt="<?php echo e($item->name); ?>"></td>
                        <td><a href="<?php echo e($item->url); ?>"><?php echo e($item->name); ?></a>
                            <br>

                            <?php echo $__env->make('home.parts.elements.rating',['rating'=>$item->rating,'size'=>10], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </td>
                        <td><?php echo e(sprintf('%.2f',$item->price)); ?>&nbsp;р.
                            <?php if($item->discount>0): ?>
                                    <br>
                                    <span>Скидка: -<?php echo e($item->discount); ?>%</span>
                                <?php endif; ?>
                        </td>
                        <td>

                                <div class="common-but" onclick="removeFromFavorite(<?php echo e($item->id); ?>,this);">Удалить</div>

                        </td>
                    </tr>
                    <?php endforeach; ?>
            </table>
            <?php echo $__env->make('home.parts.elements.paginate',['route'=>$paginate_route,
            'current_page'=>$current_page,
            'max_page'=>$max_page], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>