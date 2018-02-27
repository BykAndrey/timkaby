<?php $__env->startSection('header'); ?>
    <title><?php echo e($title); ?></title>
    <meta name="description" content="<?php echo e($description); ?>"/>
<?php $__env->stopSection(); ?>




<?php $__env->startSection('data'); ?>

    <div itemscope itemtype="http://schema.org/Product" class="block_good" id="catalog">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="head">
            <h2 itemprop="name"><?php echo e($name); ?></h2>
            <div  itemtype="http://schema.org/AggregateOffer" itemscope itemprop="offers">
                <meta content="<?php echo e($count_goods); ?>" itemprop="offerCount">
                <meta content="<?php echo e($max_price); ?>" itemprop="highPrice">
                <meta content="<?php echo e($min_price); ?>" itemprop="lowPrice">
                <meta content="BYN" itemprop="priceCurrency">
            </div>
        </div>
        <div class="sorting">
            <div>
                <span>Сортировать по:</span>
                <select name="sortby" id="sortby" onchange="window.location.href='<?php echo e(route('home::base_catalog',[
                'page'=>1,
                'size'=>$good_size])); ?>&sorting='+this.value">
                    <option <?php echo e($good_sorting==1?'selected':null); ?> value="1">Цена (убывание)</option>
                    <option <?php echo e($good_sorting==2?'selected':null); ?> value="2">Цена (возрастание)</option>
                    <option <?php echo e($good_sorting==3?'selected':null); ?> value="3">Популярность (убывание)</option>
                    <option <?php echo e($good_sorting==4?'selected':null); ?> value="4">Популярность (возрастание)</option>
                </select>
            </div>


            <div>
                <span>Показывать по:</span>
                <select name="size" id="size" onchange="window.location.href='<?php echo e(route('home::base_catalog',[
                'page'=>1,
                'sorting'=>$good_sorting])); ?>&size='+this.value">
                    <option <?php echo e($good_size==20?'selected':null); ?> value="20">20</option>
                    <option <?php echo e($good_size==40?'selected':null); ?> value="40">40</option>
                    <option <?php echo e($good_size==60?'selected':null); ?> value="60">60</option>
                </select>
            </div>

        </div>
        <div class="list_good">

            <?php foreach($list_goods as $item): ?>

                <?php echo $__env->make('home.parts.elements.good',['item'=>$item], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <?php endforeach; ?>

        </div>
    <?php echo $__env->make('home.parts.elements.paginate',['current_page'=>$current_page,
    'max_page'=>$count_pages,
    'route'=>'home::base_catalog',
    'routeParams'=>[
    'size'=>$good_size,
    'sorting'=>$good_sorting,
    'is_new'=>$is_new

    ]], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
   /*     var base_catalog=new Vue({
            el
        })*/
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>