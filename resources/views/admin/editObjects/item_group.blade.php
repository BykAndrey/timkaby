@extends('admin.base')

@section('content')
    <h2>Редактирование товара</h2>
    <div id="tabs">
        <ul>
            <li><a href="#object">Товар</a></li>
            <li><a href="#offer">Предложения</a></li>
            <li><a href="#images">Картинки</a></li>

        </ul>
        <div id="object">
            <h3> Основные свойства </h3>
            @include('admin.forms.item_group')
        </div>
        @if(isset($model))
        <div id="offer">
            <h3> Предложения </h3>
            <a href="{{route('admin::good_item_create',['id_good_item_group'=>$model->id])}}">Добавить предложение</a>
          <div id="list_offer" >

              <b>Количество предложений : <b>@{{ length }}</b></b>
              <table class="list">
                  <caption>
                      <td>Image</td>
                      <td>Name</td>
                      <td>Price</td>
                      <td>Discount</td>
                      <td>New</td>
                      <td>Active</td>

                      <td>Edit</td>
                      <td>Remove</td>
                  </caption>
           <tr v-for="item in list">
               <td>
                   <img v-bind:src="slesh(item.image)" alt="" width="150">
               </td>
               <td>
                   @{{ item.name }}
               </td>
               <td><input type="text" :value="item.price" :onblur="'setItemPrice('+ item.id+',this)'"></td>
               <td><input type="text" :value="item.discount" :onblur="'setItemDiscount('+ item.id+',this)'"></td>
               <td>
                   <div v-if="item.is_new==1" class="but but_green" :onclick="'setItemNew('+item.id+',this)'">
                   </div>
                   <div v-if="item.is_new!=1" class="but but_red"  :onclick="'setItemNew('+item.id+',this)'">
                   </div>
               </td>
               <td>
                   <div v-if="item.is_active==1" class="but but_green" v-on:click="setActive(item.id)">
                   </div>
                   <div v-if="item.is_active!=1" class="but but_red"  v-on:click="setActive(item.id)">
                   </div>
               </td>

               <td>
                   <a v-bind:href="editHref(item.id)">Редактировать</a>
               </td>
               <td>
                   <a v-bind:href="deleteHref(item.id)">Удалить</a>
               </td>
           </tr>

              </table>
          </div>

        </div>
        <div id="images">
            <h3>Картинки</h3>
            <form id="upload" method="post" enctype="multipart/form-data" >
                {{csrf_field()}}
                <input type="file" name="file">
                <input type="text">
                <button v-on:click="add($event)">Добавить</button>
            </form>
            <div>
                <div v-for="item in images" >
                    <img :src="'/'+item.image" v-bind:alt="item.name" :title=" item.name" width="150">
                    <input type="text" v-model="item.name">
                    <button v-on:click="saveImg(item.id,item.name)"> Сохранить</button>
                    <button v-on:click="deleteImg(item.id)"> Удалить</button>
                </div>
            </div>
        </div>



            <script src="{{URL::asset('/static/js/admin/admin_item_group.js')}}"></script>
            <script src="{{URL::asset('/static/js/admin/admin_item.js')}}"></script>
        <script>

            var id_item_group={{$model->id}};
            var imagesG=new Vue({
                el:'#images',
                data:{
                    images:{},

                },
                methods:{
                    add:function (event) {
                        event.preventDefault();

                       // console.log($('#upload').children('input[name="_token"]').val());
                        var upload=$('#images>#upload');
                        var form =new FormData();
                        var token=$('#images>#upload').children('input[name="_token"]').val();
                        var image=$('#images>#upload').children('input:file')[0].files[0];

                        var name=$('#images>#upload').children('input[type="text"]').val();

                        form.append('image',image);
                        form.append('name',name);
                        form.append('id_item_group',id_item_group);
                        form.append('_token',token);
                        form.append('action','addImage');
                        $.ajax({
                            url:'/admin/itemgroup/ajax',
                            data: form,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            success:function (data) {
                                //console.log(data);
                                imagesG.refresh();
                            },
                            error:function (data) {
                                console.log(data);
                            },
                        });

                    },
                    deleteImg:function (id) {
                        $.ajax({
                            url:'/admin/itemgroup/ajax',
                            data:{
                                'id_image':id,
                                'action':'deleteImage'
                            },
                            method:'get',
                            success:function (data) {
                                imagesG.refresh();

                            },
                            error:function (data) {
                                alert('ERROR');
                                imagesG.refresh();
                            }

                        });

                    },
                    saveImg:function (id,name) {
                        $.ajax({
                            url:'/admin/itemgroup/ajax',
                            data:{
                                'id_image':id,
                                'name':name,
                                'action':'saveImage'
                            },
                            method:'get',
                            success:function (data) {
                                imagesG.refresh();

                            },
                            error:function (data) {
                                alert('ERROR');
                                imagesG.refresh();
                            }

                        });
                    },
                    refresh:function () {
                          $.ajax({
                              url:'/admin/itemgroup/ajax',
                              data:{
                                  'id_item_group':id_item_group,
                                  'action':'listImage'
                              },
                              method:'get',
                              success:function (data) {
                                  imagesG.images=data;
                                  console.log(data.length);
                              },
                              error:function (data) {
                                  console.log(data);
                              }

                          })
                    }
                }
            });
            imagesG.refresh();






            var listing={};

            var app =new Vue({
                el:'#list_offer',
                data:{
                    list:listing,
                    length:listing.length
                },
                methods:{
                  slesh:function (str) {
                      return '/'+str;
                  },
                    deleteHref:function (id) {
                        return '/admin/item/delete/'+id;
                    },
                    editHref:function (id) {
                        return '/admin/item/edit/'+id;
                    },
                    setActive:function (id) {
                        console.log(1);
                        $.ajax({
                            url: '/admin/item/ajax',
                            data: {
                                'action': 'setActive',
                                'id': id
                            },
                            success: function (data) {
                                app.list.forEach(function (val, ind, ar) {
                                    if (val.id == id) {
                                        val.is_active = data;

                                    }
                                });
                            },
                            error: function () {
                                console.log('error');
                            }
                        });
                        console.log(2);
                    },

                }
            });
            function refresh() {
                $.ajax({
                    url:'{{route('admin::good_item_group_listItem',['id'=>$model->id])}}',
                    method:'get',
                    dataType:'json',

                    success:function (data) {
                        listing=data;
                        app.list=data;
                        app.length=data.length;

                    }
                });
            }
            refresh();

        </script>
            @endif
    </div>


@endsection