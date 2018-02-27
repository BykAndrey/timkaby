<ol>
    <?php foreach($errors->all() as $error): ?>
        <li><?php echo e($error); ?></li>
    <?php endforeach; ?>
</ol>
<?php if(isset($model)): ?>
    <?php echo Form::model($model,array('route'=>array('admin::good_category_edit',$model->id),'method'=>'post','files'=>true)); ?>

<?php else: ?>
    <?php echo Form::open(['route'=>'admin::good_category_create','methon'=>'post','files'=>true]); ?>

<?php endif; ?>
<table class="create">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>

    <tr>
        <td>

            <?php echo Form::label('id_parent','Категория'); ?>

            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            <?php echo Form::select('id_parent', $category_list,old('id_parent') ); ?>


        </td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('name','Название'); ?>

            <br>
            <p class="help">Длинна должна быть не более 90 симвалов</p>
        </td>
        <td>
            <?php echo Form::text('name',old('name'),['required'=>'','class'=>'name']); ?>


        </td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('title','Title'); ?>

            <br>
            <p class="help">Длинна должна быть не более 90 симвалов</p>
        </td>
        <td>
            <?php echo Form::text('title'); ?>

        </td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('url','URL'); ?>

        </td>
        <td>
            <?php echo Form::text('url',old(''),['class'=>'url']); ?>

        </td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('image','Картинка'); ?>

        </td>
        <td>
            <?php if(isset($model)): ?>
                <img src="/<?php echo e(\App\ItemGroup::getImage($model->image,100,null)); ?>" alt="<?php echo e($model->name); ?>"><br>
                <?php endif; ?>
            <?php echo Form::file('image'); ?>

        </td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('description','Описание'); ?>

        </td>
        <td>
            <?php echo Form::textarea('description'); ?>

        </td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('meta_description','Meta Description'); ?>

        </td>
        <td>
            <?php echo Form::textarea('meta_description'); ?>

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
    <tr><td>
            <input type="submit" value="Сохранить" class="save">
        </td>
    <td>
    </td></tr>
</table>

<?php echo Form::close(); ?>