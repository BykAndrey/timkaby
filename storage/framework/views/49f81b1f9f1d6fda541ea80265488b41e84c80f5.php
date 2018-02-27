<div class="good middle">
    <?php if($item->discount>0): ?>
        <div class="flag_discount">
            <img src="<?php echo e(URL::asset('/static/img/red_flag.svg')); ?>" width="90" alt="RED FLAG">
            <p>-<?php echo e($item->discount); ?>%</p>
        </div>
    <?php endif; ?>
    <a href="<?php echo e(route('home::card',['caturl'=>$item->caturl,'url'=>$item->url])); ?>">

        <div class="image" style="background-image:url('<?php echo e(URL::asset(\App\ItemGroup::getImage($item->image,200,null))); ?>')">

        </div>
    </a>
    <div class="info">
        <h5><a href="<?php echo e(route('home::card',['caturl'=>$item->caturl,'url'=>$item->url])); ?>"><?php echo e($item->name); ?></a></h5>
        <p><?php echo e(sprintf('%.2f',$item->price)); ?> р.
            <?php if($item->discount>0): ?>
                <strike><?php echo e(sprintf('%.2f',$item->old_price)); ?>&nbsp;р.</strike>


               <!-- <span class="discount">-<?php echo e($item->discount); ?>%</span>-->
        <?php endif; ?></p>
       <div title="Рейтинг товара">

           <?php echo $__env->make('home.parts.elements.rating',['rating'=>$item->rating,'size'=>'14'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

        <div class="cntrls">


        <div class="common-but common-but-clear">
            <div class="common-but-left common-but " onclick="addToCart(<?php echo e($item->id); ?>)">В корзину</div>
            <div class="common-but-right common-but " onclick="addToFavorite(<?php echo e($item->id); ?>)" title="Добавить в избранное">
                <img src="<?php echo e(URL::asset('static/img/like.svg')); ?>" alt="Нравится" width="20">
            </div>
        </div>
        </div>
    </div>
</div>