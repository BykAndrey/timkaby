<?php 


/*['page'=>$current_page-1]*/
 ?>


<div class="paginate">

    <?php if($current_page!=1): ?>
        <a href="<?php echo e(route($route,array_merge(['page'=>$current_page-1],isset($routeParams)?$routeParams:[]))); ?>">
            <div class="point"><<</div>
        </a>
    <?php endif; ?>
    <?php for($i=-2;$i<3;$i++): ?>
        <?php if(($current_page+$i)>0): ?>

            <?php if(($max_page>=$current_page+$i)): ?>

                <a href="<?php echo e(route($route,array_merge(['page'=>$current_page+$i],isset($routeParams)?$routeParams:[]))); ?>">
                    <div class="point <?php echo e($i==0?print(' selected '):null); ?>"><?php echo e($current_page+$i); ?></div>
                </a>
            <?php endif; ?>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if($max_page>$current_page+1): ?>
        <a href="<?php echo e(route($route,array_merge(['page'=>$current_page+1],isset($routeParams)?$routeParams:[]))); ?>">
            <div class="point">>></div>
        </a>
    <?php endif; ?>
</div>