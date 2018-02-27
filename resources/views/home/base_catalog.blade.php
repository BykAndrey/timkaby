@extends('home.base')

@section('header')
    <title>{{$title}}</title>
    <meta name="description" content="{{$description}}"/>
@endsection




@section('data')

    <div itemscope itemtype="http://schema.org/Product" class="block_good" id="catalog">
        @include('home.parts.elements.breadcrumbls')
        <div class="head">
            <h2 itemprop="name">{{$name}}</h2>
            <div  itemtype="http://schema.org/AggregateOffer" itemscope itemprop="offers">
                <meta content="{{$count_goods}}" itemprop="offerCount">
                <meta content="{{$max_price}}" itemprop="highPrice">
                <meta content="{{$min_price}}" itemprop="lowPrice">
                <meta content="BYN" itemprop="priceCurrency">
            </div>
        </div>
        <div class="sorting">
            <div>
                <span>Сортировать по:</span>
                <select name="sortby" id="sortby" onchange="window.location.href='{{route('home::base_catalog',[
                'page'=>1,
                'size'=>$good_size])}}&sorting='+this.value">
                    <option {{$good_sorting==1?'selected':null}} value="1">Цена (убывание)</option>
                    <option {{$good_sorting==2?'selected':null}} value="2">Цена (возрастание)</option>
                    <option {{$good_sorting==3?'selected':null}} value="3">Популярность (убывание)</option>
                    <option {{$good_sorting==4?'selected':null}} value="4">Популярность (возрастание)</option>
                </select>
            </div>


            <div>
                <span>Показывать по:</span>
                <select name="size" id="size" onchange="window.location.href='{{route('home::base_catalog',[
                'page'=>1,
                'sorting'=>$good_sorting])}}&size='+this.value">
                    <option {{$good_size==20?'selected':null}} value="20">20</option>
                    <option {{$good_size==40?'selected':null}} value="40">40</option>
                    <option {{$good_size==60?'selected':null}} value="60">60</option>
                </select>
            </div>

        </div>
        <div class="list_good">

            @foreach($list_goods as $item)

                @include('home.parts.elements.good',['item'=>$item])

            @endforeach

        </div>
    @include('home.parts.elements.paginate',['current_page'=>$current_page,
    'max_page'=>$count_pages,
    'route'=>'home::base_catalog',
    'routeParams'=>[
    'size'=>$good_size,
    'sorting'=>$good_sorting,
    'is_new'=>$is_new

    ]])
    </div>
    @endsection


@section('scripts')
    <script>
   /*     var base_catalog=new Vue({
            el
        })*/
    </script>
    @endsection