<ol>
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ol>
@if(isset($model))

    {!! Form::model($model,array('route'=>array('admin::good_item_edit',$model->id),'method'=>'post','files'=>true)) !!}
@else
    {!!Form::open(['route'=>'admin::good_item_create','methon'=>'post','files'=>true])!!}
@endif
@if(isset($item_group))
    <input type="hidden" id="id_good_item_group" value="{{$item_group->id}}" }>
@endif
<table id='item' class="create">
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
    <tr><th>Поле</th> <th>Значение</th></tr>
     <!--Form::hidden('id_good_item_group')-->

    @if(isset($good_item_group_list))
       <tr>
           <td>
               <label for="">Товар</label>
           </td>

           <td>{{old('id_good_item_group')}}
               <select id="id_good_item_group" name="id_good_item_group" v-on:change="ch()">
                   @foreach($good_item_group_list as $item)
                       @if(isset($model))
                           @if($item->id==$model->id_good_item_group)
                               <option selected value="{{$item->id}}">{{$item->name}}</option>
                           @else
                               <option value="{{$item->id}}">{{$item->name}}</option>
                           @endif
                           @else
                           @if(isset($item_group))
                               @if($item->id==$item_group->id)
                                   <option selected value="{{$item->id}}">{{$item->name}}</option>
                               @else
                                   <option value="{{$item->id}}">{{$item->name}}</option>
                               @endif
                               @else
                                   @if(old('id_good_item_group')!=null)
                                       <option selected value="{{$item->id}}">{{$item->name}}</option>
                                   @else
                                       <option value="{{$item->id}}">{{$item->name}}</option>
                                   @endif
                               @endif
                       @endif
                   @endforeach
               </select>
           </td>
       </tr>
    @endif
    <tr>
        <td>
            {!! Form::label('name','Название') !!}

            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            <p> @{{ itemgroup.name }}<br>
            {!! Form::text('name',old(''),['class'=>'name']) !!}
                <p v-on:click="importField(itemgroup.name,'#name')"> Импорт</p>
        </td>
    </tr>



    <tr>
        <td>
            {!! Form::label('title','Title') !!}
            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            <p> @{{ itemgroup.title }}<br>
            {!! Form::text('title') !!}
            <p v-on:click="importField(itemgroup.title,'#title')"> Импорт</p>
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
            <p v-on:click="importProvider(itemgroup.id_provider)"> Импорт</p>
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
           <!-- @if(isset($model))
            <img src="/{{\App\ItemGroup::getImage($model->image,180,null)}}" alt="m" width="150">
                @else
                <img src="{{URL::asset(old('imageImport'))}}" alt="o" width="150">
            @endif-->

            <p>
                <b onclick="$('#image').val('');">Очистить: </b>
                {!! Form::file('image') !!}
                <button v-on:click="upload($event)">Загрузить</button>
            </p>

             <p>
                 <input type="hidden" name="imageImport" v-bind:value="image" value="{{URL::asset(old('imageImport'))}}" >
                 <img v-bind:src="'/static/imagesItem/'+image" alt="" id="imageImport" width="100" >
                 <br>
                 <span v-on:click="image='/'+itemgroup.image"> Импорт</span>
                 <span onclick="$('#imageImport').attr('src','');"> Отменить</span>
             </p>

        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('price','Цена') !!}
            <br>
            <p class="help">Базовая категория - это основная категория</p>
        </td>
        <td>
            <p >@{{ itemgroup.price }}</p>

            <span>Доллары (курс @{{ dollar_rate }})</span>:<br>
            <input type="number" v-model="dollar_price" step="0.0001" v-on:keyup="change_dollar"><br>
            <span>Беларусские рубли</span>:
            {!! Form::number('price',old(''),
            array('step'=>'0.01',
            'v-model'=>'BYN_price',
            'v-on:keyup'=>'change_BYN'
            )) !!}


            <p v-on:click="importField(itemgroup.price,'#price')"> Импорт</p>

        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('description','Описание') !!}
            <br>
            <p class="help">Базовая категория - это основная категория <br>
            ДЛЯ ИНПОРТА НУЖНО ОТКРЫТЬ КОД И НАЖАТЬ <b>Импорт</b>, поставить курсор в конец текста и нажать пробел и перейти обратно в редактор </p>
        </td>
        <td>
            <p v-html="itemgroup.description"></p>
            {!! Form::textarea('description',old(''),array('class'=>'text_redactor')) !!}
            <p v-on:click="jqte()"> Импорт</p>
        </td>
    </tr>


    <tr>
        <td>
            {!! Form::label('meta_description','Meta Description') !!}<br>
            <p class="help">Данные для header</p>
        </td>
        <td>
            <p>@{{ itemgroup.meta_description }}</p>
            {!! Form::textarea('meta_description') !!}
            <p v-on:click="importField(itemgroup.meta_description,'#meta_description')"> Импорт</p>
        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('discount','Скидка') !!}
            <br>
            <p class="help">Если 0 то скидки нет</p>
        </td>
        <td>
            <p>@{{ itemgroup.discount }}</p>
            {!! Form::number('discount') !!}
            <p v-on:click="importField(itemgroup.discount,'#discount')"> Импорт</p>
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
                <input type="hidden" id="id_good_item" value="{{$model->id}}">
            @endif
        </td>
    </tr>

