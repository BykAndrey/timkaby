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
                        
                        <td style="display: flex;">
                            <img :src="item.image" alt="">
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


                            <strike v-if="(item.old_price).toFixed(2)!=(item.price).toFixed(2)">
                                {{(item.old_price).toFixed(2)}}&nbsp;р.
                                <br>
                            </strike>


                            <b>{{(item.price).toFixed(2)}}&nbsp;р.</b>
                        </td>
                        <td>
                            {{(item.count*(item.price).toFixed(2)).toFixed(2)}}&nbsp;р.
                        </td>
                        <td>
                            <div class="common-but" v-on:click="remove(item.id)">Удалить</div>
                        </td>
                    </tr>
                    <tr>

            </table>

            <div class="order" v-if="list.length>0">

                    <h3 class="head">Сумма и доставка</h3>

                <table>
                    <tr>
                        <td>
                            Сумма покупки:
                        </td>
                        <td>
                            {{ (price_items).toFixed(2) }} р.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Доставка:
                        </td>
                        <td>
                         <!--   <input type="radio" class="radio" id="delivery" name="delivery" v-model="delivery" value="1">
                            <label for="delivery">Курьером (4 р.)</label><br>

                            <input type="radio" class="radio" id="delivery1" v-model="delivery" name="delivery" value="2">
                            <label for="delivery1">Самовывоз (г.Борисов)</label>-->
                            <div v-for="item in options_delivery">

                                <input type="radio"
                                       class="radio"
                                       :id="'d'+item.id"
                                       v-model="delivery"
                                       name="delivery"
                                       :value="item.price">

                                <label :for="'d'+item.id">{{ item.name }} ({{ item.price==0?'Бесплатно':item.price+'р.' }})</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Итого к оплате:
                        </td>
                        <td>
                            {{ (total_price+delivery).toFixed(2)}} р.
                        </td>
                    </tr>

                </table>
                <a href="#"> <div class="common-but common-but-red">Оформить заказ</div></a>
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

        var cart=new Vue({
            el:'#cart',
            data: {
                list: {},
                options_delivery:{},
                price_items:0,
                total_price: 0,
                delivery:0,
                allow_to_send:true,
            },
            created:function () {
                $.ajax({
                    url:'/cart/ajax',
                    data:{
                        'action':'getlist',

                    },
                    success:function (data) {
                        cart.list=data;
                        cart.list.forEach(function (el,indx,array) {
                            cart.price_items+=el.price.toFixed(2)*el.count;
                        });

                        $('#load_gif').css('display','none');
                        $('#cart').css('display','block');
                        cart.total_price=cart.price_items+cart.delivery;
                    }
                });

                $.ajax({
                    url:'/cart/ajax',
                    data:{
                        'action':'options_delivery',

                    },
                    success:function (data) {
                        cart.options_delivery=data;

                    }
                });




            },
            methods:{
                inc_item:function (id) {
                    //alert(url);
                    //alert(id);
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
                    cart.price_items=0;
                    cart.list.forEach(function (el,indx,array) {
                        console.log(el.count);
                        cart.price_items+=el.price.toFixed(2)*el.count;
                    });
                    cart.total_price=cart.price_items+cart.delivery;
                    header_cart.refresh();
                }
            }
        })
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>