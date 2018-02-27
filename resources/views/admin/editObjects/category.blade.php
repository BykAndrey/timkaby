@extends('admin.base')
@section('scripts')

    <!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
    <script type="text/javascript">
        loadLitProperty();
    </script>
    @endsection
@section('content')

    <h2>Редактирование категории</h2>
    <div id="tabs">
        <ul>
            <li><a href="#object">Категория</a></li>
            @if(isset($model))
                @if($model->id_parent>0)
            <li><a href="#property">Свойства</a></li>
                @endif
                @endif
        </ul>
        <div id="object">
            <h3>Категория</h3>
            @include('admin.forms.category')
        </div>
        @if(isset($model))
            @if($model->id_parent>0)
        <div id="property">
            <h3>Дополнительные свойства для товара</h3>
            @include('admin.listObjects.property_category')
        </div>
            @endif
        @endif
    </div>

@endsection