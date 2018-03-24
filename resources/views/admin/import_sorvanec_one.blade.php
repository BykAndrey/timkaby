@extends('admin.base')



@section('content')

    <h1>Import Sorvanec.by One Good</h1>
    <div class="import_good" id="import_good">
        <div class="block left">
            <h2>Left</h2>
            <fieldset>
                <legend>Load Info</legend>
                <label for="">URL of good</label><br>
                <input type="text" v-model="url">
                <button class="btn" v-on:click="load($event)">Load</button>
            </fieldset>
            <fieldset>
                <legend>Info</legend>
                <template v-if="good==null">
                    <h2>Good've not been loaded</h2>
                </template>
                <template v-if="good!=null">

                    <label for="">Name</label><br>
                    <input type="text" v-model="good.title">

                    <label for="">Title</label><br>
                    <input type="text" v-model="good.page_title">

                    <label for="">Price</label><br>
                    <input type="text" v-model="good.price">

                    <label for="">Discount</label><br>
                    <input type="text" v-model="good.discount">

                    <label for="">Articul</label><br>
                    <input type="text" v-model="good.articul">

                    <label for="">Description</label><br>
                    <textarea cols="30" rows="10" v-model="good.description" class="text_redactor_">

                    </textarea>
                    <button class="btn" v-on:click="on($event)">On Redactor</button>
                    <hr>
                    <label for="">Seo description</label><br>
                    <textarea v-model="good.seo_description" cols="30" rows="10">
                    </textarea>

                </template>
            </fieldset>





        </div>
        <div class="block right">
            <h2>Right</h2>
            <template v-if="good!=null">
                <div class="create_offers">

                    <template v-if="item_group==0">
                        <label for="">Categories</label>
                        <select id="category" v-model="category" class="select-full">
                            <option value="0">ВСЕ</option>
                            @foreach($cats as $key=>$item)
                                <optgroup label="{{$key}}">
                                    @foreach($item as $k=>$i)

                                            <option  value="{{$k}}">{{$i}}</option>

                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <label for="">Providers</label>
                        <select  class="select-full" v-model="provider">
                            @foreach($providers as $item)
                                <option  value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <label for="">Brands</label>
                        <select  class="select-full" v-model="brand">
                            @foreach($brands as $item)
                                <option  value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>


                        <div class="images">
                            <div v-for="item in images" class="image">

                                    <img :src="'https://sorvanec.by/images/baby_shop/goods/'+item.image" width="100">



                                <div>
                                    <input type="checkbox" v-model="item.will_add"> <label for="">Добавить галлерею товара</label>
                                    @{{item.will_add}}
                                </div>
                            </div>
                        </div>
                        <button class="btn" v-on:click="create_item_group($event)">Create "GOOD"</button>
                    </template>
                    <div v-for="item in offers" :class="'offer '+(item_group!=0?' ':' disabled')">
                        <img :src="'https://sorvanec.by/images/baby_shop/goods/'+item.image" width="200">
                        <div>
                            <label for="">Добавить к основному имени</label><input type="text" v-model="item.name" ><br>
                            <label for="">Добавить к URL</label><input type="text" v-model="item.url"><br>
                            <label for="">Добавить к Title</label><input type="text" v-model="item.title"><br>
                            <button class="btn" v-on:click="create_item($event,item)">Create "Offer"</button>
                        </div>
                    </div>
                </div>
            </template>
        </div>


    </div>
    @endsection




@section('scripts')


    <script>
        var load_one_good=new Vue({
            el:'#import_good',
            data:{
                url:'',
                good:null,
                category:0,
                provider:0,
                brand:0,
                item_group:0,
                offers:[],
                images:[]

            },
            watch:{
                good:function(val,oldVal){
                    if(val!=null){
                        $('.text_redactor_').jqte();
                    }
                }
            },
            methods:{
                /*включает редактор*/
                on:function (ev) {
                    ev.preventDefault();
                    $('.text_redactor_').jqte();
                },
                /*Загрузка Данных с сорванца*/
                load:function (env) {
                    env.preventDefault();
                    var url=this.url;
                    var good=null;
                    this.good=null;
                    this.item_group=0;
                    this.offers=[];
                    this.images=[];
                    /*Load data from site*/
                    $.ajax({
                        url:'/admin/import/ajax',
                        async:false,
                        data:{
                            'action':'get_data',
                            'url':url
                        },
                        success:function (data) {
                           if(parseInt(data)==0){
                               console.log('Not Found');
                           }else{
                               good=data;
                           }

                        },
                    });

                    this.good=good;
                    this.offers.push({
                        'image':good.imgfile_name,
                        'pref_name':'',
                        'pref_title':'',
                        'pref_url':''
                    });

                  for(var i=0;i<good.images.length;i++){
                      this.offers.push({
                          'image':good.images[i].imgfile_name,
                          'pref_name':'',
                          'pref_title':'',
                          'pref_url':''
                      });
                  }
                    this.images.push({
                        'image':good.imgfile_name,
                        'will_add':false
                    });
                    for(var i=0;i<good.images.length;i++){
                        this.images.push({
                            'image':good.images[i].imgfile_name,
                            'will_add':false
                        });
                    }



                    console.log(this.offers);
                    /*end load*/
                    $('.jqte').each(function () {
                        $(this).detach();

                    });
                },
                /*Создает товар*/
                create_item_group:function (e) {
                    e.preventDefault();
                    console.log('create_item_group');
                    var good=this.good;
                    var cat=this.category;
                    var prov=this.provider;
                    var brand=this.brand;
                    var images=this.images;
                    var item_group=0;
                    console.log(images[0]['will_add']);
                    //if(false){
                  if(cat!=0){


                        $.ajax({
                            url:'/admin/import/ajax',
                            async:false,
                            method:'post',
                            data:{
                                'action':'create_item_group',
                                '_token':'{{csrf_token()}}',
                                'good':good,
                                'cat':cat,
                                'provider':prov,
                                'brand':brand,
                                'images':images
                            },
                            success:function (data) {
                                console.log(data);
                                if(data!="path"){
                                    item_group=parseInt(data);
                                }else {
                                    alert(data);
                                }

                            }
                        });
                        if(item_group!=0){
                            this.item_group=item_group;

                        }

                    }else{
                        alert('Выберите категорию');
                    }
                },
                /*
                *
                * */
                create_item:function (e,item) {
                    e.preventDefault();
                    console.log('Create_item');
                    var good=this.good;
                    var item_group=this.item_group;
                    var offer=item;


                    if(item_group!=0){


                        $.ajax({
                            url:'/admin/import/ajax',
                            async:false,
                            method:'post',
                            data:{
                                'action':'create_item',
                                '_token':'{{csrf_token()}}',
                                'good':good,
                                'offer':offer,
                                'item_group':item_group
                            },
                            success:function (data) {
                                console.log(data);
                                if(data!="path"){
                                    item_group=parseInt(data);
                                    $(e.target).removeClass('btn-bad');
                                    $(e.target).addClass('btn-good');
                                }else {
                                    alert(data);
                                    $(e.target).removeClass('btn-good');
                                    $(e.target).addClass('btn-bad');
                                }


                            }
                        });
                    }


                }
            }
        })
    </script>
    @endsection