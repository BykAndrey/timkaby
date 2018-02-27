<ol>
    <?php foreach($errors->all() as $error): ?>
        <li><?php echo e($error); ?></li>
    <?php endforeach; ?>
</ol>
<?php if(isset($model)): ?>
    <?php echo Form::model($model,array('route'=>array('admin::slide_edit',$model->id),'method'=>'post','file'=>true,'enctype'=>"multipart/form-data")); ?>

<?php else: ?>
    <?php echo Form::open(['route'=>'admin::slide_create','methon'=>'post','file'=>true,'enctype'=>"multipart/form-data"]); ?>

<?php endif; ?>

<table id='item' class="create">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>
    <tr>
        <td>
            <?php echo Form::label('name','Название'); ?>

        </td>
        <td><?php echo Form::text('name',old(''),['max'=>'100','min'=>1]); ?></td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('url','URL'); ?>

            <p class="help">Ссылка на нужную страницу</p>
        </td>
        <td><?php echo Form::text('url',old(''),['max'=>'100','min'=>1]); ?></td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('price','Цена'); ?>

            <p class="help">ЦЕНА БЕЗ СКИДКИ. <br>
            Итоговая цена считается отдельно</p>
        </td>
        <td><?php echo Form::number('price',old(''),['step'=>'0.01','min'=>0,'max'=>100000]); ?></td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('discount','Скидка'); ?>

            <p class="help">От 0 до 100 (%)</p>
        </td>
        <td><?php echo Form::number('discount',old(''),['max'=>'100','min'=>0]); ?></td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('description','Описание'); ?>

            <p class="help">Максимальная длинна 200 символов.
                <br>
            Нужно кратко описать товар</p>
        </td>
        <td><?php echo Form::textarea('description',old(''),['max'=>'200','min'=>1,'class'=>'text_redactor']); ?></td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('image','Картинка'); ?>

        </td>
        <td>
            <?php if(isset($model)): ?>
                <img src="/<?php echo e(\App\ItemGroup::getImage($model->image,180,null,\App\Http\Controllers\Admin\BaseAdminController::$pathslideImage)); ?>" alt="">
            <?php endif; ?>
            <input type="file" name="image" size="1024">
        </td>
    </tr>

    <tr>
        <td><input type="submit" value="Сохранить"></td>
        <td>

        </td>
    </tr>
</table>