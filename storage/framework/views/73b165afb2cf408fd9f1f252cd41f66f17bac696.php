<?php $__env->startSection('scripts'); ?>

    <!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
    <script type="text/javascript">
        loadLitProperty();
    </script>
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <h2>Редактирование категории</h2>
    <div id="tabs">
        <ul>
            <li><a href="#object">Категория</a></li>
            <?php if(isset($model)): ?>
                <?php if($model->id_parent>0): ?>
            <li><a href="#property">Свойства</a></li>
                <?php endif; ?>
                <?php endif; ?>
        </ul>
        <div id="object">
            <h3>Категория</h3>
            <?php echo $__env->make('admin.forms.category', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <?php if(isset($model)): ?>
            <?php if($model->id_parent>0): ?>
        <div id="property">
            <h3>Дополнительные свойства для товара</h3>
            <?php echo $__env->make('admin.listObjects.property_category', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>