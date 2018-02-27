<?php $__env->startSection('header'); ?>
    <title><?php echo e($title_main_page); ?></title>
    <meta name="description" content="<?php echo e($seo_description_main_page); ?>"/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('data'); ?>
<?php if(count($slides)>0): ?>
        <div class="slider-home">
            <div class="display">
                <?php 
                    $iter=0;
                 ?>
                <?php foreach($slides as $slide): ?>
                    <div class="slide <?php if($iter==0): ?> active <?php endif; ?>" style="background-image: url('/<?php echo e(\App\ItemGroup::getImage($slide->image,830,null,\App\Http\Controllers\Admin\BaseAdminController::$pathslideImage)); ?>')">
                         <div class="info">
                             <div class="name">
                                 <?php echo $slide->name; ?>



                                 <?php if($slide->discount>0): ?>
                                        <span>-<?php echo e($slide->discount); ?>%</span>
                                     <?php endif; ?>
                             </div>
                             <div class="description">
                                 <?php echo $slide->description; ?>

                             </div>
                             <div class="controlls">
                                 <div class="lookmore">
                                     <a href="<?php echo e($slide->url); ?>">Подробнее</a>
                                 </div>
                             </div>
                         </div>
                    </div>
                    <?php 
                        $iter=$iter+1;
                     ?>
                <?php endforeach; ?>
            </div>
            <?php if(count($slides)>1): ?>
            <div class="marks">
                <?php 
                    $iter=0;
                 ?>
                <?php foreach($slides as $slide): ?>
                    <div class="mark <?php if($iter==0): ?> active <?php endif; ?>"></div>
                    <?php 
                        $iter=$iter+1;
                     ?>
                    <?php endforeach; ?>
            </div>
            <div class="controlls">

                <div class="left but">
                    <img src="<?php echo e(URL::asset('static/img/left.svg')); ?>" alt="Left">
                </div>

                <div class="right but">
                    <img src="<?php echo e(URL::asset('static/img/right.svg')); ?>" alt="Right">
                </div>

            </div>
                <?php endif; ?>
        </div>
<?php endif; ?>
        <?php foreach($list_block as $block): ?>
            <?php echo $__env->make('home.parts.list.home.block_good',['block'=>$block], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endforeach; ?>
        <div class="">
            <?php echo $text_main_page; ?>

        </div>

    <?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(URL::asset('/static/js/homepageslider.js')); ?>">

    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>