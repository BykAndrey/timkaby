<?php $__env->startSection('content'); ?>
    <h2>Коментарии</h2>
    <ul class="controllers_list">

    </ul>
    <table class="list">
        <caption>
            <th>
                ID
            </th>
            <th>
                Инфо
            </th>
            <th>
                Оценка
            </th>
            <th>
                Активный
            </th>

            <th>
                Новый
            </th>

            <th>

            </th>
            <th></th>
        </caption>
        <?php foreach($good_brand as $item): ?>
            <tr>
                <td>
                    <?php echo e($item->id); ?>


                </td>
                <td>
                    <p> <b>Пользователь:</b> <?php echo e($item->user_name); ?></p>
                    <p> <b>Товар:</b> <a href="<?php echo e(route('admin::good_item_edit',['id'=>$item->good_id])); ?>"><?php echo e($item->good_name); ?></a></p>
                    <p> <b>Коментарий:</b> <?php echo e($item->comment); ?></p>

                </td>
                <td>
                    <?php echo e($item->rating); ?>


                </td>
                <td>
                    <?php if($item->is_active==0): ?>
                            <div class="but but_red"  onclick="set_active(<?php echo e($item->id); ?>,this)">

                            </div>
                        <?php else: ?>
                            <div class="but but_green" onclick="set_active(<?php echo e($item->id); ?>,this)">

                            </div>
                        <?php endif; ?>


                </td>
                <td>
                    <?php if($item->is_new==0): ?>
                        <div class="but but_red" onclick="set_new(<?php echo e($item->id); ?>,this)">

                        </div>
                    <?php else: ?>
                        <div class="but but_green" onclick="set_new(<?php echo e($item->id); ?>,this)">

                        </div>
                    <?php endif; ?>

                </td>
                <td>
                    <a href="<?php echo e(route('admin::good_brand_edit',['id'=>$item->id])); ?>"> Редактировать</a>
                </td>
                <td>

                    <a href="<?php echo e(route('admin::good_brand_delete',['id'=>$item->id])); ?>">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php echo $__env->make('home.parts.elements.paginate',[
   'current_page'=>$current_page,
   'max_page'=>$max_page,
   'route'=>'admin::item_comment'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <script>set_active
        function set_new(id,e) {

            $.ajax({
                url:'/admin/item_comment/ajax',
                data:{
                    'action':'set_new',
                    'id':id
                },
                success:function(data){
                    if(data==1){
                        $(e).removeClass('but_red');
                        $(e).addClass('but_green');
                    }  else{
                        $(e).removeClass('but_green');
                        $(e).addClass('but_red');

                    }
                    console.log(data);
                }
            })
        }
        function set_active(id,e) {
            $.ajax({
                url:'/admin/item_comment/ajax',
                data:{
                    'action':'set_active',
                    'id':id
                },
                success:function(data){
                    if(data==1){
                        $(e).removeClass('but_red');
                        $(e).addClass('but_green');
                    }  else{
                        $(e).removeClass('but_green');
                        $(e).addClass('but_red');

                    }
                    console.log(data);
                }
            })
        }
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>