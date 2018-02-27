@extends('admin.base')



@section('content')
    <h2>Список поставщиков</h2>
    <ul class="controllers_list">
        <li><a href="{{route('admin::good_provider_create')}}">Добавить поставщика</a></li>
    </ul>
    <table class="list">
        <caption>
            <th>
                ID
            </th>
            <th>
                Имя
            </th>
            <th>

            </th>
            <th></th>
        </caption>
        @foreach($good_provider as $item)
            <tr>
                <td>
                    {{$item->id}}

                </td>
                <td>
                    {{$item->name}}

                </td>
                <td>
                    <a href="{{route('admin::good_provider_edit',['id'=>$item->id])}}"> Редактировать</a>
                </td>
                <td>

                    <a href="{{route('admin::good_provider_delete',['id'=>$item->id])}}">Удалить</a>
                </td>
            </tr>
            @endforeach
    </table>
    @include('home.parts.elements.paginate',[
    'current_page'=>$current_page,
    'max_page'=>$max_page,
    'route'=>'admin::good_provider'])
    @endsection