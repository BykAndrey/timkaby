<?php $__env->startSection('content'); ?>
    <h2>Список категорий</h2>
    <ul class="controllers_list">
        <li><a href="<?php echo e(route('admin::good_category_create')); ?>">Добавить категорию</a></li>
        <li  id="search">Поиск: <input type="text" v-model="what"> <button v-on:click="searchM()">Найти</button>
            <div class="answer"><ul>
                    <li v-on:click="close()">Закрыть</li>
                    <li v-for="item in searchanswer" ><a :href="'/admin/category/edit/'+item.id">{{ item.name }}</a></li>
                </ul>
            </div>
        </li>
    </ul>
    <table class="list">
        <colgroup>
            <col width="1%" span="1" style="background-color:#deffda">
            <col width="25%" span="1" style="background-color:#cedeff">

            <col width="1%" span="1" style="background-color:#deffda">
            <col width="1%" span="1" style="background-color:#cedeff">

            <col width="1%" span="1" style="background-color:#deffda">
            <col width="1%" span="1" style="background-color:#cedeff">
        </colgroup>
        <tr>
            <th>ID <br>(<a href="<?php echo e(route('admin::good_category',['page'=>1,'sortby'=>'id','sortMethod'=>'desc'])); ?>">убв.</a>
                <a href="<?php echo e(route('admin::good_category',['page'=>1,'sortby'=>'id','sortMethod'=>'asc'])); ?>">возр.</a>)</th>

            <th>Название (<a href="<?php echo e(route('admin::good_category',['page'=>1,'sortby'=>'name','sortMethod'=>'desc'])); ?>">убв.</a>
                <a href="<?php echo e(route('admin::good_category',['page'=>1,'sortby'=>'name','sortMethod'=>'asc'])); ?>">возр.</a>)</th>
            <th>Родитель
                <a href="<?php echo e(route('admin::good_category',['page'=>1,'sortby'=>'parent_name','sortMethod'=>'desc'])); ?>">убв.</a>
                <a href="<?php echo e(route('admin::good_category',['page'=>1,'sortby'=>'parent_name','sortMethod'=>'asc'])); ?>">возр.</a>)</th>
            <th>Active</th>
            <th>Edit</th>
            <th>Delete</th>


        </tr>
        <?php foreach($category as $item): ?>
            <tr>
                <td><?php echo e($item->id); ?></td>
                <td><b><?php echo e($item->name); ?></b> (товаров: <?php echo e($item->count_items); ?>)</td>
                <td><?php echo e($item->parent_name); ?></td>
                <td><?php echo e($item->is_active); ?></td>
                <td><a href="<?php echo e(route('admin::good_category_edit',['id'=>$item->id])); ?>">Редактировать</a>
                </td><td><a href="<?php echo e(route('admin::good_category_delete',['id'=>$item->id])); ?>">Удалить</a></td>
            </tr>
            <?php endforeach; ?>

    </table>
    <div style="text-align: center;padding: 10px;">
        <?php if($page>1): ?>
        <a href="<?php echo e(route('admin::good_category',['page'=>$page-1,'sortby'=>$sortby,'sortMethod'=>$sortMethod])); ?>">Предыдущая страница</a>
        <?php endif; ?>
        <span>--<?php echo e($page); ?>--</span>
            <?php if($count_pages>$page): ?>
                <a href="<?php echo e(route('admin::good_category',['page'=>$page+1,'sortby'=>$sortby,'sortMethod'=>$sortMethod])); ?>">Следующая страница</a>
            <?php endif; ?>
    </div>
    <?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
    <script>
            var search=new Vue({
                el:'#search',
                data:{
                    what:'',
                    searchanswer:{
                                    0:{
                                        'name':'name',
                                    }
                    }
                },
                methods:
                    {
                        searchM:function () {
                            if(this.what.length>0){


                            $.ajax({
                                url:'/admin/category/ajax',
                                data:{
                                    'action':'search',
                                    'what':this.what
                                },
                                success:function (data) {
                                    if(data.length>0){
                                        search.searchanswer=data;
                                    }else{
                                        search.searchanswer={0:{
                                            name:'Ничего нет',
                                            id:0
                                        }}
                                    }


                                    $('#search .answer').css('display','block');


                                },
                                error:function (data) {
                                    alert('error');
                                }
                            });
                            }else{
                                alert('ВВЕДИТЕ ДАННЫЕ');
                            }
                        },
                        close:function () {
                            $('#search .answer').css('display','none');
                        }
                    }
            })
    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>