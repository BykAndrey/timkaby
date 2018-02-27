<p class="pay_attention">Данный объект  <b>не является "товаром"</b> как таковым, Данный объект используется для группировки
 <b>ПРЕДЛОЖЕНИЙ</b>(это и есть товар), поля объекта "ТОВАР" служать полями по умолчанию для предложения</p>
<p class="pay_attention">Установив  значение полю   <b>Автоматически создать предложение</b>  дополнительно будет создано  предложение с этими данными</p>
<ol>
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ol>
@if(isset($model))
    {!! Form::model($model,array('route'=>array('admin::good_item_group_edit',$model->id),'method'=>'post','files'=>true)) !!}
@else
    {!!Form::open(['route'=>'admin::good_item_group_create','methon'=>'post','files'=>true])!!}
@endif
<table class="create" id="item_group">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>
    @if(!isset($model))
    <tr>
        <td>
            {!! Form::label('autoOffer','Автоматически создать предложение') !!}
            <br>
            <p class="help">Создаст предложение на основе этих данных <br>
            Использовать если товар <b>одиночный</b> </p>
        </td>
        <td>
            {!! Form::checkbox('autoOffer') !!}

        </td>
    </tr>
    @endif
    <tr>
        <td>
            {!! Form::label('id_good_category','Категория') !!}
            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            {!! Form::select('id_good_category', $category_list,old('') ) !!}

        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('name','Название') !!}
            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            {!! Form::text('name',old(''),['class'=>'name']) !!}

        </td>
    </tr>



    <tr>
        <td>
            {!! Form::label('title','Title') !!}
            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            {!! Form::text('title') !!}

        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('url','URL') !!}
            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            {!! Form::text('url',old(''),['class'=>'url']) !!}

        </td>
    </tr>


    <tr>
        <td>
            {!! Form::label('id_brand',"Бренд") !!}
        </td>
        <td>
            <select name="id_brand" id="id_brand" value="{{old('id_brand')}}">
                @if(isset($model))
                    @foreach($brand as $item)
                        @if($model->id_brand==$item->id)
                            <option selected value="{{$item->id}}">{{$item->name}}</option>
                        @else
                            <option  value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                    @endforeach
                @else
                    @foreach($brand as $item)
                        <option  value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                @endif
            </select>
        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('id_provider',"Поставщик") !!}
        </td>
        <td>

           <select name="id_provider" id="id_provider" v-model="id_provider" v-on:change="get_rate()">
               @if(isset($model))
                    @foreach($provider as $item)
                       @if($model->id_provider==$item->id)
                           <option selected value="{{$item->id}}">{{$item->name}}</option>
                       @else
                           <option  value="{{$item->id}}">{{$item->name}}</option>
                       @endif
                   @endforeach
               @else
                   @foreach($provider as $item)
                       <option  value="{{$item->id}}">{{$item->name}}</option>
                   @endforeach
               @endif
            </select>
        </td>
    </tr>


















    <tr>
        <td>
            {!! Form::label('articul','Артикул') !!}
            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            {!! Form::text('articul') !!}

        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('image','Основная картинка') !!}
            <br>
            <p class="help_must">Эта картинка будет основовной при отображении. <br> Переопределяется в предложении.</p>
        </td>
        <td>
            @if(isset($model))
         <!--       <img src="/{{\App\ItemGroup::getImage($model->image,180,null)}}" alt="" width="150">-->
            @endif
                <input type="hidden" value="" name="ajaxImageField">
                <img src="/static/imagesItem/{{isset($model)?$model->image:null}}"  id="ajaxImage" alt="" width="150">
            {!! Form::file('image') !!}
            <button id="upload">Загрузить</button>

        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('price','Цена') !!}
            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            <span>Доллары (курс @{{ dollar_rate }})</span>:<br>
            <input type="number" v-model="dollar_price" step="0.0001" v-on:keyup="change_dollar"><br>
           <span>Беларусские рубли</span>:
            {!! Form::number('price',old(''),
            array('step'=>'0.01',
            'v-model'=>'BYN_price',
            'v-on:keyup'=>'change_BYN'
            )) !!}


        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('description','Описание') !!}
            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            {!! Form::textarea('description',old(''),array('class'=>'text_redactor')) !!}

        </td>
    </tr>


    <tr>
        <td>
            {!! Form::label('meta_description','Meta Description') !!}<br>
            <p class="help">Данные для header</p>
        </td>
        <td>
            {!! Form::textarea('meta_description') !!}
        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('discount','Скидка') !!}
            <br>
            <p class="help">Если 0 то скидки нет</p>
        </td>
        <td>
            {!! Form::number('discount') !!}

        </td>
    </tr>


    <tr>
        <td>
            {!! Form::label('is_new','Новый') !!}
        </td>
        <td>
            {!! Form::checkbox('is_new') !!}
        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('is_hot','HOT!') !!}
        </td>
        <td>
            {!! Form::checkbox('is_hot') !!}
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
            @if(isset($model))
                <input type="hidden" id="id_good_item_group" value="{{$model->id}}">
            @endif
        </td></tr>
</table>

{!! Form::close() !!}



@section('scripts')
    <script type="text/javascript" src="{{URL::asset('static/js/admin/admin_dollar_rate.js')}}"></script>
    @endsection