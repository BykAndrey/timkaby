@extends('home.base')
@section('header')
    <title>Мои заказы</title>
@endsection
@section('tree')
    @include('user.tree')
@endsection

@section('data')
    <div class="block_good">
        @include('home.parts.elements.breadcrumbls')
        <div class="head">
            <h2>Мои заказы</h2>
        </div>
        <div class="profile" id="profile">
            <table class="order_list">
                <colgroup>
                    <col width="5%">
                    <col width="25%">
                    <col width="25%">
                    <col width="20%">
                </colgroup>
                <tr>
                    <th>
                        Номер заказа
                    </th>
                    <th>
                        Дата
                    </th>
                    <th>Стоимость</th>
                    <th>Количество</th>
                    <th>
                        Статус заказа
                    </th>
                </tr>
                @foreach($my_orders as $order)
                    <tr>
                        <td>
                            {{$order->id}}
                        </td>
                        <td>
                            <a href="{{route('user::myorder',['id'=>$order->id])}}">
                                {{ $order->created_at}}
                            </a>
                        </td>
                        <td>
                            {{$order->total_price}} р.
                        </td>
                        <td>
                            {{$order->count}}
                        </td>
                        <td>
                            @include('user.state',['status'=>$order->status])
                        </td>
                    </tr>
                @endforeach
            </table>

            <div class="paginate">
                @if($current_page!=1)
                <a href="{{route($route,['page'=>$current_page-1])}}">
                    <div class="point"><<</div>
                </a>
                @endif
                @for($i=-1;$i<3;$i++)
                    @if(($current_page+$i)!=0)

                        @if(($max_page>=$current_page+$i))

                            <a href="{{route($route,['page'=>$current_page+$i])}}">
                                <div class="point {{$i==0?print(' selected '):null}}">{{$current_page+$i}}</div>
                            </a>
                        @endif
                    @endif
                @endfor
                @if($max_page>$current_page+1)
                <a href="{{route($route,['page'=>$current_page+1])}}">
                    <div class="point">>></div>
                </a>
                    @endif
            </div>
        </div>

    </div>
@endsection
