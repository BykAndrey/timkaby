<?php $__env->startSection('header'); ?>
    <title>Смена пароля пользователя - Timka.by</title>
    <?php $__env->stopSection(); ?>

<?php $__env->startSection('data'); ?>
    <div class="block_good">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="head">
            <h2>Смена пароля пользователя</h2>
        </div>
        <div class="user_log">
            <?php if(count($errors) > 0 ): ?>
                <div class="error">
                    <ul>
                        <?php foreach($errors->all() as $error): ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php echo Form::open(['url'=>route('user::changepassword'),'method'=>'post']); ?>

            <table>
                <?php if($old_pass_exist==true): ?>
                    <tr>
                        <td>
                            <?php echo Form::label('old_password','Старый пароль'); ?>

                        </td>
                        <td>
                            <?php echo Form::password('old_password'); ?>

                        </td>
                    </tr>
                    <?php endif; ?>
                <tr>
                    <td> <?php echo Form::label('password','Пароль'); ?></td>
                    <td> <?php echo Form::password('password'); ?></td>
                </tr>
                <tr>
                    <td> <?php echo Form::label('password_confirmation','Повтор пароля:'); ?></td>
                    <td> <?php echo Form::password('password_confirmation'); ?></td>
                </tr>
            </table>


                <input type="hidden" value="<?php echo e($old_pass_exist); ?>">
            <input type="submit" value="Сохранить">
            <?php echo Form::close(); ?>

        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>