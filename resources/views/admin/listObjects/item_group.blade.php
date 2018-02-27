@extends('admin.base')

@section('content')
    <h2>Список товаров</h2>

        <ul class="controllers_list">
            <li>
                <a href="{{route('admin::good_item_group_create')}}">Добавить товар</a>
            </li>
            <li id="filters">

                <span>Категория: </span>
                <select name="" id="category" v-model="category">
                    <option value="0">ВСЕ</option>
                    @foreach($categories as $key=>$item)
                        <optgroup label="{{$key}}">
                            @foreach($item as $k=>$i)
                                @if($category==$k)
                                    <option selected="selected" value="{{$k}}">{{$i}}</option>
                                @else
                                    <option  value="{{$k}}">{{$i}}</option>
                                    @endif
                                @endforeach
                        </optgroup>
                    @endforeach
                </select>





               <span>Поставщик: </span>
                <select name="" id="provider" v-model="provider">
                    <option value="0">ВСЕ</option>
                    @foreach($providers as $item)
                       @if($item->id==$provider and isset($provider))
                            <option selected="selected" value="{{$item->id}}">{{$item->name}}</option>
                        @else
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                        @endforeach
                </select>
              <span>Бренд: </span>
                <select name="" id="brand" v-model="brand">
                    <option value="0">ВСЕ</option>
                    @foreach($brands as $item)
                        @if($item->id==$brand and isset($brand))
                            <option selected="selected" value="{{$item->id}}">{{$item->name}}</option>
                        @else
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                    @endforeach
                </select>
                <button v-on:click="sort()">Сортировать</button>
            </li>
        </ul>


    <table class="list">
        <colgroup>
            <col width="1%" span="1" style="background-color:#deffda">
            <col width="10%" span="1" style="background-color:#cedeff">

            <col width="10%" span="1" style="background-color:#deffda">
            <col width="5%" span="1" style="background-color:#cedeff">

            <col width="1%" span="1" style="background-color:#deffda">
            <col width="1%" span="1" style="background-color:#deffda">
            <col width="1%" span="1" style="background-color:#cedeff">
            <col width="1%" span="1" style="background-color:#deffda">
        </colgroup>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Parent name</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Edit</th>
            <th>Delete</th>


        </tr>
        @foreach($list_item_group as $item)


                <tr>
                    <td>{{$item->id}}</td>
                    <td>
                        <img src="{{URL::asset(\App\ItemGroup::getImage($item->image,100,null))}}" alt="image" width="150">
                    </td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->category_name}}</td>

                    <td><input type="text" value="{{$item->price}}" onblur="setPrice_item_group({{$item->id}},this)"></td>

                    <td><input type="text" value="{{$item->discount}}" onblur="setDiscount_item_group({{$item->id}},this)"></td>

                    <td><a
                           href="{{route('admin::good_item_group_edit',['id'=>$item->id])}}">Изменить</a>
                    </td><td><a href="{{route('admin::good_item_group_delete',['id'=>$item->id])}}">Удалить</a></td>
                </tr>
        @endforeach
    </table>
    <!-- onclick="window.open('{{route('admin::good_item_group_edit',['id'=>$item->id])}}','TOVAR','width=700,menubar=no,location=no,resizable=yes,scrollbars=yes,status=no');return false;"-->
    <div style="text-align: center;padding: 10px;">
        @if($page>1)
            <a href="{{route('admin::good_item_group',[
            'page'=>$page-1,
            'sortby'=>$sortby,
            'sortMethod'=>$sortMethod,
             'provider'=>$provider,
             'brand'=>$brand,
             'category'=>$category
             ])}}">Предыдущая страница</a>
        @endif
        <span>--{{$page}}--</span>
        @if($count_pages>$page)
            <a href="{{route('admin::good_item_group',[
            'page'=>$page+1,
            'sortby'=>$sortby,
            'sortMethod'=>$sortMethod,
            'provider'=>$provider,
            'brand'=>$brand,
            'category'=>$category
            ])}}">Следующая страница</a>
        @endif
    </div>
    @endsection


@section('scripts')

    <script src="{{URL::asset('/static/js/admin/admin_item_group.js')}}"></script>
    <script>
        var sortItemGroup=new Vue({
            el:'#filters',
            data:{
                provider:$('#provider').val(),
                brand:$('#brand').val(),
                category:$('#category').val(),
            },
            methods:{
                sort:function () {
                  window.location='/admin/itemgroup?provider='+this.provider+'&brand='+this.brand+'&category='+this.category;
                }
            }
        });
    </script>
    @endsection