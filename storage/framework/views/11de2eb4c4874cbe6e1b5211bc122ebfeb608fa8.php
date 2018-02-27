<?php $__env->startSection('header'); ?>
    <title>Поиск - Timka.by</title>
    <meta name="description" content="Поиск - Timka.by">
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('data'); ?>

    <div class="block_good" id="catalog">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="head">
            <h2><a href="">Поиск: <i><?php echo e($what_search); ?></i></a></h2>
        </div>
        <div class="sorting">
            <span>Сортировать по:</span>
            <select name="sortby" id="sortby" v-on:change="sortby()">
                <option selected value="1">Цена (убывание)</option>
                <option value="2">Цена (возрастание)</option>
            </select>
            <input type="checkbox" v-model="only_discount" v-on:change='discount()'><label for="">Только с скидкой</label>
        </div>
    <div class="list_good" >
        <good v-for="item in items"
                  :item="item"
                  :key="item.id"></good>
    </div>
        <paginate v-on:reload="reload($event)" :count_pages="max_page" :current_page="page"  ></paginate>
    </div>
    <?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(URL::asset('static/js/vue/good.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('static/js/vue/paginate.js')); ?>"></script>
    <script>
        var sortby="1";
        var only_discount=false;
        function load() {
            //alert(1);
            $.ajax({
                url:'/ajax',
                method:'get',
                data:{
                    'action':'search',
                    'id_category':<?php echo e($id_category); ?>,
                    'what_search':"<?php echo e($what_search); ?>",
                    'page':search_page.page,
                    'size':[180,null],
                    'sortby':sortby,
                    'only_discount':only_discount
                },
                success:function (data) {
                    search_page.items=data['goods'];
                    search_page.max_page=data['max_page'];
                    search_page.page=data['current_page']
                },
                error:function () {
                    alert('Произошла ошибка!');
                }
            });
        }
        var search_page= new Vue({
            el:'#catalog',
            data:{
                items:{},
                only_discount:0,
                page:1,
                max_page:0
            },
            methods:{
                sortby:function () {
                    sortby=$('select#sortby').val();

                    load();
                },
                discount:function () {

                    only_discount=search_page.only_discount;
                    //alert(only_discount);
                    load();
                },
                reload:function (page) {
                    this.page=page;
                    load();
                }
            }
            
        });
        load();
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>