<div class="bread_crumbls" >
    <?php 
        $position=1;
     ?>
    <ul itemscope itemtype="http://schema.org/BreadcrumbList">
        <?php foreach($bread_crumbs as $key=>$item): ?>
            <li itemprop="itemListElement" itemscope
                itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?php echo e($item); ?>">

                    <span itemprop="name"><?php echo e($key); ?></span>


                </a>
                <meta itemprop="position" content="<?php echo e($position); ?>" />/
            </li>
            <?php 
                $position++;
             ?>
        <?php endforeach; ?>
    </ul>
</div>