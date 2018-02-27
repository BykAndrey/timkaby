@extends('admin.base')

@section('content')
    <h2>Список товаров</h2>
    <ul class="controllers_list">
        <li><a href="{{route('admin::option_delivery_create')}}">Создать новый товар</a></li>
    </ul>
    <table class="list">
        <colgroup>
            <col width="1%" span="1" style="background-color:#deffda">
            <col width="10%" span="1" style="background-color:#cedeff">

            <col width="10%" span="1" style="background-color:#deffda">
            <col width="5%" span="1" style="background-color:#cedeff">

            <col width="1%" span="1" style="background-color:#deffda">
            <col width="1%" span="1" style="background-color:#cedeff">
            <col width="1%" span="1" style="background-color:#deffda">
        </colgroup>
        <tr>
            <th>ID</th>

            <th>Name</th>
            <th>Price</th>
            <th>Text price</th>
            <th>Edit</th>
            <th>Delete</th>


        </tr>
        @foreach($items as $item)
            <tr>
                <td>{{$item->id}}</td>

                <td>{{$item->name}}</td>
                <td>{{$item->price}}</td>
                <td>{{$item->text_price}}</td>
                <td><a href="{{route('admin::option_delivery_edit',['id'=>$item->id])}}">Изменить</a>
                </td><td><a href="{{route('admin::option_delivery_delete',['id'=>$item->id])}}">Удалить</a></td>
            </tr>
        @endforeach
    </table>
    @include('home.parts.elements.paginate',[
    'current_page'=>$current_page,
    'max_page'=>$max_page,
    'route'=>'admin::option_delivery'])
@endsection



