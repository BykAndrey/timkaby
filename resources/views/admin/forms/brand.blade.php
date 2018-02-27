<ol>
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ol>
@if(isset($model))
    {!! Form::model($model,array('route'=>array('admin::good_brand_edit',$model->id),'method'=>'post')) !!}
@else
    {!!Form::open(['route'=>'admin::good_brand_create','methon'=>'post'])!!}
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
        <td><input type="submit" value="Сохранить"></td>
        <td>

        </td>
    </tr>
</table>