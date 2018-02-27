<?php $__env->startSection('header'); ?>
    <title>Корзина - Timka.by</title>
    <meta name="description" content="Корзина  - Timka.by">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('data'); ?>
    <div class="block_good">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="head">
            <h2><a href="#">Корзина</a></h2>
        </div>

            <div class="sorting">
                <a href="<?php echo e(route('cart::clearcart')); ?>">
                <div class="common-but"> Очистить корзину</div>
                </a>

            </div>
            <div id="load_gif"> <img  src="/static/mySh/images/load.gif" alt="ЗАГРУЗКА"/></div>
<div class="cart" id="cart" style="display: none">

            <table class="good_list" v-if="list.length>0">
                <tr><th>Название</th><th>Количество</th> <th>Цена</th> <th>Общая стоимость</th><th></th> </tr>

                    <tr v-for="item in list">
                        
                        <td >
                            <img :src="item.image" :alt="item.name" width="70">
                            <div>
                                <p><a :href="item.url">{{item.name}}</a></p>
                            </div>
                        </td>
                        <td>
                           <div class="but" v-if="item.count>1" v-on:click="dec_item(item.id)">-</div>
                            <div>{{item.count}}</div>

                            <div  class="but"  v-on:click="inc_item(item.id)">+</div>
                        </td>
                        <td>


                            <strike v-if="parseFloat(item.old_price).toFixed(2)!=parseFloat(item.price).toFixed(2)">
                                {{parseFloat(item.old_price).toFixed(2)}}&nbsp;р.
                                <br>
                            </strike>


                        <p>  <b>{{parseFloat(item.price).toFixed(2)}}&nbsp;р.</b></p>
                        </td>
                        <td>
                         <p> {{(item.count*(parseFloat(item.price).toFixed(2))).toFixed(2)}}&nbsp;р.</p>
                        </td>
                        <td>
                            <div class="common-but" v-on:click="remove(item.id)">Удалить</div>
                        </td>
                    </tr>
                    <tr>

            </table>

            <div class="order" v-if="list.length>0">

                    <h3 class="head">Сумма и доставка</h3>
                <form action="/cart/ajax" method="get">

                <table>
                    <tr>
                        <td>
                            Сумма покупки:
                        </td>
                        <td>
                            {{ parseFloat(price_items).toFixed(2) }} р.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Доставка:
                        </td>
                        <td>

                            <div v-for="(item,idx) in options_delivery">

                                <input type="radio"
                                       class="radio"
                                       :id="'d'+item.id"
                                       v-model="delivery"
                                       name="delivery"
                                       :value="idx"
                                       >

                                <label :for="'d'+item.id">{{ item.name }} ({{ item.text_price }})</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Итого к оплате:
                        </td>
                        <td>

                            {{ parseFloat(total_price).toFixed(2)}} р.
                        </td>
                    </tr>

                </table>
              <!--  <a href="<?php echo e(route('cart::create_order')); ?>" v-on:click="saveOptionDelivery($event)">
                    <div class="common-but common-but-red">Оформить заказ</div>
                </a>-->

                    <input type="hidden" :value="options_delivery[cart.delivery]['id']" name="id">
                    <input type="hidden" name="action" value="set_option_delivery">
                    <input type="submit"  class="common-but common-but-red common-but_width_full" value="Оформить заказ">
                </form>
            </div>

    <div v-else class="cart-empty"><h3>Корзина пуста</h3>
        <a href="<?php echo e(route('home')); ?>">
            <div class="common-but common-but-red">На главную</div>
        </a>
    </div>
