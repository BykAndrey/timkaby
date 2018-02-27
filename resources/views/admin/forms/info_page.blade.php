
<ol>
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ol>
@if(isset($model))
    {!! Form::model($model,array('route'=>array('admin::info_page_edit',$model->id),'method'=>'post')) !!}
@else
    {!!Form::open(['route'=>'admin::info_page_create','methon'=>'post'])!!}
@endif


<table class="create">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>



    <tr>
        <td>
            {!! Form::label('title','Title') !!}
            <br>
            <p class="help"></p>
        </td>
        <td>
            {!! Form::text('title',old('title')) !!}
        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('name','Название') !!}
            <br>
            <p class="help"></p>
        </td>
        <td>
            {!! Form::text('name',old('name'),['class'=>'name']) !!}
        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('url','URL') !!}
            <br>
            <p class="help"></p>
        </td>
        <td>
            {!! Form::text('url',old('url'),['class'=>'url']) !!}
        </td>
    </tr>



    <tr>
        <td>
            {!! Form::label('content','Контент') !!}
            <br>
            <p class="help"></p>
        </td>
        <td>

            {!! Form::textarea('content',old('content'),array('class'=>'text_redactor')) !!}

        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('meta_description','META_DESCRIPTION') !!}
            <br>
            <p class="help"></p>
        </td>
        <td>

            {!! Form::textarea('meta_description',old('meta_description')) !!}

        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('weight','Вес') !!}
            <p class="help">Позиция в списке</p>
        </td>
        <td>
            {!! Form::number('weight') !!}
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

    <tr>
        <td>
            <input type="submit" value="Сохранить">
        </td>
        <td>

        </td>
    </tr>
</table>




{!! Form::close() !!}
@section('scripts')
    <script type="text/javascript" src="{{URL::asset('static/js/admin/admin_dollar_rate.js')}}"></script>
@endsection