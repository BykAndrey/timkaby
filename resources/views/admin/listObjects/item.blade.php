
@extends('admin.base')

@section('content')
    <h2>Список товаров</h2>
    <ul class="controllers_list">
        <li><a href="{{route('admin::good_item_create')}}">Создать новый товар</a></li>
    </ul>
    <table class="list">
        <colgroup>
            <col width="1%" span="1" style="background-color:#deffda">
            <col width="10%" span="1" style="background-color:#cedeff">

            <col width="10%" span="1" style="background-color:#deffda">
            <col width="5%" span="1" style="background-color:#cedeff">

            <col width="1%" span="1" style="background-color:#deffda">
            <col width="1%" span="1" style="background-color:#cedeff">
            <col width="1%" span="1" style="background-color:#cedeff">
            <col width="1%" span="1" style="background-color:#cedeff">
            <col width="1%" span="1" style="background-color:#cedeff">
            <col width="1%" span="1" style="background-color:#deffda">
        </colgroup>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>

            <th>Price</th>
            <th>Discount
                <a href="{{route('admin::good_item',['page'=>1,
                'sortby'=>'discount-desc'
                ])}}">убв</a>
                <a href="{{route('admin::good_item',['page'=>1,
                'sortby'=>'discount-asc'
                ])}}">возр</a>
            </th>
            <th>New</th>
            <th>Active
                <a href="{{route('admin::good_item',['page'=>1,
                'sortby'=>'is-active-desc'
                ])}}">убв</a>
                <a href="{{route('admin::good_item',['page'=>1,
                'sortby'=>'is-active-asc'
                ])}}">возр</a>
            
            
            </th>

            <th>
                Date
                <a href="{{route('admin::good_item',['page'=>1,
                'sortby'=>'created-at-desc'
                ])}}">убв</a>
                <a href="{{route('admin::good_item',['page'=>1,
                'sortby'=>'created-at-asc'
                ])}}">возр</a>
            </th>
            <th>Edit</th>
            <th>Delete</th>


        </tr>
        @foreach($items as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>
                    <img src="{{URL::asset($item->image)}}" alt="image" width="150">
                </td>
                <td>{{$item->name}}<br>
                <i>{{$item->item_group}}</i></td>

                <td>
                    <input type="text" onblur="setItemPrice({{$item->id}},this)" value="{{$item->price}}">
                </td>
                <td>
                    <input type="text" onblur="setItemDiscount({{$item->id}},this)" value="{{$item->discount}}">

                </td>

                <td>
                    @if($item->is_new==1)
                        <div class="but but_green" onclick="setItemNew({{$item->id}},this)">

                        </div>
                    @else
                        <div class="but but_red" onclick="setItemNew({{$item->id}},this)">
                        </div>
                    @endif
                </td>


                <td>
                    @if($item->is_active==1)
                        <div class="but but_green" onclick="setItemActive({{$item->id}},this)">

                        </div>
                    @else
                        <div class="but but_red" onclick="setItemActive({{$item->id}},this)">
                        </div>
                    @endif
                </td>

                <td>{{$item->created_at}}</td>
                <td>
                    <a href="{{route('admin::good_item_edit',['id'=>$item->id])}}">Изменить</a>
                </td>
                <td><a href="{{route('admin::good_item_delete',['id'=>$item->id])}}">Удалить</a></td>
            </tr>
        @endforeach
    </table>
    @include('home.parts.elements.paginate',[
    'current_page'=>$current_page,
    'max_page'=>$max_page,
    'route'=>'admin::good_item',
    'routeParams'=>[
        'sortby'=>$sortby
    ]
    ])
@endsection

@section('scripts')
    <script src="{{URL::asset('/static/js/admin/admin_item.js')}}"></script>
    @endsection