<?php $__env->startSection('header'); ?>

    <title>Вход - Timka.by</title>
    <meta name="description" content="Вход - Timka.by">
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('data'); ?>
    <div class="block_good">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="head">
            <h2>Вход</h2>
        </div>


        <div class="user_log">
                <div class="social">
                    <span>Авторизуйтесь через социальную сеть:</span>
                    <div>
                        <a href="<?php echo e(route('user::social',['social'=>'vk','action'=>'login'])); ?>">

                            <img src="<?php echo e(URL::asset('static/img/vk.svg')); ?>" alt="VK" width="50"></a>
                    </div>

                    <span>Или</span>
                </div>

                <?php if(isset($error)): ?>
                <div class="error">
                    <ul>

                            <li><?php echo e($error); ?></li>

                    </ul>
                </div>
                <?php endif; ?>

            <?php echo Form::open(); ?>

                <table>
                    <tr>
                        <td> <?php echo Form::label('email','Email:'); ?></td>
                        <td>    <?php echo Form::email('email'); ?></td>
                    </tr>
                    <tr>
                        <td> <?php echo Form::label('password','Пароль:'); ?></td>
                        <td> <?php echo Form::password('password'); ?></td>
                    </tr>
                </table>







            <input type="submit" value="Войти">
            <?php echo Form::close(); ?>


        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>