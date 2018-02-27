<?php $__env->startSection('header'); ?>
    <title>Профиль <?php echo e($user_data->name); ?> - Timka.by</title>
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('tree'); ?>
    <?php echo $__env->make('user.tree', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>

<?php $__env->startSection('data'); ?>
    <div class="block_good">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="head">
            <h2>Профиль</h2>
        </div>
        <div class="profile" id="profile">

                <div id="maindata" class="tab-content active">
                    <fieldset>
                        <legend>Основные данные</legend>
                        <table>
                            <tr>
                                <td>Email:</td>
                                <td><?php echo e($user_data->email); ?></td>
                            </tr>
                            <tr>
                                <td>Имя:</td>
                                <td><?php echo e($user_data->name); ?></td>
                            </tr>

                            <tr>
                                <td>Пароль:</td>
                                <td>
                                    <a  href="<?php echo e(route('user::changepassword')); ?>" >
                                        <div>Сменить пароль</div></a>
                                </td>
                            </tr>
                        </table>
                    </fieldset>

                    <fieldset>
                        <legend>Дополнительные данные</legend>
                        <table>
                            <tr>
                                <td>Мобильный телефон:</td>
                                <td>

                                        <input  class="phone_mask" type="text"  v-model="phone">

                                        <a href="#"  v-on:click="save_phone" ref="phone">
                                            <div>Сохранить телефон</div>
                                        </a>
                              
                                </td>
                            </tr>
                            <tr>
                                <td>Адрес:</td>
                                <td>

                                        <input type="text" value="<?php echo e($user_data->adress); ?>" v-model="adress">

                                        <a href="#" v-on:click="save_adress"  ref="adress">
                                            <div>Сохранить адресс</div>
                                        </a>

                                </td>
                            </tr>
                            <tr>
                                <td>Особенности при доставке:</td>
                                <td>
                                    <textarea name="" id="" cols="30" rows="10" v-model="feature"> <?php echo e($user_data->feature); ?></textarea>

                                
                                        <a href="#" v-on:click="save_feature" ref="feature">
                                            <div>Сохранить особенности</div>
                                        </a>
                                  
                                </td>
                            </tr>
                        </table>
                    </fieldset>

                </div>


    </div>
    </div>
    <?php echo e($user_data->phone); ?>

<?php $__env->stopSection(); ?>

<!--
<fieldset>
                            <legend>Номер заказа: {$order->id}} от <b>{$order->created_at}}</b></legend>
                            <div style="display: flex">
                                <div>Сумма: {$order->total_price}} р.</div>
                                <div>Адресс доставки: {$order->adress}}</div>

                                <div>Статус$order->status}}</div>
                            </div>
                        </fieldset>
-->

<?php $__env->startSection("scripts"); ?>
    <script src="<?php echo e(URL::asset('static/js/plugin/jquery.maskinput.js')); ?>"></script>
    <script>

        jQuery(function($) {
            $.mask.definitions['~']='[+-]';
            $('input[type="text"]#phone').mask('+375 (99) 999-99-99');
            console.log(1);
        });

        var profile=new Vue({
            el:"#profile",
            data:{
                feature:'<?php echo e($user_data->feature); ?>',
                phone:'<?php echo e($user_data->phone); ?>',
                adress:'<?php echo e($user_data->adress); ?>'

            },

            methods:{
                save_phone:function (event) {
                    event.preventDefault();
                    $.ajax({
                        url:'/user_ajax',
                        data:{
                            'action':'save_phone',
                            '_token':'<?php echo e(csrf_token()); ?>',
                            'phone':profile.phone,
                        },

                        method:'post',
                        success:function (data) {
                            $(profile.$refs.phone).children('div').css({'animation-name':'good'});
                            setTimeout(function () {
                                $(profile.$refs.phone).children('div').css({'animation-name':'none'});
                            },4000);
                            console.log(data);
                        },
                        error:function (data) {
                            $(profile.$refs.phone).children('div').css({'animation-name':'bad'});
                            setTimeout(function () {
                                $(profile.$refs.phone).children('div').css({'animation-name':'none'});
                            },4000);
                        }
                    });
                    console.log('phone saved');
                },
                save_adress:function (event) {
                    event.preventDefault();

                    $.ajax({
                        url:'/user_ajax',
                        data:{
                            'action':'save_adress',
                            '_token':'<?php echo e(csrf_token()); ?>',
                            'adress':profile.adress,
                        },
                        method:'post',
                        success:function (data) {
                            $(profile.$refs.adress).children('div').css({'animation-name':'good'});
                            setTimeout(function () {
                                $(profile.$refs.adress).children('div').css({'animation-name':'none'});
                            },4000);
                            console.log(data);
                        },
                        error:function (data) {
                            $(profile.$refs.adress).children('div').css({'animation-name':'bad'});
                            setTimeout(function () {
                                $(profile.$refs.adress).children('div').css({'animation-name':'none'});
                            },4000);
                        }
                    });
                    console.log('adress saved' +this.adress);
                },
                save_feature:function (event) {
                    event.preventDefault();


                    $.ajax({
                        url:'/user_ajax',
                        data:{
                            'action':'save_feature',
                            '_token':'<?php echo e(csrf_token()); ?>',
                            'feature':profile.feature,
                        },
                        method:'post',
                        success:function (data) {
                            $(profile.$refs.feature).children('div').css({'animation-name':'good'});
                            setTimeout(function () {
                                $(profile.$refs.feature).children('div').css({'animation-name':'none'});
                            },4000);
                            console.log(data);
                        },
                        error:function (data) {
                            $(profile.$refs.feature).children('div').css({'animation-name':'bad'});
                            setTimeout(function () {
                                $(profile.$refs.feature).children('div').css({'animation-name':'none'});
                            },4000);
                        }
                    });
                    console.log('feature saved');
                }
            }
        })
    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>