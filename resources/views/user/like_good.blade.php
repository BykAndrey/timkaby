@extends('home.base')
@section('header')
    <title>Понравившиеся товары</title>
@endsection
@section('tree')
    @include('user.tree')
@endsection

@section('data')
    <div class="block_good">
        @include('home.parts.elements.breadcrumbls')
        <div class="head">
            <h2>Избранное</h2>

        </div>
        <div class="profile">
            <div class="help">При новой скидке Вы получите уведомление на указанный еmail.</div>
            @if(count($listLikeGoods)==0)
                <div class="help help-error">У Вас нет понравившихся товаров.</div>
                @endif
            <table class="order_list">
                <tr>
                    <th>Картинка</th>
                    <th>Название</th>
                    <th>Стоимость</th>
                    <th>Удалить</th>
                </tr>
                @foreach($listLikeGoods as $item)
                    <tr>
                        <td><img src="/{{$item->image}}" alt="{{$item->name}}"></td>
                        <td><a href="{{$item->url}}">{{$item->name}}</a>
                            <br>

                            @include('home.parts.elements.rating',['rating'=>$item->rating,'size'=>10])
                        </td>
                        <td>{{sprintf('%.2f',$item->price)}}&nbsp;р.
                            @if($item->discount>0)
                                    <br>
                                    <span>Скидка: -{{$item->discount}}%</span>
                                @endif
                        </td>
                        <td>

                                <div class="common-but" onclick="removeFromFavorite({{$item->id}},this);">Удалить</div>

                        </td>
                    </tr>
                    @endforeach
            </table>
            @include('home.parts.elements.paginate',['route'=>$paginate_route,
            'current_page'=>$current_page,
            'max_page'=>$max_page])
        </div>
    </div>
    @endsection