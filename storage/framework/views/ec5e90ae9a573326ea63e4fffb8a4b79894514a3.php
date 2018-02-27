<?php $__env->startSection('scripts'); ?>
<!--
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#tabs" ).tabs();
        } );
    </script>
-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <h2>Редактирование свойства категории</h2>
    <div id="tabs">
        <ul>
            <li><a href="#object">Свойство</a></li>
            <li><a href="#filters">Фильтры</a></li>
        </ul>
        <div id="object">
            <h4>Свойство</h4>
            <ol>
                <?php foreach($errors->all() as $error): ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; ?>
            </ol>
            <?php if(isset($model)): ?>
                <?php echo Form::model($model,array('route'=>array('admin::good_property_category_edit',$model->id),'method'=>'post')); ?>

            <?php else: ?>
                <?php echo Form::open(['route'=>'admin::good_property_category_create','methon'=>'post']); ?>

            <?php endif; ?>
            <table class="create">
                <colgroup>
                    <col width="30%">
                    <col width="70%">
                </colgroup>
                <tr><th>Поле</th> <th>Значение</th></tr>
                <tr>
                    <td>
                        <?php echo Form::label('id_good_category','Категория'); ?>

                        <br>
                        <p class="help">Привязка к категории!
                            <br>
                        При изменении для данное свойство будет удалено из товаров старой категории</p>
                    </td>
                    <td>
                        <?php echo Form::select('id_good_category', $category_list,old('') ); ?>


                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo Form::label('name','Название'); ?>

                        <br>
                        <p class="help">Минимум 2 символа</p>
                    </td>
                    <td>
                        <?php echo Form::text('name'); ?>

                    </td>
                </tr>
                <tr>
                    <td>   <input type="submit" value="Сохранить" class="save"></td>
                    <td></td>
                </tr>
            </table>
            <?php echo Form::close(); ?>

        </div>
        <?php if(isset($model)): ?>
        <div id="filters">
            <h4>Фильтры</h4>
            <!--<a href="<?php echo e(route('admin::good_filter_category_create_by_prop',['id'=>$model->id])); ?>">Создать фильтр</a>-->



                <script>
                    getlistProp(<?php echo e($model->id); ?>);
                </script>
            <?php if(isset($filter)): ?>
                <a href="<?php echo e(route('admin::good_filter_category_delete',['id'=>$filter->id])); ?>">Удалить фильтр</a>
                <p class='pay_attention'>При удалении фильтра будут удалены все значения фильтра </p>
                <p class='pay_attention'>Изменяя <u>Категория</u> и/или <u>Свойство</u>  можно прикрепить фильтр к другому свойству у которого
                <b>нет</b>
                фильтра.</p>

                <?php echo Form::model($filter,['route'=>['admin::good_filter_category_edit',$filter->id],'method'=>'post']); ?>

                <input type="hidden" id='id_filter' value="<?php echo e($filter->id); ?>">
                                <?php else: ?>
                <p class='pay_attention'>На данный момент фильтр не создан. Введите имя для его добавления. <br>


                </p>
                <p class="warning">
                <b>Не изменяйте <i>Категории</i> и <i>Свойство</i> так как фильтр добавится к другому свойству без фильтра</b></p>
                <?php echo Form::open(['route'=>'admin::good_filter_category_create','method'=>'post']); ?>

            <?php endif; ?>
                <table class="create">
                    <tr><th>Поле</th><th>Значение</th></tr>
                    <tr>
                        <td>
                            <?php echo Form::label('id_good_category','Категория'); ?>

                        </td>
                        <td>
                            <?php echo Form::select('id_good_category',$category_list,$model->id_good_category); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo Form::label('id_good_property_category','Свойство'); ?>

                        </td>
                        <td>
                            <?php echo Form::select('id_good_property_category',[]); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo Form::label('name','Название'); ?>

                        </td>
                        <td>
                            <?php echo Form::text('name'); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Сохранить" class='save'>
                        </td>
                        <td>

                        </td>
                    </tr>
                </table>
                <?php echo Form::close(); ?>


                <table>
                    <tr><th>Значения фильтра</th></tr>

                    <p class="warning">
                        <b>Внимание!</b> Если вы изменили хотя бы <b>ОДНО</b> значение фильтра <b>нажмите</b> кнопку -> <b>Сохранить изменения фильтров</b>
                    </p>
                    <table id="listfilter">
                            <tr><td></td><td>
                                   Название: <input type="text" v-model="newName">
                                    <br>
                                    {{ newName }}<br>
                                    <button v-on:click="add()">Добавить</button></td>
                                <td><button v-on:click="save()">Сохранить изменения фильтров</button></td></tr>
                            <tr v-for="item in list">
                                <td>{{item.id}}</td>
                                <td><input type="text" v-model="item.value"></td>
                                <td v-on:click="del(item.id)">Удалить</td>
                            </tr>

                    </table>
                    <script>
                        var id_filter=$('#id_filter').val();
                        var listing={};
                        var url='/admin/filtercategory/getselectlist/'+id_filter;


                        var app = new Vue({
                            el: '#listfilter',
                            data: {
                                list: listing,
                                newName:''
                            },
                            methods:{
                                add:function () {
                                    $.ajax({
                                        url:'/admin/filtercategory/addselectlistitem/',
                                        dataType:'json',
                                        data:{'id_filter':id_filter,'value':this.newName},
                                        success:function (data) {
                                            console.log(this.newName);
                                            refresh();
                                        }
                                    });
                                },
                                del:function (id) {
                                    $.ajax({
                                        url:'/admin/filtercategory/deleteselectlistitem/'+id,
                                        dataType:'json',

                                        success:function (data) {

                                            refresh();
                                        }
                                    });
                                },
                                save:function () {
                                    $.ajax({
                                        url:'/admin/filtercategory/saveselectlistlist',
                                        data:{'list':this.list},
                                        success:function (data) {
                                            refresh();
                                            console.log(data);
                                        }
                                    })
                                }
                            }
                        });
                        refresh();
                       function refresh() {
                           $.ajax({
                               url:url,
                               dataType:'json',

                               success:function (data) {
                                   app.list=data;
                               }
                           });
                       }

                    </script>
                </table>

        </div>
            <?php endif; ?>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>