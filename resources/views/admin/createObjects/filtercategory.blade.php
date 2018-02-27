@extends('admin.base')

@section('content')
    <h2>Создание фильтра свойства
        <a href="{{route('admin::good_property_category_edit',['id'=>$property->id])}}"><u><i>{{$property->name}}</i></u></a>
        в категории
        <a href="{{route('admin::good_category_edit',['id'=>$category->id])}}"><u><i>{{$category->name}}</i></u></a> </h2>

    {!! Form::open(['route'=>'admin::good_filter_category_create','method'=>'post']) !!}
    <table class="create">
        <tr><th>Поле</th><th>Значение</th></tr>
        <tr>
            <td>
                {!! Form::label('id_good_category','Категория') !!}
            </td>
            <td>
                {!! Form::select('id_good_category',[]) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('id_good_category','Свойство') !!}
            </td>
            <td>
                {!! Form::select('id_good_category',[]) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('name','Название') !!}
            </td>
            <td>
                {!! Form::text('name') !!}
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Сохранить" class='save'>
            </td>
            <td>

            </td>
        </tr>
    </table>
    {!! Form::close() !!}
    @endsection