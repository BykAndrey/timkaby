<ol>
    <?php foreach($errors->all() as $error): ?>
        <li><?php echo e($error); ?></li>
    <?php endforeach; ?>
</ol>
<?php if(isset($model)): ?>
    <?php echo Form::model($model,array('route'=>array('admin::good_provider_edit',$model->id),'method'=>'post')); ?>

<?php else: ?>
    <?php echo Form::open(['route'=>'admin::good_provider_create','methon'=>'post']); ?>

<?php endif; ?>
<?php if(isset($item_group)): ?>

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
            <?php echo Form::label('dollar_rate','Курс доллара'); ?>

        </td>
        <td><?php echo Form::number('dollar_rate',old(''),['step'=>'0.0001','min'=>'0']); ?></td>
    </tr>

    <tr>
        <td><input type="submit" value="Сохранить"></td>
        <td>

        </td>
    </tr>
</table>