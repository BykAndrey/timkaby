<ol>
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ol>
@if(isset($model))
    {!! Form::model($model,array('route'=>array('admin::good_category_edit',$model->id),'method'=>'post','files'=>true)) !!}
@else
    {!!Form::open(['route'=>'admin::good_category_create','methon'=>'post','files'=>true])!!}
@endif
<table class="create">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>

    <tr>
        <td>

            {!! Form::label('id_parent','Категория') !!}
            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            {!! Form::select('id_parent', $category_list,old('id_parent') ) !!}

        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('name','Название') !!}
            <br>
            <p class="help">Длинна должна быть не более 90 симвалов</p>
        </td>
        <td>
            {!! Form::text('name',old('name'),['required'=>'','class'=>'name']) !!}

        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('title','Title') !!}
            <br>
            <p class="help">Длинна должна быть не более 90 симвалов</p>
        </td>
        <td>
            {!! Form::text('title') !!}
        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('url','URL') !!}
        </td>
        <td>
            {!! Form::text('url',old(''),['class'=>'url']) !!}
        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('image','Картинка') !!}
        </td>
        <td>
            @if(isset($model))
                <img src="/{{\App\ItemGroup::getImage($model->image,100,null)}}" alt="{{$model->name}}"><br>
                @endif
            {!! Form::file('image') !!}
        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('description','Описание') !!}
        </td>
        <td>
            {!! Form::textarea('description') !!}
        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('meta_description','Meta Description') !!}
        </td>
        <td>
            {!! Form::textarea('meta_description') !!}
        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('is_active','Активный') !!}
        </td>
        <td>
            {!! Form::checkbox('is_active') !!}
        </td>
    </tr>
    <tr><td>
            <input type="submit" value="Сохранить" class="save">
        </td>
    <td>
    </td></tr>
</table>

{!! Form::close() !!}