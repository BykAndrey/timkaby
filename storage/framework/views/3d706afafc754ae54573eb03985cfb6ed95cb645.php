<?php $__env->startSection('header'); ?>
    <title>Оформление заказа - Timka.by</title>
    <meta name="description" content="Оформление заказа - Timka.by">
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('data'); ?>
    <div class="block_good">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="head">
            <h2>Оформление заказа</h2>
        </div>
        <div class="help">
            Коректно заполните форму заказа и в ближайшее время наш специалист свяжется с вами для подтверждения заказа.
           
        </div>
        <div class="user_log">

                <?php if(count($errors)>0): ?>
                    <div class="help help-error">
                        Перепроверте введенные данные
                    </div>
                    <?php endif; ?>

            <?php echo Form::open(); ?>

            <table>
                <tr>
                    <td>Имя:</td>
                    <td>
                        <?php echo e(csrf_field()); ?>

                        <input type="text"
                               name="name"
                               class="common-input"
                               min="2"
                               required
                               placeholder="Имя"
                               value="<?php echo e(old('name')?old('name'):$order_data->name); ?>">

                        <div class="input-help input-help-required">Обязательное поле</div>
                    </td>
                </tr>
                <tr>
                    <td>Телефон:</td>
                    <td>
                        <input type="text"
                               name="phone"
                               class="common-input phone_mask"
                               min=7
                               required
                               placeholder="+375 (25) 555-55-55"
                               value="<?php echo e(old('phone')?old('phone'):$order_data->phone); ?>">
                        <div class="input-help input-help-required">Обязательное поле</div>
                    </td>
                </tr>
                <tr>
                    <td>Адрес доставки:</td>
                    <td>
                      <!--  <textarea name="address" cols="30" rows="10" class="common-input">
                            <?php echo e(old('adress')?old('adress'):$order_data->adress); ?>

                        </textarea>-->
                          <input type="text"
                                 name="adress"
                                 class="common-input"



                                 value="<?php echo e(old('adress')?old('adress'):$order_data->adress); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Особенности при доставке:
                    </td>
                    <td>
                        <textarea name="feature" id="" cols="30" rows="10" class="common-input">
                            <?php echo e(old('feature')?trim(old('feature')):trim($order_data->feature)); ?>

                        </textarea>
                    </td>
                </tr>

            </table>
                <input type="submit" value="Заказать!" class="common-but">
            <?php echo Form::close(); ?>

        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('sctipts'); ?>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>