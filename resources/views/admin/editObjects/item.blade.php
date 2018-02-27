@extends('admin.base')

@section('content')
    <h2>Редактирование предложение</h2>
    <p> <a target="_self" href="{{route('admin::good_item_create',['id_good_item_group'=>$model->id_good_item_group])}}">
            Создать предложение в этом товаре
        </a></p>

    <br>
    <div id="tabs">
        <ul>
            <li><a href="#object">Предложение</a></li>
            <li><a href="#property">Свойства</a></li>
            <li>

            </li>
        </ul>
        <div id="object">
            <h3> Основные свойства </h3>
            @include('admin.forms.item')
        </div>
        <div id="property">
            <h3> Дополнительные свойства </h3>
            @include('admin.listObjects.property_item')
        </div>
    </div>


    @endsection