<?php $__env->startSection('content'); ?>
    <h2>Список товаров</h2>

        <ul class="controllers_list">
            <li>
                <a href="<?php echo e(route('admin::good_item_group_create')); ?>">Добавить товар</a>
            </li>
            <li id="filters">

                <span>Категория: </span>
                <select name="" id="category" v-model="category">
                    <option value="0">ВСЕ</option>
                    <?php foreach($categories as $key=>$item): ?>
                        <optgroup label="<?php echo e($key); ?>">
                            <?php foreach($item as $k=>$i): ?>
                                <?php if($category==$k): ?>
                                    <option selected="selected" value="<?php echo e($k); ?>"><?php echo e($i); ?></option>
                                <?php else: ?>
                                    <option  value="<?php echo e($k); ?>"><?php echo e($i); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                </select>





               <span>Поставщик: </span>
                <select name="" id="provider" v-model="provider">
                    <option value="0">ВСЕ</option>
                    <?php foreach($providers as $item): ?>
                       <?php if($item->id==$provider and isset($provider)): ?>
                            <option selected="selected" value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                        <?php else: ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                        <?php endif; ?>
                        <?php endforeach; ?>
                </select>
              <span>Бренд: </span>
                <select name="" id="brand" v-model="brand">
                    <option value="0">ВСЕ</option>
                    <?php foreach($brands as $item): ?>
                        <?php if($item->id==$brand and isset($brand)): ?>
                            <option selected="selected" value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                        <?php else: ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <button v-on:click="sort()">Сортировать</button>
            </li>
        </ul>


    <table class="list">
        <colgroup>
            <col width="1%" span="1" style="background-color:#deffda">
            <col width="10%" span="1" style="background-color:#cedeff">

            <col width="10%" span="1" style="background-color:#deffda">
            <col width="5%" span="1" style="background-color:#cedeff">

            <col width="1%" span="1" style="background-color:#deffda">
            <col width="1%" span="1" style="background-color:#deffda">
            <col width="1%" span="1" style="background-color:#cedeff">
            <col width="1%" span="1" style="background-color:#deffda">
        </colgroup>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Parent name</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Edit</th>
            <th>Delete</th>


        </tr>
        <?php foreach($list_item_group as $item): ?>


                <tr>
                    <td><?php echo e($item->id); ?></td>
                    <td>
                        <img src="<?php echo e(URL::asset(\App\ItemGroup::getImage($item->image,100,null))); ?>" alt="image" width="150">
                    </td>
                    <td><?php echo e($item->name); ?></td>
                    <td><?php echo e($item->category_name); ?></td>

                    <td><input type="text" value="<?php echo e($item->price); ?>" onblur="setPrice_item_group(<?php echo e($item->id); ?>,this)"></td>

                    <td><input type="text" value="<?php echo e($item->discount); ?>" onblur="setDiscount_item_group(<?php echo e($item->id); ?>,this)"></td>

                    <td><a
                           href="<?php echo e(route('admin::good_item_group_edit',['id'=>$item->id])); ?>">Изменить</a>
                    </td><td><a href="<?php echo e(route('admin::good_item_group_delete',['id'=>$item->id])); ?>">Удалить</a></td>
                </tr>
        <?php endforeach; ?>
    </table>
    <!-- onclick="window.open('<?php echo e(route('admin::good_item_group_edit',['id'=>$item->id])); ?>','TOVAR','width=700,menubar=no,location=no,resizable=yes,scrollbars=yes,status=no');return false;"-->
    <div style="text-align: center;padding: 10px;">
        <?php if($page>1): ?>
            <a href="<?php echo e(route('admin::good_item_group',[
            'page'=>$page-1,
            'sortby'=>$sortby,
            'sortMethod'=>$sortMethod,
             'provider'=>$provider,
             'brand'=>$brand,
             'category'=>$category
             ])); ?>">Предыдущая страница</a>
        <?php endif; ?>
        <span>--<?php echo e($page); ?>--</span>
        <?php if($count_pages>$page): ?>
            <a href="<?php echo e(route('admin::good_item_group',[
            'page'=>$page+1,
            'sortby'=>$sortby,
            'sortMethod'=>$sortMethod,
            'provider'=>$provider,
            'brand'=>$brand,
            'category'=>$category
            ])); ?>">Следующая страница</a>
        <?php endif; ?>
    </div>
    <?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

    <script src="<?php echo e(URL::asset('/static/js/admin/admin_item_group.js')); ?>"></script>
    <script>
        var sortItemGroup=new Vue({
            el:'#filters',
            data:{
                provider:$('#provider').val(),
                brand:$('#brand').val(),
                category:$('#category').val(),
            },
            methods:{
                sort:function () {
                  window.location='/admin/itemgroup?provider='+this.provider+'&brand='+this.brand+'&category='+this.category;
                }
            }
        });
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>