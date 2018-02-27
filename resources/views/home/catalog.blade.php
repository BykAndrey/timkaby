@extends('home.base')

@section('header')
    <title>{{$Cat->title}} -Timka.by </title>
    <meta name="description" content="{{$Cat->meta_description}}"/>
@endsection





@section('tree')
    @if(isset($subcat))
    <div class="tree">
        <h2 class="head">{{$Cat->name}}</h2>
        <ul class="no-padding">
        @foreach($subcat as $cat)
            <li>
                <i><a href="{{route('home::catalog',['url'=>$cat->url])}}">{{$cat->name}}</a></i></li>
            @endforeach
        </ul>
    </div>
    @endif
    @endsection

@section('filters')
    <div class="block_filter">
     <!--   <h2 class="head">Фильтры</h2>-->

    <property :properyes="filters"></property>
    </div>
    @endsection


@section('data')

    <div itemscope itemtype="http://schema.org/Product" class="block_good" id="catalog">
        @include('home.parts.elements.breadcrumbls')
        <div class="head">
            <h2 itemprop="name">{{$Cat->name}}</h2>
            <div  itemtype="http://schema.org/AggregateOffer" itemscope itemprop="offers">
                <meta content="{{$count_goods}}" itemprop="offerCount">
                <meta content="{{$max_price}}" itemprop="highPrice">
                <meta content="{{$min_price}}" itemprop="lowPrice">
                <meta content="BYN" itemprop="priceCurrency">
            </div>
        </div>
        <div class="sorting">
           <div>
               <span>Сортировать по:</span>
               <select name="sortby" id="sortby" v-on:change="sortby(true)">
                   <option selected value="1">Цена (убывание)</option>
                   <option value="2">Цена (возрастание)</option>
                   <option value="3">Популярность (убывание)</option>
                   <option value="4">Популярность (возрастание)</option>
               </select>
           </div>


            <div>
                <span>Показывать по:</span> <select name="size" id="size" v-on:change="sizeL(true)">
                    <option selected value="20">20</option>
                    <option value="40">40</option>
                    <option value="60">60</option>
                </select>
            </div>

        </div>
        <div class ="sub_categories">
            @foreach($subcat as $item)
                <div><img src="/{{\App\ItemGroup::getImage($item->image,100,null)}}" alt="{{$item->name}}" width="50">
                        <p>
                            <a href="{{route('home::catalog',['url'=>$item->url])}}"> {{$item->name}}</a>
                        </p>
                </div>
                @endforeach
        </div>
        <div class="list_good">

            @foreach($list_goods as $item)

                @include('home.parts.elements.good',['item'=>$item])

            @endforeach

        </div>
        @include('home.parts.elements.paginate',['current_page'=>$current_page,
        'max_page'=>$count_pages,
        'route'=>'home::catalog',
        'routeParams'=>[
        'url'=>$Cat->url]])



        <div id="load_gif"> <img  src="/static/img/load.gif" alt="ЗАГРУЗКА"/></div>

        <item  :items="listel"> </item>

        <paginate :count_pages="count_pages" :current_page="current_page"></paginate>
        <div itemprop="description">
            {{$Cat->description}}
        </div>
    </div>

    @endsection



