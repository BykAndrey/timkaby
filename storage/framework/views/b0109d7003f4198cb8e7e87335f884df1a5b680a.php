<?php $__env->startSection('header'); ?>
    <title>Новости Timka.by</title>
    <meta name="description" content="Новости интернет-магазина Timka.by">
    <?php $__env->stopSection(); ?>


<?php $__env->startSection('data'); ?>
    <div class="block_good">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="head">
            <h2>Новости</h2>
        </div>

        <div class="news">
            <?php 
            $counter=1;
             ?>
            <?php foreach($news as $item): ?>
                <?php if($counter==2 or $counter==3): ?>
                    <?php 
                        $imgLoad=300;
                     ?>
                    <div class="articul middle">
                    <?php else: ?>
                            <?php 
                                $imgLoad=510;
                             ?>
                            <div class="articul">
                    <?php endif; ?>
                <a href="<?php echo e(route('home::articul',['url'=>$item->url])); ?>">
                    <div class="back"
                         style="background-image: url('/<?php echo e(\App\ItemGroup::getImage($item->image,$imgLoad,null,\App\Http\Controllers\Admin\BaseAdminController::$pathImageNews)); ?>'">
                        <div class="name">
                            <div class="date"><?php echo e((new DateTime($item->created_at))->format('d-m-Y')); ?></div>
                            <p> <?php echo e($item->name); ?></p>

                        </div>
                    </div>
                </a>

            </div>
                <?php 

                    $counter==3?$counter=1:$counter++;


                 ?>
                <?php endforeach; ?>
        </div>
                <?php echo $__env->make('home.parts.elements.paginate',[
                'max_page'=>$max_page,
                'current_page'=>$current_page,
                'route'=>'home::all_news'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>