</div>



    </div>
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $('#load_gif').css('display','block');
        $('#cart').css('display','none');

        function load() {
            $.ajax({
                url:'/cart/ajax',
                async:false,
                data:{
                    'action':'getlist',

                },
                success:function (data) {
                    cart.list=data;
                    cart.list.forEach(function (el,indx,array) {
                        cart.price_items+=parseFloat(el.price).toFixed(2)*el.count;
                    });

                    $('#load_gif').css('display','none');
                    $('#cart').css('display','block');
                //    cart.total_price=cart.price_items+cart.delivery;
                    cart.recalculate();
                   // console.log('List Good Loaded');
                }
            });

            $.ajax({
                url:'/cart/ajax',
                async:false,
                data:{
                    'action':'options_delivery',

                },
                success:function (data) {
                    cart.options_delivery=data;
                    cart.recalculate();
                   // console.log('Option Delovery Loaded');
                }
            });

            cart.recalculate();

        }



        var cart=new Vue({
            el:'#cart',
            data: {
                list: {},
                options_delivery:{},
                price_items:0,
                total_price: 0,
                delivery:0,
                price_delivery:0,
                allow_to_send:true,
            },
            watch:{
                total_price:function (val,oldval) {

                   /* if(this.options_delivery[ this.delivery]!== undefined)
                    {
                        if( this.total_price>= this.options_delivery[this.delivery]['border_free']){
                            this.price_delivery=0;

                        }else{
                            this.price_delivery= this.options_delivery[ this.delivery]['price'];
                        }
                    }*/
                    this.recalculate();

                },
                delivery:function (val,oldval) {


                    this.recalculate();

                }

            },
            created:function () {

            },
            mounted:function(){

            },
            methods:{
                saveOptionDelivery:function (event) {
                    id=cart.options_delivery[cart.delivery]['id'];
                    $.ajax({
                        url:"/cart/ajax",
                        data:{
                            'action':'set_option_delivery',
                            'id':id
                        },
                        success:function (data) {
                          //  console.log(data);
                            if(data==0){
                                event.preventDefault();
                                window.location.href="/cart";
                            }
                        }
                    });

                },
                inc_item:function (id) {

                    if(this.allow_to_send){
                        this.allow_to_send=false;
                        $.ajax({
                            url:'/cart/ajax',
                            data:{
                                'action':'inc_item',
                                'id':id,
                            },
                            async:false,
                            success:function (data) {
                                if(data==1){
                                    cart.list.forEach(function (el,indx,ar) {
                                        if(el.id==id){
                                            el.count++;
                                        }
                                    });

                                }
                            }
                        });

                        this.recalculate();

                        setTimeout(function () {
                            cart.allow_to_send=true;
                        },1000);
                    }
                },
                dec_item:function (id) {
                    //alert(url);
                    if(this.allow_to_send){
                        this.allow_to_send=false;
                    $.ajax({
                        url:'/cart/ajax',
                        data:{
                            'action':'dec_item',
                            'id':id,
                        },
                        async:false,
                        success:function (data) {
                            if(data==1){
                                cart.list.forEach(function (el,indx,ar) {
                                    if(el.id==id){
                                        el.count--;
                                    }
                                });

                            }
                        }
                    });
                    this.recalculate();
                    setTimeout(function () {
                        cart.allow_to_send=true;
                    },1000);
                }
                },
                remove:function (id) {
                    this.recalculate();
                    $.ajax({
                        url:'/cart/ajax',
                        data:{
                            'action':'remove_item',
                            'id':id,
                        },
                        async:false,
                        success:function (data) {
                            if(data==1){
                                cart.list.forEach(function (el,indx,arr) {
                                    if(el.id==id){

                                        arr.splice(indx,1);
                                    }
                                });

                            }

                        }
                    });
                    this.recalculate();
                },
                recalculate:function () {
                    if(cart.options_delivery[ cart.delivery]!== undefined)
                    {
                        if( cart.total_price>= cart.options_delivery[cart.delivery]['border_free']){
                            cart.price_delivery=0;

                        }else{
                            cart.price_delivery= cart.options_delivery[ cart.delivery]['price'];
                        }
                    }


                    cart.price_items=0;
                    cart.list.forEach(function (el,indx,array) {
                       // console.log(el.count);
                        cart.price_items+=parseFloat(el.price).toFixed(2)*el.count;
                    });

                    cart.total_price=parseFloat(cart.price_items)+parseFloat(cart.price_delivery);

                    //console.log('Recalculate');
                    //console.log('Recalculate');

                    header_cart.refresh();
                }
            }
        });
        load();
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>