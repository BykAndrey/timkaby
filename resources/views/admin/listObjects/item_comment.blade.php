@extends('admin.base')



@section('content')
    <h2>Коментарии</h2>
    <ul class="controllers_list">

    </ul>
    <table class="list">
        <caption>
            <th>
                ID
            </th>
            <th>
                Инфо
            </th>
            <th>
                Оценка
            </th>
            <th>
                Активный
            </th>

            <th>
                Новый
            </th>

            <th>

            </th>
            <th></th>
        </caption>
        @foreach($good_brand as $item)
            <tr>
                <td>
                    {{$item->id}}

                </td>
                <td>
                    <p> <b>Пользователь:</b> {{$item->user_name}}</p>
                    <p> <b>Товар:</b> <a href="{{route('admin::good_item_edit',['id'=>$item->good_id])}}">{{$item->good_name}}</a></p>
                    <p> <b>Коментарий:</b> {{$item->comment}}</p>

                </td>
                <td>
                    {{$item->rating}}

                </td>
                <td>
                    @if($item->is_active==0)
                            <div class="but but_red"  onclick="set_active({{$item->id}},this)">

                            </div>
                        @else
                            <div class="but but_green" onclick="set_active({{$item->id}},this)">

                            </div>
                        @endif


                </td>
                <td>
                    @if($item->is_new==0)
                        <div class="but but_red" onclick="set_new({{$item->id}},this)">

                        </div>
                    @else
                        <div class="but but_green" onclick="set_new({{$item->id}},this)">

                        </div>
                    @endif

                </td>
                <td>
                    <a href="{{route('admin::good_brand_edit',['id'=>$item->id])}}"> Редактировать</a>
                </td>
                <td>

                    <a href="{{route('admin::good_brand_delete',['id'=>$item->id])}}">Удалить</a>
                </td>
            </tr>
        @endforeach
    </table>
    @include('home.parts.elements.paginate',[
   'current_page'=>$current_page,
   'max_page'=>$max_page,
   'route'=>'admin::item_comment'])
@endsection

@section('scripts')

    <script>set_active
        function set_new(id,e) {

            $.ajax({
                url:'/admin/item_comment/ajax',
                data:{
                    'action':'set_new',
                    'id':id
                },
                success:function(data){
                    if(data==1){
                        $(e).removeClass('but_red');
                        $(e).addClass('but_green');
                    }  else{
                        $(e).removeClass('but_green');
                        $(e).addClass('but_red');

                    }
                    console.log(data);
                }
            })
        }
        function set_active(id,e) {
            $.ajax({
                url:'/admin/item_comment/ajax',
                data:{
                    'action':'set_active',
                    'id':id
                },
                success:function(data){
                    if(data==1){
                        $(e).removeClass('but_red');
                        $(e).addClass('but_green');
                    }  else{
                        $(e).removeClass('but_green');
                        $(e).addClass('but_red');

                    }
                    console.log(data);
                }
            })
        }
    </script>
    @endsection