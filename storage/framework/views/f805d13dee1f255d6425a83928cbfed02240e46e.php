<p class="pay_attention">Данный объект  <b>не является "товаром"</b> как таковым, Данный объект используется для группировки
 <b>ПРЕДЛОЖЕНИЙ</b>(это и есть товар), поля объекта "ТОВАР" служать полями по умолчанию для предложения</p>
<p class="pay_attention">Установив  значение полю   <b>Автоматически создать предложение</b>  дополнительно будет создано  предложение с этими данными</p>
<ol>
    <?php foreach($errors->all() as $error): ?>
        <li><?php echo e($error); ?></li>
    <?php endforeach; ?>
</ol>
<?php if(isset($model)): ?>
    <?php echo Form::model($model,array('route'=>array('admin::good_item_group_edit',$model->id),'method'=>'post','files'=>true)); ?>

<?php else: ?>
    <?php echo Form::open(['route'=>'admin::good_item_group_create','methon'=>'post','files'=>true]); ?>

<?php endif; ?>
<table class="create" id="item_group">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>
    <?php if(!isset($model)): ?>
    <tr>
        <td>
            <?php echo Form::label('autoOffer','Автоматически создать предложение'); ?>

            <br>
            <p class="help">Создаст предложение на основе этих данных <br>
            Использовать если товар <b>одиночный</b> </p>
        </td>
        <td>
            <?php echo Form::checkbox('autoOffer'); ?>


        </td>
    </tr>
    <?php endif; ?>
    <tr>
        <td>
            <?php echo Form::label('id_good_category','Категория'); ?>

            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            <?php echo Form::select('id_good_category', $category_list,old('') ); ?>


        </td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('name','Название'); ?>

            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            <?php echo Form::text('name',old(''),['class'=>'name']); ?>


        </td>
    </tr>



    <tr>
        <td>
            <?php echo Form::label('title','Title'); ?>

            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            <?php echo Form::text('title'); ?>


        </td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('url','URL'); ?>

            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            <?php echo Form::text('url',old(''),['class'=>'url']); ?>


        </td>
    </tr>


    <tr>
        <td>
            <?php echo Form::label('id_brand',"Бренд"); ?>

        </td>
        <td>
            <select name="id_brand" id="id_brand" value="<?php echo e(old('id_brand')); ?>">
                <?php if(isset($model)): ?>
                    <?php foreach($brand as $item): ?>
                        <?php if($model->id_brand==$item->id): ?>
                            <option selected value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                        <?php else: ?>
                            <option  value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php foreach($brand as $item): ?>
                        <option  value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('id_provider',"Поставщик"); ?>

        </td>
        <td>

           <select name="id_provider" id="id_provider" v-model="id_provider" v-on:change="get_rate()">
               <?php if(isset($model)): ?>
                    <?php foreach($provider as $item): ?>
                       <?php if($model->id_provider==$item->id): ?>
                           <option selected value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                       <?php else: ?>
                           <option  value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                       <?php endif; ?>
                   <?php endforeach; ?>
               <?php else: ?>
                   <?php foreach($provider as $item): ?>
                       <option  value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                   <?php endforeach; ?>
               <?php endif; ?>
            </select>
        </td>
    </tr>


















    <tr>
        <td>
            <?php echo Form::label('articul','Артикул'); ?>

            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            <?php echo Form::text('articul'); ?>


        </td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('image','Основная картинка'); ?>

            <br>
            <p class="help_must">Эта картинка будет основовной при отображении. <br> Переопределяется в предложении.</p>
        </td>
        <td>
            <?php if(isset($model)): ?>
         <!--       <img src="/<?php echo e(\App\ItemGroup::getImage($model->image,180,null)); ?>" alt="" width="150">-->
            <?php endif; ?>
                <input type="hidden" value="" name="ajaxImageField">
                <img src="/static/imagesItem/<?php echo e(isset($model)?$model->image:null); ?>"  id="ajaxImage" alt="" width="150">
            <?php echo Form::file('image'); ?>

            <button id="upload">Загрузить</button>

        </td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('price','Цена'); ?>

            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            <span>Доллары (курс {{ dollar_rate }})</span>:<br>
            <input type="number" v-model="dollar_price" step="0.0001" v-on:keyup="change_dollar"><br>
           <span>Беларусские рубли</span>:
            <?php echo Form::number('price',old(''),
            array('step'=>'0.01',
            'v-model'=>'BYN_price',
            'v-on:keyup'=>'change_BYN'
            )); ?>



        </td>
    </tr>
    <tr>
        <td>
            <?php echo Form::label('description','Описание'); ?>

            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            <?php echo Form::textarea('description',old(''),array('class'=>'text_redactor')); ?>


        </td>
    </tr>


    <tr>
        <td>
            <?php echo Form::label('meta_description','Meta Description'); ?><br>
            <p class="help">Данные для header</p>
        </td>
        <td>
            <?php echo Form::textarea('meta_description'); ?>

        </td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('discount','Скидка'); ?>

            <br>
            <p class="help">Если 0 то скидки нет</p>
        </td>
        <td>
            <?php echo Form::number('discount'); ?>


        </td>
    </tr>


    <tr>
        <td>
            <?php echo Form::label('is_new','Новый'); ?>

        </td>
        <td>
            <?php echo Form::checkbox('is_new'); ?>

        </td>
    </tr>

    <tr>
        <td>
            <?php echo Form::label('is_hot','HOT!'); ?>

        </td>
        <td>
            <?php echo Form::checkbox('is_hot'); ?>

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
            <?php if(isset($model)): ?>
                <input type="hidden" id="id_good_item_group" value="<?php echo e($model->id); ?>">
            <?php endif; ?>
        </td></tr>
</table>

<?php echo Form::close(); ?>




<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(URL::asset('static/js/admin/admin_dollar_rate.js')); ?>"></script>
    <?php $__env->stopSection(); ?>