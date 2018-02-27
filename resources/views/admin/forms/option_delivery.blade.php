<ol>
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ol>
@if(isset($model))
    {!! Form::model($model,array('route'=>array('admin::option_delivery_edit',$model->id),'method'=>'post')) !!}
@else
    {!!Form::open(['route'=>'admin::option_delivery_create','methon'=>'post'])!!}
@endif

<table id='item' class="create">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>
    <tr>
        <td>
            {!! Form::label('name','Название') !!}
        </td>
        <td>{!! Form::text('name') !!}</td>
    </tr>


    <tr>
        <td>
            {!! Form::label('price','Цена') !!}
        </td>
        <td>{!! Form::number('price', old(''),['step'=>'0.01']) !!}</td>
    </tr>

    <tr>
        <td>
            {!! Form::label('text_price','Цена текстом') !!}
        </td>
        <td>{!! Form::text('text_price') !!}</td>
    </tr>
    <tr>
        <td>
            {!! Form::label('border_free','Граница ') !!}
            <p class="help">Цена после которой стоимость доставки станет бесплатной</p>
        </td>
        <td>{!! Form::number('border_free') !!}</td>
    </tr>




    <tr>
        <td><input type="submit" value="Сохранить"></td>
        <td>

        </td>
    </tr>
</table>