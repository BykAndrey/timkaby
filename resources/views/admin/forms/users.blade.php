<ol>
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ol>
@if(isset($model))
    {!! Form::model($model,array('route'=>array('admin::users_edit',$model->id),'method'=>'post')) !!}
@else
    {!!Form::open(['route'=>'admin::users_create','methon'=>'post'])!!}
@endif

<table id='item' class="create">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>
    <tr>
        <td>
            {!! Form::label('name','Имя') !!}
        </td>
        <td>{!! Form::text('name') !!}</td>
    </tr>
    <tr>
        <td>
            {!! Form::label('email','Email') !!}
        </td>
        <td>{!! Form::email('email') !!}</td>
    </tr>
    <tr>
        <td>
            {!! Form::label('password','Пароль') !!}
        </td>
        <td>{!! Form::password('password') !!}</td>
    </tr>
    <tr>
        <td>
            {!! Form::label('phone','phone') !!}
        </td>
        <td>{!! Form::text('phone',old(''),['id'=>"phone"]) !!}</td>
    </tr>

    <tr>
        <td>
            {!! Form::label('adress','Адрес') !!}
        </td>
        <td>{!! Form::text('adress') !!}</td>
    </tr>


    <tr>
        <td>
            {!! Form::label('feature','Дополнительная информация') !!}
        </td>
        <td>{!! Form::text('feature') !!}</td>
    </tr>


    <tr>
        <td>
            {!! Form::label('id_role','Роль') !!}
        </td>
        <td>
            <select name="id_role" >
                @foreach($roles as $item)
                    @if(isset($model->id_role) and $model->id_role==$item->id)
                            <option selected value="{{$item->id}}">{{$item->name}}</option>
                        @else
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif

                    @endforeach
            </select>

        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('is_active','Активный') !!}
        </td>
        <td>{!! Form::checkbox('is_active') !!}</td>
    </tr>
    <tr>
        <td><input type="submit" value="Сохранить"></td>
        <td>

        </td>
    </tr>
</table>