</table>

{!! Form::close() !!}

<script src="{{URL::asset('/static/js/admin/admin_item_group.js')}}"></script>
<script>
    //{{isset($model)?$model->image:null}}
    var imageq='{{old('imageImport')?old('imageImport'):"null"}}';
        if(imageq=="null"){
            imageq='{{isset($model)?$model->image:null}}';
        }
   var item=null;
        if($('#id_good_item_group').val()!=null){
            $.ajax({
                url:'/admin/itemgroup/getobject/'+$('#id_good_item_group').val(),

                dataType:'json',
                async:false,
                success:function (data) {
                    console.log(data);
                    item=data;
                },
                error:function (data) {
                    console.log(data);
                }
            });
            function change() {
                $.ajax({
                    url:'/admin/itemgroup/getobject/'+$('#id_good_item_group').val(),

                    dataType:'json',
                    async:false,
                    success:function (data) {
                        console.log(data);
                        item.itemgroup=data;

                    },
                    error:function (data) {
                        console.log(data);
                    }
                });
            }

            var item=new Vue({
                el:'#item',
                data:{
                    itemgroup:item,
                    image:imageq,
                    id_provider:$('#id_provider').val(),
                    dollar_rate:1,
                    dollar_price:0,
                    BYN_price:$('#price').val()
                },
                created:function () {
                    this.get_rate();
                },
                methods:{
                    importProvider:function (id) {
                            this. id_provider=id;
                    },
                    importField:function(from,to,attr='val'){

                        if(attr=='val'){
                            $(to).val(from);
                        }else{
                            $(to).attr('value',from);
                            $(to).attr(attr,from);
                        }


                    },
                    jqte:function () {
                        $('.jqte_editor').html(this.itemgroup.description);
                    }
                    ,
                    ch:function () {
                        change();

                    },
                    get_rate:function () {
                        $.ajax({
                            url:'/admin/itemgroup/ajax',
                            data:{
                                'id_provider':item.id_provider,
                                'action':'get_dollar_rate'
                            },
                            method:'get',
                            success:function (data) {
                                item.dollar_rate=data;
                                item.dollar_price=(item.BYN_price/data).toFixed(4);
                            }
                        })
                        console.log(this.id_provider);
                    },
                    change_BYN:function () {
                        item.dollar_price=(item.BYN_price/ item.dollar_rate).toFixed(4);
                    },
                    change_dollar:function () {
                        item.BYN_price=(item.dollar_price*item.dollar_rate).toFixed(2);
                    },
                    upload:function(el){
                        el.preventDefault();
                        var token=$('input[name="_token"]').val();
                        console.log(token);
                        var image=$('#image')[0].files[0];
                        if(image!=null){
                            var name=(uploadImage(token,image));//"1518506290.jpg";//
                            //$('#ajaxImage').attr('src',"/static/imagesItem/"+name);
                            this.image=name;
                        }

                    }
                }
            });
        }

    //get_object();
</script>
