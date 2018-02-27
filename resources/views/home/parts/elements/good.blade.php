<div class="good middle">
    @if($item->discount>0)
        <div class="flag_discount">
            <img src="{{URL::asset('/static/img/red_flag.svg')}}" width="90" alt="RED FLAG">
            <p>-{{$item->discount}}%</p>
        </div>
    @endif
    <a href="{{route('home::card',['caturl'=>$item->caturl,'url'=>$item->url])}}">

        <div class="image" style="background-image:url('{{URL::asset(\App\ItemGroup::getImage($item->image,200,null))}}')">

        </div>
    </a>
    <div class="info">
        <h5><a href="{{route('home::card',['caturl'=>$item->caturl,'url'=>$item->url])}}">{{$item->name}}</a></h5>
        <p>{{sprintf('%.2f',$item->price)}} р.
            @if($item->discount>0)
                <strike>{{sprintf('%.2f',$item->old_price)}}&nbsp;р.</strike>


               <!-- <span class="discount">-{{$item->discount}}%</span>-->
        @endif</p>
       <div title="Рейтинг товара">

           @include('home.parts.elements.rating',['rating'=>$item->rating,'size'=>'14'])
        </div>

        <div class="cntrls">


        <div class="common-but common-but-clear">
            <div class="common-but-left common-but " onclick="addToCart({{$item->id}})">В корзину</div>
            <div class="common-but-right common-but " onclick="addToFavorite({{$item->id}})" title="Добавить в избранное">
                <img src="{{URL::asset('static/img/like.svg')}}" alt="Нравится" width="20">
            </div>
        </div>
        </div>
    </div>
</div>