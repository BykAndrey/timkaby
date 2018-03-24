<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="<?php echo e(URL::asset('/favicon.ico')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo e(URL::asset('static/css/mainstyle.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(URL::asset('static/css/media.css')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">






   <!-- <script src="https://unpkg.com/vue"></script>
    <script async src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>-->
  <!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>-->
    <script src="<?php echo e(URL::asset('static/js/plugin/jquery-3.2.1.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('static/js/plugin/vue.min.js')); ?>"></script>



    <?php echo $__env->yieldContent('header'); ?>
</head>


<body>
<header>
    <div class="topnav">
        <div class="container">

            <div class="menu">

                <?php if($user==false): ?>
                    <p><img src="<?php echo e(URL::asset('static/img/key.svg')); ?>" alt="Вход" width="18" title="Вход">
                        <a href="<?php echo e(route('user::login')); ?>"> Вход</a>
                    </p>
                    <p><img src="<?php echo e(URL::asset('static/img/key.svg')); ?>" alt="Регистрация" width="18" title="Регистрация">
                        <a href="<?php echo e(route('user::registration')); ?>">Регистрация</a>
                    </p>
                <?php endif; ?>
                <?php if($user!=false): ?>

                        <p>

                            <a href="<?php echo e(route('user::profile')); ?>">
                            <img src="<?php echo e(URL::asset('static/img/user.svg')); ?>" alt="<?php echo e($user); ?>" width="18">

                                    <span> <?php echo e($user); ?></span>
                               </a>
                        </p>
                        <p>

                            <a href="<?php echo e(route('user::like-good')); ?>">
                                <img src="<?php echo e(URL::asset('static/img/heart.svg')); ?>" alt="Избранное" width="18">
                                <span>
                                    Избранное
                                </span>
                            </a>
                        </p>
                        <p>
                            <a href="<?php echo e(route('user::logout')); ?>"><img src="<?php echo e(URL::asset('static/img/key.svg')); ?>" alt="Выход" width="18">
                                <span>
                                    Выход
                                </span>
                            </a>
                        </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="middle-marks container">
        <div class="mark">
            <div class="work_time">

            </div>
            <div>
                <p>
                  <b> Рабочее время</b>
                </p>
                <span>
                    Пн-Пт: 09:00 - 21:00
                </span>
            </div>
        </div>
        <div class="mark">
            <div class="telephone">

            </div>
            <div>
                <p>
                   <b>Vel: +375 (44) 561-51-00</b>
                </p>
                <p>
                    <b>Мтс: +375 (29) 565-56-68</b>
                </p>
               <!-- <span>
                   Сделать заказ можно сейчас
                </span>-->
            </div>
        </div>
        <div class="mark">
            <div class="delivery_image">

            </div>
            <div>
                <p>
                    <b> Бесплатная доставка</b>
                </p>
                <span>
                    от 50 руб
                </span>
            </div>
        </div>
    </div>
    <div class="logo-search-cart container">
        <div class="logo">
            <a href="/">Timka.by</a>
        </div>
        <div class="search" id="search">
            <form action="<?php echo e(route('search')); ?>" method="get">
                <div class="search_select">
                    <select data-v-model="id_category" name="id_category">
                        <option selected value="0">Все категории</option>
                        <?php foreach($categories_search as $cat): ?>
                                <option  value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="search_input">
                    <input type="text" minlength="4" v-model="what_search" id='what_search' name="what_search" @keyup="search()" placeholder="Поиск . . .">
                    <ul style="display: none">
                        <li v-if="response.length>0" v-for="item in response">
                            <img :src="'/'+item.image" :alt="item.name" width="50" >
                            <a :href="'/catalog/'+item.caturl+'/'+item.url" v-html="item.name"></a>
                            <b v-if="item.discount>0" class="red">{{ parseFloat(item.price).toFixed(2) }}&nbsp;р.</b>
                            <b v-else>{{parseFloat(item.price).toFixed(2)}}&nbsp;р.</b><br>

                        </li>

                    </ul>
                </div>
                <div class="search_submit">
                    <input type="submit" value="">
                </div>
            </form>
        </div>
        <div class="header_cart" id='header_cart'>
            <a href="<?php echo e(route('cart::home')); ?>"><div class="tocart">

            </div></a>
            <div class="info" style="display: none;">
                <p>
                    <a href="<?php echo e(route('cart::home')); ?>">Корзина</a>
                </p>
                <span>
                        {{count}}&nbsp;товар(а)&nbsp;- <b><u>{{ (good_price).toFixed(2) }}&nbsp;р.
                           <!-- <sup>{{ (Math.abs(Math.floor(good_price)-(good_price).toFixed(2))).toFixed(2)*100 }}</sup>
                           -->
                        </u></b>
                    </span>
            </div>
        </div>
    </div>
    <div class="navigation">
        <nav class="container">
            <ul>

                <li><a href="<?php echo e(route('home')); ?>">Главная</a></li>
                <?php foreach($base_menu as $i): ?>
                    <li><a href="<?php echo e(route('infopage',['url'=>$i['url']])); ?>"><?php echo e($i['name']); ?></a></li>
                    <?php endforeach; ?>
                <li><a href="/news">Новости</a></li>

                <li><a href="<?php echo e(route('home::base_catalog',['is_new'=>1])); ?>">Новинки!</a></li>
            </ul>
        </nav>
    </div>
