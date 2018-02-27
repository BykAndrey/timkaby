<ol>
    <?php foreach($errors->all() as $error): ?>
        <li><?php echo e($error); ?></li>
    <?php endforeach; ?>
</ol>
<?php if(isset($model)): ?>
    <?php echo Form::model($model,array('route'=>array('admin::users_edit',$model->id),'method'=>'post')); ?>

<?php else: ?>
    <?php echo Form::open(['route'=>'admin::users_create','methon'=>'post']); ?>

<?php endif; ?>

<table id='item' class="create">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>
    <tr>
        <td>
            <?php echo Form::label('name','Имя'); ?>

        </td>
        <td><?php echo Form::text('name'); ?></td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('email','Email'); ?>

        </td>
        <td><?php echo Form::email('email'); ?></td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('password','Пароль'); ?>

        </td>
        <td><?php echo Form::password('password'); ?></td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('phone','phone'); ?>

        </td>
        <td><?php echo Form::text('phone',old(''),['id'=>"phone"]); ?></td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('adress','Адрес'); ?>

        </td>
        <td><?php echo Form::text('adress'); ?></td>
    </tr>


    <tr>
        <td>
            <?php echo Form::label('feature','Дополнительная информация'); ?>

        </td>
        <td><?php echo Form::text('feature'); ?></td>
    </tr>


    <tr>
        <td>
            <?php echo Form::label('id_role','Роль'); ?>

        </td>
        <td>
            <select name="id_role" >
                <?php foreach($roles as $item): ?>
                    <?php if(isset($model->id_role) and $model->id_role==$item->id): ?>
                            <option selected value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                        <?php else: ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                        <?php endif; ?>

                    <?php endforeach; ?>
            </select>

        </td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('is_active','Активный'); ?>

        </td>
        <td><?php echo Form::checkbox('is_active'); ?></td>
    </tr>
    <tr>
        <td><input type="submit" value="Сохранить"></td>
        <td>

        </td>
    </tr>
</table>