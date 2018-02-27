
<ol>
    <?php foreach($errors->all() as $error): ?>
        <li><?php echo e($error); ?></li>
    <?php endforeach; ?>
</ol>
<?php if(isset($model)): ?>
    <?php echo Form::model($model,array('route'=>array('admin::info_page_edit',$model->id),'method'=>'post')); ?>

<?php else: ?>
    <?php echo Form::open(['route'=>'admin::info_page_create','methon'=>'post']); ?>

<?php endif; ?>


<table class="create">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>



    <tr>
        <td>
            <?php echo Form::label('title','Title'); ?>

            <br>
            <p class="help"></p>
        </td>
        <td>
            <?php echo Form::text('title',old('title')); ?>

        </td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('name','Название'); ?>

            <br>
            <p class="help"></p>
        </td>
        <td>
            <?php echo Form::text('name',old('name'),['class'=>'name']); ?>

        </td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('url','URL'); ?>

            <br>
            <p class="help"></p>
        </td>
        <td>
            <?php echo Form::text('url',old('url'),['class'=>'url']); ?>

        </td>
    </tr>



    <tr>
        <td>
            <?php echo Form::label('content','Контент'); ?>

            <br>
            <p class="help"></p>
        </td>
        <td>

            <?php echo Form::textarea('content',old('content'),array('class'=>'text_redactor')); ?>


        </td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('meta_description','META_DESCRIPTION'); ?>

            <br>
            <p class="help"></p>
        </td>
        <td>

            <?php echo Form::textarea('meta_description',old('meta_description')); ?>


        </td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('weight','Вес'); ?>

            <p class="help">Позиция в списке</p>
        </td>
        <td>
            <?php echo Form::number('weight'); ?>

        </td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('is_active','Активный'); ?>

        </td>
        <td>
            <?php echo Form::checkbox('is_active'); ?>

        </td>
    </tr>

    <tr>
        <td>
            <input type="submit" value="Сохранить">
        </td>
        <td>

        </td>
    </tr>
</table>




<?php echo Form::close(); ?>

<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(URL::asset('static/js/admin/admin_dollar_rate.js')); ?>"></script>
<?php $__env->stopSection(); ?>