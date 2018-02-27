<ol>
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ol>
@if(isset($model))
    {!! Form::model($model,array('route'=>array('admin::news_edit',$model->id),'method'=>'post','files'=>true)) !!}
@else
    {!!Form::open(['route'=>'admin::news_create','methon'=>'post','files'=>true])!!}
@endif

<table id='item' class="create">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>
    <tr>
        <td>
            {!! Form::label('title','Title') !!}
        </td>
        <td>{!! Form::text('title') !!}</td>
    </tr>
    <tr>
        <td>
            {!! Form::label('name','Название') !!}
        </td>
        <td>{!! Form::text('name',old(''),['class'=>'name']) !!}</td>
    </tr>
    <tr>
        <td>
            {!! Form::label('url','URL') !!}
        </td>
        <td>{!! Form::text('url',old('url'),['class'=>'url']) !!}</td>
    </tr>

    <tr>
        <td>
            {!! Form::label('image','Картинка') !!}
        </td>
        <td>
            @if(isset($model))
                <img   src="/{{\App\ItemGroup::getImage($model->image,200,null,$path=\App\Http\Controllers\Admin\BaseAdminController::$pathImageNews)}}"
                width="200">
                @endif

            {!! Form::file('image') !!}</td>
    </tr>

    <tr>
        <td>
            {!! Form::label('content','Контент') !!}
        </td>
        <td>{!! Form::textarea('content',old(''),array('class'=>'text_redactor')) !!}</td>
    </tr>
    <tr>
        <td>
            {!! Form::label('is_active','Активный') !!}
        </td>
        <td>{!! Form::checkbox('is_active') !!}</td>
    </tr>

    <tr>
        <td>
            {!! Form::label('is_open_admin','Видит только администратор') !!}
        </td>
        <td>{!! Form::checkbox('is_open_admin') !!}</td>
    </tr>

    <tr>
        <td>
            {!! Form::label('meta_description','meta_description') !!}
        </td>
        <td>{!! Form::textarea('meta_description') !!}</td>
    </tr>



    <tr>
        <td><input type="submit" value="Сохранить"></td>
        <td>

        </td>
    </tr>
</table>