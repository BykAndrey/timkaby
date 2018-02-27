<ol>
    <?php foreach($errors->all() as $error): ?>
        <li><?php echo e($error); ?></li>
    <?php endforeach; ?>
</ol>
<?php if(isset($model)): ?>
    <?php echo Form::model($model,array('route'=>array('admin::news_edit',$model->id),'method'=>'post','files'=>true)); ?>

<?php else: ?>
    <?php echo Form::open(['route'=>'admin::news_create','methon'=>'post','files'=>true]); ?>

<?php endif; ?>

<table id='item' class="create">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>
    <tr>
        <td>
            <?php echo Form::label('title','Title'); ?>

        </td>
        <td><?php echo Form::text('title'); ?></td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('name','Название'); ?>

        </td>
        <td><?php echo Form::text('name',old(''),['class'=>'name']); ?></td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('url','URL'); ?>

        </td>
        <td><?php echo Form::text('url',old('url'),['class'=>'url']); ?></td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('image','Картинка'); ?>

        </td>
        <td>
            <?php if(isset($model)): ?>
                <img   src="/<?php echo e(\App\ItemGroup::getImage($model->image,200,null,$path=\App\Http\Controllers\Admin\BaseAdminController::$pathImageNews)); ?>"
                width="200">
                <?php endif; ?>

            <?php echo Form::file('image'); ?></td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('content','Контент'); ?>

        </td>
        <td><?php echo Form::textarea('content',old(''),array('class'=>'text_redactor')); ?></td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('is_active','Активный'); ?>

        </td>
        <td><?php echo Form::checkbox('is_active'); ?></td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('is_open_admin','Видит только администратор'); ?>

        </td>
        <td><?php echo Form::checkbox('is_open_admin'); ?></td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('meta_description','meta_description'); ?>

        </td>
        <td><?php echo Form::textarea('meta_description'); ?></td>
    </tr>



    <tr>
        <td><input type="submit" value="Сохранить"></td>
        <td>

        </td>
    </tr>
</table>