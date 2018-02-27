@extends('admin.base')
@section('content')
    <h2>Информационные страницы</h2>
    <ul class="controllers_list">
        <li><a href="{{route('admin::info_page_create')}}">Добавить страницу</a></li>
    </ul>
    <table>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Название
                </th>
                <th>
                    Дата создания
                </th>
                <th>
                    Активный
                </th>
                <th>
                    Редактировать
                </th>
                <th>
                    Удалить
                </th>
            </tr>



        @foreach($items as $item)
            <tr>
                <td>
                    {{$item->id}}
                </td>
                <td>
                    {{$item->name}}
                </td>
                <td>
                    {{$item->created_at}}
                </td>
                <td>

                    {{$item->is_active}}
                </td>
                <td>
                    <a href="{{route('admin::info_page_edit',['id'=>$item->id])}}">Редактировать</a>
                </td>
                <td>
                    <a href="{{route('admin::info_page_delete',['id'=>$item->id])}}">Удалить</a>
                </td>
            </tr>
            @endforeach
    </table>
    @include('home.parts.elements.paginate',[
   'current_page'=>$current_page,
   'max_page'=>$max_page,
   'route'=>'admin::info_page'])
    @endsection