<ol>
    <?php foreach($errors->all() as $error): ?>
        <li><?php echo e($error); ?></li>
    <?php endforeach; ?>
</ol>
<?php if(isset($model)): ?>
    <?php echo Form::model($model,array('route'=>array('admin::option_delivery_edit',$model->id),'method'=>'post')); ?>

<?php else: ?>
    <?php echo Form::open(['route'=>'admin::option_delivery_create','methon'=>'post']); ?>

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
        <td><?php echo Form::text('name'); ?></td>
    </tr>


    <tr>
        <td>
            <?php echo Form::label('price','Цена'); ?>

        </td>
        <td><?php echo Form::number('price', old(''),['step'=>'0.01']); ?></td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('text_price','Цена текстом'); ?>

        </td>
        <td><?php echo Form::text('text_price'); ?></td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('border_free','Граница '); ?>

            <p class="help">Цена после которой стоимость доставки станет бесплатной</p>
        </td>
        <td><?php echo Form::number('border_free'); ?></td>
    </tr>




    <tr>
        <td><input type="submit" value="Сохранить"></td>
        <td>

        </td>
    </tr>
</table>