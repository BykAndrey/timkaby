<!-- ПРИ ДОБАВЛЕНИИ НУЖНО НАПИСАТЬ

 <div class="block_good">
 @includ  e('......block_good')
 </div>

 -->

<!--

{
    'name':'NAME',
    'tabs':{
        'name':'NAME',
        'id':0,
        'items':{},
    },
}




-->


<div class="block_good tabs" id="t">
    <div class="head">
        <h2><a href="<?php echo e(route('home::catalog',['url'=>$block['url']])); ?>"><?php echo e($block['name']); ?></a></h2>
        <ul>
            <?php 
            $i=0;
             ?>
            <?php foreach($block['tabs'] as $tab): ?>
                <?php if($i==0): ?>
                    <li><a href="#<?php echo e($tab['id']); ?>" class="tab active"><?php echo e($tab['name']); ?></a></li>
                    <?php else: ?>
                    <li><a href="#<?php echo e($tab['id']); ?>" class="tab "><?php echo e($tab['name']); ?></a></li>
                    <?php endif; ?>

                <?php 
                $i++;
                 ?>
                <?php endforeach; ?>

        </ul>
    </div>
    <?php 
        $i=0;
     ?>
    <?php foreach($block['tabs'] as $tab): ?>
        <?php if($i==0): ?>
            <div id="<?php echo e($tab['id']); ?>" class="tab-content active " style="opacity: 1;">
        <?php else: ?>
            <div id="<?php echo e($tab['id']); ?>" class="tab-content  " style="opacity: 0;">
        <?php endif; ?>


        <?php 
            $i++;
         ?>
        <div class="list_good">

          <?php foreach($tab['items'] as $item): ?>
          <?php echo $__env->make('home.parts.elements.good',['item'=>$item], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



<?php endforeach; ?>


        </div>
    </div>
  <?php endforeach; ?>
</div>
