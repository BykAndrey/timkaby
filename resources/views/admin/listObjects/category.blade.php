@extends('admin.base')

@section('content')
    <h2>Список категорий</h2>
    <ul class="controllers_list">
        <li><a href="{{route('admin::good_category_create')}}">Добавить категорию</a></li>
        <li  id="search">Поиск: <input type="text" v-model="what"> <button v-on:click="searchM()">Найти</button>
            <div class="answer"><ul>
                    <li v-on:click="close()">Закрыть</li>
                    <li v-for="item in searchanswer" ><a :href="'/admin/category/edit/'+item.id">@{{ item.name }}</a></li>
                </ul>
            </div>
        </li>
    </ul>
    <table class="list">
        <colgroup>
            <col width="1%" span="1" style="background-color:#deffda">
            <col width="25%" span="1" style="background-color:#cedeff">

            <col width="1%" span="1" style="background-color:#deffda">
            <col width="1%" span="1" style="background-color:#cedeff">


            <col width="1%" span="1" style="background-color:#cedeff">
        </colgroup>
        <tr>
            <th>ID <br>(<a href="{{route('admin::good_category',['page'=>1,'sortby'=>'id','sortMethod'=>'desc'])}}">убв.</a>
                <a href="{{route('admin::good_category',['page'=>1,'sortby'=>'id','sortMethod'=>'asc'])}}">возр.</a>)</th>

            <th>Название (<a href="{{route('admin::good_category',['page'=>1,'sortby'=>'name','sortMethod'=>'desc'])}}">убв.</a>
                <a href="{{route('admin::good_category',['page'=>1,'sortby'=>'name','sortMethod'=>'asc'])}}">возр.</a>)</th>

            <th>Active</th>
            <th>Edit</th>
            <th>Delete</th>


        </tr>
        @foreach($category as $item)

            <tr>
                <td>{{$item->id}}</td>
                <td><b>{{$item->name}}</b> (товаров: {{$item->count_items}})</td>

                <td>{{$item->is_active}}</td>
                <td><a href="{{route('admin::good_category_edit',['id'=>$item->id])}}">Редактировать</a>
                </td><td><a href="{{route('admin::good_category_delete',['id'=>$item->id])}}">Удалить</a></td>
            </tr>
            @foreach($item->sub_cat as $i)

                <tr>
                    <td>{{$i->id}}</td>
                    <td>---->><b>{{$i->name}}</b> (товаров: {{$i->count_items}})</td>

                    <td>{{$i->is_active}}</td>
                    <td><a href="{{route('admin::good_category_edit',['id'=>$i->id])}}">Редактировать</a>
                    </td><td><a href="{{route('admin::good_category_delete',['id'=>$i->id])}}">Удалить</a></td>
                </tr>

            @endforeach
            @endforeach

    </table>
    <div style="text-align: center;padding: 10px;">
        @if($page>1)
        <a href="{{route('admin::good_category',['page'=>$page-1,'sortby'=>$sortby,'sortMethod'=>$sortMethod])}}">Предыдущая страница</a>
        @endif
        <span>--{{$page}}--</span>
            @if($count_pages>$page)
                <a href="{{route('admin::good_category',['page'=>$page+1,'sortby'=>$sortby,'sortMethod'=>$sortMethod])}}">Следующая страница</a>
            @endif
    </div>
    @endsection



@section('scripts')
    <script>
            var search=new Vue({
                el:'#search',
                data:{
                    what:'',
                    searchanswer:{
                                    0:{
                                        'name':'name',
                                    }
                    }
                },
                methods:
                    {
                        searchM:function () {
                            if(this.what.length>0){


                            $.ajax({
                                url:'/admin/category/ajax',
                                data:{
                                    'action':'search',
                                    'what':this.what
                                },
                                success:function (data) {
                                    if(data.length>0){
                                        search.searchanswer=data;
                                    }else{
                                        search.searchanswer={0:{
                                            name:'Ничего нет',
                                            id:0
                                        }}
                                    }


                                    $('#search .answer').css('display','block');


                                },
                                error:function (data) {
                                    alert('error');
                                }
                            });
                            }else{
                                alert('ВВЕДИТЕ ДАННЫЕ');
                            }
                        },
                        close:function () {
                            $('#search .answer').css('display','none');
                        }
                    }
            })
    </script>
    @endsection
