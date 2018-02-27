<?php 
    $rate=$rating;

 ?>
<?php for($i=0;$i<5;$i++): ?>
    <?php if($rate>=1): ?>
        <img src="<?php echo e(URL::asset('static/img/star-full.svg')); ?>" width="<?php echo e($size); ?>" alt="<?php echo e($rating); ?>">

        <?php 
            $rate--;
         ?>

    <?php else: ?>
        <?php if($rate>=0.5): ?>
            <img src="<?php echo e(URL::asset('static/img/star-half.svg')); ?>" width="<?php echo e($size); ?>" alt="<?php echo e($rating); ?>">
            <?php 
                $rate=0;
             ?>
        <?php else: ?>
            <img src="<?php echo e(URL::asset('static/img/star-empty.svg')); ?>" width="<?php echo e($size); ?>" alt="<?php echo e($rating); ?>">
            <?php 
                $rate=0;
             ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endfor; ?>