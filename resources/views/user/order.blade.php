@extends('home.base')
@section('header')
    <title>Заказ номер {{$order->id}}</title>
    @endsection
@section('tree')
    @include('user.tree')
@endsection

@section('data')
        <div class="block_good">
            @include('home.parts.elements.breadcrumbls')
            <div class="head">
                <h2><a href="">Заказ номер {{$order->id}}.<br> Статус
                    @include('user.state',['status'=>$order->status])

                    </a></h2>
            </div>
            <div class="profile">
                <table class="order_list">
                    <tr>
                        <th>Фото</th>
                        <th>Название</th>
                        <th>Количество</th>
                        <th>Цена (шт)</th>
                        <th>Полная стоимость</th>

                    </tr>
                    @foreach($items as $item)
                        <tr>
                            <td>
                                <img src="/{{$item->image}}" alt="">
                            </td>
                            <td>
                                <a href="{{$item->url}}">{{$item->name}}</a>
                            </td>
                            <td>
                                {{$item->count}}
                            </td>
                            <td>
                                {{$item->price}}&nbsp;р.
                            </td>
                            <td>
                                {{$item->count*$item->price}}&nbsp;р.
                            </td>

                        </tr>
                        @endforeach
                </table>
                <div class="order">
                    <h3 class="head">Общая информация</h3>
                    @if(Auth::user()->id_role==0)
                        <form action="{{route('user::orderState')}}" method="post">
                            @endif
                        {{csrf_field()}}
                    <table>
                        <tr>
                            <td>Имя:</td>
                            <td>{{$order->name}}</td>
                        </tr>
                        <tr>
                            <td>Телефон:</td>
                            <td>{{$order->phone}}</td>
                        </tr>

                        <tr>
                            <td>Адрес доставки:</td>
                            <td>{{$order->adress}}</td>
                        </tr>
                        <tr>
                            <td>Комментарий:</td>
                            <td>{{$order->feature}}</td>
                        </tr>
                        @if(Auth::user()->id_role==0)  <tr>
                            <td>Статус:</td>
                            <td>
                                <input type="hidden" value="{{$order->id}}" name="id">
                                <select name="status" id="" class="common-select common-select_width_full common-select_margin_no">
                                    <option value="-1"
                                            @php $order->status==-1?print ('selected'):null @endphp>
                                        Анулирован
                                    </option>

                                    <option value="0"
                                            @php $order->status==0?print ('selected'):null @endphp>
                                        В обработке
                                    </option>

                                    <option value="1"
                                            @php $order->status==1?print ('selected'):null @endphp>
                                        Доставляется
                                    </option>

                                    <option value="2"
                                            @php $order->status==2?print ('selected'):null @endphp>
                                        Выполнено
                                    </option>

                                </select>
                            </td>
                        </tr>
                    @endif
                        <tr>
                            <td>Стоимость товара:</td>
                            <td>{{sprintf('%.2f',$order->total_price)}}&nbsp;р.</td>
                        </tr>
                        <tr>
                            <td>Стоимость доставки:</td>
                            <td>{{sprintf('%.2f',$order->delivery_price)}}&nbsp;р.</td>
                        </tr>
                        <tr>
                            <td>ИТОГО:</td>
                            <td>{{sprintf('%.2f',$order->total_price+$order->delivery_price)}}&nbsp;р.</td>
                        </tr>
                    </table>
                            @if(Auth::user()->id_role==0)
                                <input type="submit" value="Сохранить" class="common-but common-but_width_full"/>
                    </form>
                        @endif
                </div>
            </div>
        </div>
    @endsection