</header>
<!--END HEADER-->
<!--DISPLAY-->
<div class="display photo">
    <div class="back"></div>
    <div class="window">
        <div class="image">

        </div>
        <div class="controls">
            <div class="exit">
                <img src="<?php echo e(URL::asset('static/img/cross.svg')); ?>" alt="Закрыть" width="25">
            </div>
            <div class="left"><img src="<?php echo e(URL::asset('static/img/left-black.svg')); ?>" alt="Влево" width="35"></div>
            <div class="right"><img src="<?php echo e(URL::asset('static/img/right-black.svg')); ?>" alt="Вправо" width="35"></div>
        </div>
    </div>
</div>
<!--END DISPLAY-->
<!--CONTENT-->
<div class="content container">
    <!--SIDE MENU-->
    <div class="aside_toggle">
        <img src="<?php echo e(URL::asset('static/img/arrow_down.svg')); ?>" alt="Развернуть панель" width="15">
    </div>
    <aside id='aside'>
        <div class="cat_menu">
        <div class="toggle">
            <img src="<?php echo e(URL::asset('static/img/menu.svg')); ?>" alt="Открыть меню" width="25">
            <h2>Категории</h2><img src="<?php echo e(URL::asset('static/img/arrow_down.svg')); ?>" alt="Открыть меню" width="15">
        </div>
        <ul class="list"> <!-- <img src="images/iconmonstr-arrow-25.svg" width="15" alt="">-->

            <?php foreach($good_category as $item): ?>
                <li>
                    <div>
                        <a href="<?php echo e(route('home::catalog',['url'=>$item->url])); ?>"><?php echo e($item->name); ?></a>
                        <?php if(count($item->subcat)>0): ?>
                            <img src="<?php echo e(URL::asset('static/img/iconmonstr-arrow-25.svg')); ?>" width="15" alt="Раскрыть">
                        <?php endif; ?>
                    </div>
                    <?php if(count($item->subcat)>0): ?>

                    <div>
                        <ul>
                            <?php foreach($item->subcat as $sub): ?>
                                <li><a href="<?php echo e(route('home::catalog',['url'=>$sub->url])); ?>">
                                        <img src="/<?php echo e(\App\ItemGroup::getImage($sub->image,100,null)); ?>" alt="<?php echo e($sub->name); ?>" width="100">
                                        <span><?php echo e($sub->name); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                    </div>

                    <?php endif; ?>
                </li>
                <?php endforeach; ?>

        </ul>
        </div>
        <?php echo $__env->yieldContent('tree'); ?>
        <?php echo $__env->yieldContent('filters'); ?>




    <!-- VK Widget -->
        <div id="vk_groups"></div>


        <!--NESW WIDGET-->
        <?php echo $__env->make('home.parts.elements.newsWidget', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div  class="side_cycles">

        <div id="move_to_top" class="block color-red">
            <div class="cycle">
                <img src="<?php echo e(URL::asset('/static/img/top_white.svg')); ?>" alt="ВВЕРХ!" width="35">
            </div>
            <div class="message" >
                <div class="message-content"><span>Товар успешно добавлен!</span></div>
            </div>

        </div>

    </div>
    </aside>
    <!--END SIDE MENU-->
    <!--DATA-->
    <div class="data">
    <?php echo $__env->yieldContent('data'); ?>
        
    </div>
    <!--END DATA-->
</div>
<!--END CONTENT-->

<!--FOOTER-->
<footer>
    <div class="container container_content-space-between top">
        <div class="perc-15">
            <h4>О магазине</h4>
            <ul>
                <li><a href="<?php echo e(route('home')); ?>">Главная</a></li>
                <?php foreach($base_menu as $i): ?>
                    <li><a href="<?php echo e(route('infopage',['url'=>$i['url']])); ?>"><?php echo e($i['name']); ?></a></li>
                <?php endforeach; ?>
                <li><a href="/news">Новости</a></li>
            </ul>
        </div>
        <div class="perc-15">
           <h4>Время работы</h4>
            <ul>
                <li>Пн  - 9  <sup>00</sup> - 21<sup>00</sup> </li>
                <li>Вт  - 9  <sup>00</sup> - 21<sup>00</sup> </li>
                <li>Ср  - 9  <sup>00</sup> - 21<sup>00</sup> </li>
                <li>Чт  - 9  <sup>00</sup> - 21<sup>00</sup> </li>
                <li>Пт  - 9  <sup>00</sup> - 21<sup>00</sup> </li>
                <li>Cб-Вс  - Выходной </li>
            </ul>
        </div>
        <div class="perc-30" itemscope itemtype="http://schema.org/Organization">
            <h4>Контактные данные</h4>
            <meta itemprop="name" content="Timka.by">
            <ul>
                <li class="center">
                    <img src="<?php echo e(URL::asset('static/img/MTS.svg')); ?>"  height="20" alt="MTS">
                    <span itemprop="telephone">
                        +375 (29) 565-56-68
                    </span>
                </li>
                <li class="center">
                    <img src="<?php echo e(URL::asset('static/img/velcome2.svg')); ?>"  height="20" alt="Velcom">
                    <span itemprop="telephone">
                        +375 (44) 561-51-00
                    </span>
                </li>
               <!-- <li class="center">
                    <img src="<?php echo e(URL::asset('static/img/Life.svg')); ?>"  height="20" alt="Life:)">
                    <span itemprop="telephone">+375 (25) 111-22-22</span>
                </li>-->
                <li class="center">
                    Email:
                    <span itemprop="email">support@timka.by</span>
                </li>
            </ul>
           <!-- <p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                Юридический адрес:
                <span itemprop="streetAddress">ул. Петрова д.7</span>
                <span itemprop="postalCode">222142</span>
                <span itemprop="addressLocality">Минск</span>
            </p>-->
        </div>
        <div class="perc-25">
            <h4>Социальные сети</h4>
            <div class = "container container-full-width container_content-space-between">
                <a href="https://vk.com" target="_blank">
                   <!-- <object type="image/svg+xml" data="<?php echo e(URL::asset('static/img/facebook.svg')); ?>" class="logo" width="40">
                        Kiwi Logo <!-- fallback image in CSS
                    </object> -->
                       <img src="<?php echo e(URL::asset('static/img/facebook.svg')); ?>" alt="vk.com" width="40">
                </a>
                <a href="#" target="_blank">
                <object type="image/svg+xml" data="<?php echo e(URL::asset('static/img/instagram.svg')); ?>" class="logo" width="40">
                    Kiwi Logo <!-- fallback image in CSS -->
                </object>
                </a>
                    <a href="#" target="_blank">
                <object type="image/svg+xml" data="<?php echo e(URL::asset('static/img/vk.svg')); ?>" class="logo" width="40">
                    Kiwi Logo <!-- fallback image in CSS -->
                </object>
                    </a>
                        <a href="#" target="_blank">
                            <object type="image/svg+xml" data="<?php echo e(URL::asset('static/img/ok.svg')); ?>" class="logo" width="40">
                                Kiwi Logo <!-- fallback image in CSS -->
                            </object>
                        </a>




            </div>
            <div class = "container container-full-width container_content-space-between container_flex-direction-column">
                <h4>Поиск</h4>
                <div>
                    <form action="<?php echo e(route('search')); ?>" method="get">
                        <input type="hidden" name="id_category" value="0">
                        <input type="text" class="common-input"  name="what_search"  placeholder="Найти . . ."><br><br>
                        <input type="submit" class="common-but" value="Найти">
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="container container-full-width container_content-center bottom">
        <span><b>Timka.by</b> - интернет-магазине детских товаров. Created by <a href="mailto:andreybyk9606@gmail.com"><b>Andrey Byk</b></a></span>

    </div>
</footer>
<!--END FOOTER-->

<!--
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>-->
<script src="<?php echo e(URL::asset('static/js/plugin/jquery.maskinput.js')); ?>" ></script>
<script src="<?php echo e(URL::asset('static/js/interface.js')); ?>" ></script>

<script src="<?php echo e(URL::asset('/static/js/vue/cart.js')); ?>"></script>

<script src="<?php echo e(URL::asset('/static/js/ajax_action.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/static/js/myslider.js')); ?>"></script>

<script>

    $(document).ready(function () {
        $.mask.definitions['~']='[+-]';
        $('.phone_mask').mask('+375 (99) 999-99-99');
        $('.widget-news').simple_slider();
       $('#search #what_search').blur(function () {
            setTimeout(function () {
                $('#search form .search_input ul').animate({'height':'hide'},500);
            },500);

        });


    });

    var search=new Vue({
        el:'#search',
        data:{
            what_search:'',
            id_category:0,
            response:{}
        },
        methods:{
            search:function () {
                if(this.what_search.length>=4){
                    console.log(this.what_search);
                    $.ajax({
                        url:'/ajax',
                        method:'get',
                        data:{
                            'action':'search',
                            'id_category':search.id_category,
                            'what_search':search.what_search
                        },
                        success:function (data) {
                            search.response=data['goods'];
                            $('#search form .search_input ul').animate({'height':'show'},500);
                        },
                        error:function () {
                            alert('Произошла ошибка!');
                        }
                    })
                }else{
                    $('#search form .search_input ul').css('display','none');
                }

            }
        }
    });
</script>
<?php echo $__env->yieldContent('scripts'); ?>



<script src="//vk.com/js/api/openapi.js?151"></script>


<script >
    VK.Widgets.Group("vk_groups", {mode: 3, width: "250"}, 51038851);
</script>
</body>

</html>