@section('scripts')

      <script src="{{URL::asset('static/js/vue/good.js')}}"></script>
      <!--  <script src="{{URL::asset('static/js/compvue/good.js')}}"></script>-->

        <script>
            //import Vue from 'vue'
            $("div.list_good").detach();
            $("div.paginate").detach();
            var list={};
            var page=1;
            var size=$('select#size').val();
            var filterSelectID=[];
            var sortby="";
            var MinPrice=0.01;
            var MaxPrice=501.00;
            var allow_reload=true;








            function getUrlParam() {

                var url= window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                var params=JSON;
                for(var i =0; i<url.length;i++){
                    // params.push([url[i].split('=')[0],url[i].split('=')[1]]);
                    var len=Object.keys(params).length;
                    var flag=false;
                    for(var par in params){
                        // console.log(par,params[par]);

                        if(par==url[i].split('=')[0]){
                           // console.log(url[i].split('=')[0]);
                            params[par]=[params[par],url[i].split('=')[1]];
                            flag=true;
                        }
                    }
                    if(flag==false){
                        params[url[i].split('=')[0]]=url[i].split('=')[1];
                    }

                }
                return params;
            }

    /*****************************************************/
            var params=getUrlParam();
            if(params['page']!=null){
                page=params['page'];
            }else{
                page=1;
            }

            size=params['size']!=null?params['size']:20;
            MinPrice=params.hasOwnProperty('min_price')?params['min_price']:{{$min_price}};
           // MaxPrice=params.hasOwnProperty('rangePrice[]')?params['rangePrice[]'][1]:null
            MaxPrice=params.hasOwnProperty('max_price')?params['max_price']:{{$max_price}};
           // console.log(MaxPrice);
            //var range1= $('#range').data("ionRangeSlider");



            sortby=params.hasOwnProperty('sortby')?params['sortby']:null;
           // console.log([params['filterSelectID[]']]);

            if(params.hasOwnProperty('filterSelectID[]'))
                filterSelectID=filterSelectID.concat(params['filterSelectID[]']);
            else{
                if(params.hasOwnProperty('filterSelectID%5B%5D'))
                    filterSelectID=filterSelectID.concat(params['filterSelectID%5B%5D']);
            }
            //filterSelectID=params.hasOwnProperty('filterSelectID[]')?[]:[];

            if(params.hasOwnProperty('sortby')){
                $('select#sortby option[value='+params['sortby'][0]+']').attr('selected', 'selected');
            }

            if(params.hasOwnProperty('size')){
                $('select#size option[value='+params['size']+']').attr('selected', 'selected');
            }

            //console.log($('select#sortby').val());
            /***********************************/




            function getlist() {

                $('#load_gif').css('display','block');

                $.ajax({
                    url:'/catalog/{{$Cat->url}}',
                    async:false,
                    data:{
                        //'action':'getListItemGroup_Catalog',
                        //'url':'{{$Cat->url}}',
                        'page':page,
                        'size':size,
                        'filterSelectID':filterSelectID,
                        'sortby':sortby,
                        'min_price':MinPrice,
                        'max_price':MaxPrice,
                        'rangePrice':[MinPrice,MaxPrice],
                        'image_size':[200,null]

                    },
                    success:function (data) {
                       // console.log(data);
                        app.listel=data['goods'];
                        app.count_pages=data['count_pages'];
                        app.current_page=data['current_page'];
                        vm.count_pages= app.count_pages;
                        aside.property=data['property'];
                        aside.filters=data['filters'];
                     //   console.log(data['max_price']);
                        //app.max_price=data['max_price'];
                        //Prop.$el.maxPrice=data['max_price'];
                        //Prop.setMaxPrice();
                        //console.log( Prop.maxPrice);
                        $('#load_gif').css('display','none');



                        var urlParam={
                           //'rangePrice':[MinPrice,MaxPrice],

                        };


                        MinPrice>0?urlParam['min_price']=MinPrice:0;

                        page==1?null:urlParam['page']=page;
                        //alert(filterSelectID);
                        filterSelectID==null?null:urlParam['filterSelectID']=filterSelectID;


                        //urlParam['filterSelectID']=[1];
                        size!=20?urlParam['size']=size:null;
                        sortby!=null?urlParam['sortby']=sortby:null;

                       // console.log(Object.keys(urlParam).length);
                        if(Object.keys(urlParam).length>=1){

                            var st=jQuery.param(urlParam);
                            window.history.pushState(urlParam,'','?'+st);
                        }
                    /*    $('#range1').data("ionRangeSlider").update({
                            from:MinPrice,
                            to:MaxPrice
                        });
    */
                        //window.history.pushState(st);
                    },
                    error:function (data) {
                       /* alert(data.text);*/
                        getlist();
                    }
                });
            }

            ////////////PAGINATE////////////////////
            var vm=Vue.component('paginate',{
                template:`
                <div class="paginate">

                <a href="#" v-on:click="prev()">
                    <div class="point"><<</div>
                </a>

                    <a href="#" v-for="i in count_pages" v-on:click="point(i)" >
                        <div class="point selected" v-if="i==current_page">@{{ i }}</div>
                        <div class="point" v-else>@{{ i }}</div>
                    </a>


                <a href="#" v-on:click="next()">
                    <div class="point">>></div>
                </a>
            </div>

                `,
                props:['count_pages','current_page'],
               /* data:function () {
                    return{
                        count_pages: 0,
                        current_page:0
                    }
                },*/
                methods:{
                    next:function () {
                        if(page+1<=this.count_pages){
                            page++;
                            current_page=page;
                            getlist();
                        }
                    },
                    prev:function () {
                        if(page-1>0){
                            page--;
                            current_page=page;
                            getlist();
                        }

                    },
                    point:function (p) {
                        page=p;
                        current_page=page;
                        getlist();

                    },

                }

            });
            vm.count_pages=1;



            /////////////////GOOD//////////////////

            Vue.component('item',{
                template:`
                <div class="list_good">
                    <good v-for="item in items"
                      :item="item"
                      :key="item.id"></good>
                <h2 v-if="items.length==0">По данным фильтрам товара нет.</h2>
                </div>
                `,
                props:['items'],
                methods:{
                    getUrl:function (caturl,url) {
                        var url='/catalog/'+caturl+'/'+url;
                        return url;
                    },
                    toCatd:function (caturl,url) {
                         window.location=this.getUrl(caturl,url);
                    }
                }
            });

            //console.log(getUrlParam()['rangePrice[]'][0]);

            ///////////////////FILTERS//////////////////////////////////
            var Prop=Vue.component('property',{
                template:`<div>
                        <ul>
                        <li class="range">
                            <h5 class="head">Цена</h5>
                            <span>От:</span>
                            <input type="number"  step="0.01"  placeholder="0.01" v-model="minPrice" >
                            <span>До:</span>
                            <input type="number" step="0.01" placeholder="500.00" v-model="maxPrice">
                          </li>
                            <li v-for="item in properyes" >
                         <h5 class="head"> @{{item.name}}</h5>
                          <ul>

                          <li v-for="sel in item.selects" >
                                        <input
                                        :id="'f-'+sel.id"
                                        :name="'f-'+sel.id"
                                        type="checkbox"
                                        class="radio"
                                        :value="sel.id"
                                        v-model="filterselect">



                                        <label :for="'f-'+sel.id"> @{{ sel.value }}</label>

                                    </li>
                                </ul>
                            </li>

                        </ul>

                        <button v-on:click="filterSet()">Применить</button>

    </div>`,
                props:['properyes'],
                data:function () {
                    return {
                        filterselect:filterSelectID,
                        minPrice:MinPrice,
                        maxPrice:MaxPrice
                       // Price:MinPrice+';'+MaxPrice
                    }
                },
                methods:{
                    filterSet:function () {
                        filterSelectID=this.filterselect;

                        MinPrice=this.minPrice;
                        MaxPrice=this.maxPrice;


                        page=1;
                        getlist();
                    },
                    setMaxPrice:function () {
                        //this.maxPrice=price;
                        console.log(this.maxPrice);
                    }
                }
            });



            var aside=new Vue({
                el:'#aside',

                data:{
                    property:{},
                    filters:{}
                }
            })



           var app= new Vue({
                el:'#catalog',

                data:{
                    listel:list,
                    count_pages:1,
                    current_page:1,


                },
               created:function () {






               },
               methods:{
                    sortby:function (reload=false) {

                        sortby=$('select#sortby').val();
                        if(reload==true){
                            page=1;
                            current_page=1;

                            getlist();
                        }

                    },
                   sizeL:function () {

                       size=$('select#size').val();
                       page=1;
                       current_page=1;
                       getlist();

                   },

               }
            });

           getlist();
        </script>




    <script>



        $(document).ready(function () {

            $('.block_filter ul>li>h5').click(function () {

                var flag=false;
                var par=$(this).parent();
                if($(par).children('ul').css('display')=='none')
                {
                    $(par).children('ul').animate({'height':'show'},500);
                }
                else
                {

                    $('.block_filter ul>li>ul>li').click(function () {

                        flag=true;


                    });
                    if(flag==false)
                    {
                        $(par).children('ul').animate({'height':'hide'},500);
                    }
                }

            });

        });


    </script>






    @endsection