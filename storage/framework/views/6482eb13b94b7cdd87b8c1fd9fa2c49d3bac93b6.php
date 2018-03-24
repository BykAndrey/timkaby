<?php $__env->startSection('header'); ?>
    <title><?php echo e($good_item->title); ?> -Timka.by </title>
    <meta name="description" content="<?php echo e($good_item->meta_description); ?>"/>
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('data'); ?>

    <div itemscope itemtype="http://schema.org/Product" class="block_good" id="catalog">
        <?php echo $__env->make('home.parts.elements.breadcrumbls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="head">
            <h2 itemprop="name"><?php echo e($good_item->name); ?></h2>
        </div>

        <div class="card">
            <div   class="base" >
                <?php if($good_item->discount>0): ?>
                    <div class="flag_discount">
                        <img src="<?php echo e(URL::asset('/static/img/red_flag.svg')); ?>" width="100" alt=" flag">
                        <p>-<?php echo e($good_item->discount); ?>%</p>
                    </div>
                <?php endif; ?>

                <div class="photos slider">
                    <!--<div class="image active" style="background-image: url('<?php echo e(URL::asset($good_item->image)); ?>')"></div>-->
                    <?php echo $__env->make('home.parts.elements.slider',['photos'=>$good_item->image], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <meta itemprop="image" content="<?php echo e(URL::asset('/static/imagesItem/'.$good_item->image)); ?>">
                <div class="info">
                    <div class="compact" >
                    <div class="cost-rate-brand">
                    <div class="articul">

                        Артикул: <?php echo e($good_item->articul); ?>

                        <br>
                        Бренд: <?php echo e($good_item->brand); ?>

                    </div>
                        <div class="money">

                            <div class="price">
                                <?php if($good_item->discount>0): ?>
                                <strike>  <?php echo e(sprintf('%.2f',$good_item->price)); ?> р.</strike><br>
                                <?php endif; ?>
                                <?php 
                                    $price=\App\Item::getPrice($good_item->price,$good_item->discount);
                                 ?>
                                    <span>
                                        <?php echo e(explode('.',sprintf('%.2f',$price))[0]); ?>

                                        <sup> <?php echo e(explode('.',sprintf('%.2f',$price))[1]); ?></sup>
                                p.
                                    </span>

                            </div>
                            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <meta itemprop="price" content="<?php echo e($good_item->price); ?>">
                                <meta itemprop="priceCurrency" content="BYN">

                            </div>





                        </div>
                        <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" class="rating"
                             title="<?php echo e($good_item->rating); ?>">

                            <meta itemprop="ratingValue" content="<?php echo e($good_item->rating); ?>">
                            <meta itemprop="bestRating" content="5">
                            <meta itemprop="worstRating" content="1">
                            <meta itemprop="ratingCount" content="<?php echo e($count_comments); ?>">
                            <?php echo $__env->make('home.parts.elements.rating',['rating'=>$good_item->rating,'size'=>20], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>

                    </div>
                    <div class="controls">
                        <quick_order v-if="show==true" :item="<?php echo e(json_encode($good_item)); ?>" v-on:close="close"></quick_order>


                        <button class="common-but common-but_width_full" onclick="addToFavorite(<?php echo e($good_item->id); ?>)">Добавить в избранное</button>

                        <button class="common-but common-but_width_full" v-on:click="setshow()">Быстрая покупка</button>

                        <button class="common-but common-but-red common-but_width_full" onclick="addToCart(<?php echo e($good_item->id); ?>)">Добавать в корзину</button>
                    </div>
                </div>

                    <div>
                       О стоимости и способах доставки уточняйте по телефонам.
                        <br>
                        <b>+375 (29) 565-56-68 (Мтс)</b>
                        <br>
                        <b>+375 (44) 561-51-00 (Velcom)</b>
                    </div>
                    <div class="flex-wrap">
                        <?php foreach($group_goods as $item_gr): ?>
                            <a href="<?php echo e(route('home::card',['caturl'=>$item_gr->caturl,'url'=>$item_gr->url])); ?>" title="<?php echo e($item_gr->name); ?>">
                                <div>  <img src="<?php echo e(URL::asset($item_gr->image)); ?>" alt="<?php echo e($item_gr->name); ?>" width="90"/></div>
                            </a>
                        <?php endforeach; ?>
                    </div>

                </div>

            </div>



            <div class=" tabs">
                <ul>
                    <li><a href="#t1" class="tab active">Описание</a></li>

                    <li><a href="#comments" class="tab">Отзывы</a></li>
                </ul>
                <div itemprop="description" id="t1" class="tab-content active">
                    <?php echo $good_item->description; ?>

                    <br>
                    <?php echo e($good_item->provider); ?>

                </div>


                <div id="comments" class="tab-content">
                    <?php if($allowToComment): ?>
                        <div v-if="allowToComment==true" class="help">
                            Написать что то мотивирующие чтобы написали отзыв.
                        </div>
                    <div v-if="allowToComment==false" class="help">
                        Ваш отзыв проходит проверку у модератора.
                    </div>
                    <div v-if="allowToComment==true">
                        <span >Ваше имя: </span><span><?php echo e($user); ?></span><br>
                        <span >Оценка: </span>
                            <select class="common-select" v-model="rating">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        <br>
                        <span >Отзыв: </span>
                        <textarea minlength="30" maxlength="200" cols="30" rows="20" class="common-input" v-model="textComment"></textarea>
                        <span>Количество символов: {{ textComment.length }}/200</span>
                        <br>
                        <button class="common-but" v-on:click="save_comment">Отправить</button>

                    </div>

                    <?php endif; ?>

                    <?php if($user==false): ?>
                            <div class="help help-error">
                                Что бы оставить отзыв на сайте необходимо пройти <a href="#">авторизацию.</a>
                            </div>
                        <?php endif; ?>
                    <div>


                            <div itemprop="review" itemscope itemtype="http://schema.org/Review" class="comment" v-for="item in comments">
                                <p><span>Имя: <b itemprop="author">{{ item.user }}</b></span>  <span>Дата: <b itemprop="datePublished">{{item.created_at.split(' ')[0]}}</b></span><br>
                                </p>
                                <span>Рейтинг:
                                    <template v-for="i in parseInt(item.rating)">
                                        <img src="<?php echo e(URL::asset('static/img/star-full.svg')); ?>" width="10" alt="+">
                                    </template>
                                    <template v-for="i in (5-item.rating)">
                                        <img src="<?php echo e(URL::asset('static/img/star-empty.svg')); ?>" width="10" alt="-">
                                    </template>
                                  </span>
                               <!-- <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                                    <meta itemprop="ratingValue" content="{{ parseInt(item.rating) }}">
                                    <meta itemprop="bestRating" content="5">
                                    <meta itemprop="worstRating" content="0">
                                </div>-->
                                <p itemprop="reviewBody">{{item.comment}}</p>
                            </div>
                        <paginate v-on:reload="reload($event)" :count_pages="maxPage" :current_page="currentPage"  ></paginate>

                    </div>
                </div>
            </div>
            <div>
                <h2 class="head">Похожие товары</h2>
                <div class="list_good">
                    <?php foreach($good_same_category as $value): ?>
                        <?php echo $__env->make('home.parts.elements.good',['item'=>$value], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if(count($last_place)>0): ?>
            <div>
                <h2 class="head red">Вы просматривали</h2>
                <div class="list_good">
                    <?php foreach($last_place as $value): ?>
                        <?php echo $__env->make('home.parts.elements.good',['item'=>$value], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php endforeach; ?>
                </div>
            </div>
<?php endif; ?>



        </div>
    </div>

    <?php $__env->stopSection(); ?>







<?php $__env->startSection('scripts'); ?>

    <script src="<?php echo e(URL::asset('static/js/vue/quick_order.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('static/js/vue/paginate.js')); ?>"></script>
    <script>



        var base=new Vue({
            el:'.base',
            data:{
                show:false
            },
            created:function () {

            },
            methods:{
                setshow:function () {
                    this.show=!this.show;

                },
                close:function () {
                    this.show=!this.show;
                  //  alert(1);
                }
            }

        });


        var comments=new Vue({
            el:'#comments',

            data:{
                comments: <?php   echo json_encode($comments)  ?> ,
                page:1,
                rating:1,
                id_item:<?php echo e($good_item->id); ?>,
                textComment:'',
                allowToComment:true,
                maxPage:<?php echo e($PageComment); ?>,
                currentPage:1
            },
            methods:{
                reload: function (value,$event) {
                    $.ajax({
                        url:'/ajax',
                        data:{
                            'action':'getcomments',
                            'id_item':comments.id_item,
                            'page':value
                        },
                        success:function (data) {
                            comments.comments=data;
                        }
                    })
                    console.log(value);
                    this.currentPage=value;
                },
                save_comment:function(){
                    if(this.allowToComment){
                        if(/*comments.textComment.length>=30 && */comments.textComment.length<=200)

                        $.ajax({
                            url:'/ajax',
                            async:false,
                            data:{
                                'action':'addcomment',
                                'id_item':comments.id_item,
                                'rating':comments.rating,
                                'comment':comments.textComment
                            },
                            success:function (data) {
                                comments.allowToComment=false;
                            }
                        });
                    }
                }
            }

        });
       /* vm.$on('next',function () {
            console.log('next');
        })*/
        //console.log(comments.$refs.paginate.$props.current_page);
    </script>
    <script>
        $(document).ready(function () {

            /*Движение мышки по миниатюрам*/

            $('#miniatures').mousemove(function (e) {
                var position=e.pageX-$(this).offset().left;
                var center=$(this).width()/2;
                var box= $(this).children('.box');
                var left=$(box).position().left;
                var flag=true;
                var widthBox=0;
                $(box).children('.image').each(function (indx,el) {
                    widthBox+=$(el).width();
                });
                setTimeout(function () {
                    flag=true;
                },100);
                if(center-position<0 & flag==true & left>(-widthBox)+$(this).width()){
                    flag=false;
                    $(box).css('left',left-2);
                }
                if(center-position>0  & flag==true & left<0){
                    flag=false;
                    $(box).css('left',left+2);
                }



            });
            /*-----------------------*/
            $('.slider.photos>.list_photo>.image').click(function () {


                $('.display.photo > .window> .image').css('background-image',$(this).css('background-image'));

                $('.display.photo').css('display','block');
            });


            /*-----------------------------------------------------------------------*/
            $('.display.photo > .window .exit').click(function () {
                $('.display.photo').css('display','none');
            });
            $('.display.photo>.back').click(function () {
                $('.display.photo').css('display','none');
            })
            
/**/
            $('#miniatures').children('.box').children('.image').click(function (e) {
                var b=$('#miniatures').children('.box');
                var len=$(b).children('.image').length;
                var l=$('.slider.photos');

                var inA=$('#miniatures').children('.box').children('.image').index(e.target);

                $(b).children('.image').each(function (indx,el) {

                        $(el).removeClass('active');

                });
                $(l).children('.list_photo').children('.image').each(function (i,e) {
                    $(e).removeClass('active');
                });


                var name='';
                $(b).children('.image').each(function (indx,el) {
                    if(indx==inA){
                        $(el).addClass('active');
                         name=$(el).attr('data-image');
                        console.log(name);
                    }
                });
                $(l).children('.list_photo').children('.image').each(function (i,e) {
                    if(i==inA){
                        $(e).addClass('active');
                        $(e).css('background-image','url("/static/imagesItem/'+name+'")');
                        $('.display.photo > .window> .image').css('background-image','url("/static/imagesItem/'+name+'")');
                    }
                });


            });
            /*-------------------------------*/
            function toLeft() {
                var b=$('#miniatures').children('.box');
                var len=$(b).children('.image').length;
                var l=$('.slider.photos');
                var inA=0;
                $(b).children('.image').each(function (indx,el) {
                    if($(el).hasClass('active')){
                        inA=indx;
                        $(el).removeClass('active');
                    }
                });
                console.log(inA);
                inA--;
                if(inA<0){
                    inA=len-1;
                }
                $(l).children('.list_photo').children('.image').each(function (i,e) {
                    $(e).removeClass('active');
                });


                var name='';
                $(b).children('.image').each(function (indx,el) {
                    if(indx==inA){
                        $(el).addClass('active');
                        //$('.display.photo > .window> .image').css('background-image',$(el).css('background-image'));
                        name=$(el).attr('data-image');
                        console.log(name);

                    }
                });

                $(l).children('.list_photo').children('.image').each(function (i,e) {
                    if(i==inA){
                        $(e).addClass('active');
                        $(e).css('background-image','url("/static/imagesItem/'+name+'")');
                        $('.display.photo > .window> .image').css('background-image','url("/static/imagesItem/'+name+'")');
                    }
                });
            }
            /*---------------------------------------*/
            function toRight() {
                var b=$('#miniatures').children('.box');
                var len=$(b).children('.image').length;
                var l=$('.slider.photos');
                var inA=0;
                $(b).children('.image').each(function (indx,el) {
                    if($(el).hasClass('active')){
                        inA=indx;
                        $(el).removeClass('active');
                    }
                });
                console.log(inA);
                inA++;
                if(len<=inA){
                    inA=0;
                }

                $(l).children('.list_photo').children('.image').each(function (i,e) {
                    $(e).removeClass('active');
                });


                var name='';
                $(b).children('.image').each(function (indx,el) {
                    if(indx==inA){
                        $(el).addClass('active');
                        //$('.display.photo > .window> .image').css('background-image',$(el).css('background-image'));
                        name=$(el).attr('data-image');
                        console.log(name);
                    }
                });
                $(l).children('.list_photo').children('.image').each(function (i,e) {
                    if(i==inA){
                        $(e).addClass('active');
                        $(e).css('background-image','url("/static/imagesItem/'+name+'")');
                        $('.display.photo > .window> .image').css('background-image','url("/static/imagesItem/'+name+'")');
                    }
                });
            }
            $('.but.left').click(function () {
                toLeft();
            });
            $('.but.right').click(function () {

                toRight();

            });

            $('.display.photo > .window .left').click(function () {
                toLeft();

            })
            $('.display.photo > .window .right').click(function () {
                toRight();
            })

        });

    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>