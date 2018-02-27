@extends('home.base')
@section('header')
    <title>Новости Timka.by</title>
    <meta name="description" content="Новости интернет-магазина Timka.by">
    @endsection


@section('data')
    <div class="block_good">
        @include('home.parts.elements.breadcrumbls')
        <div class="head">
            <h2>Новости</h2>
        </div>

        <div class="news">
            @php
            $counter=1;
            @endphp
            @foreach($news as $item)
                @if($counter==2 or $counter==3)
                    @php
                        $imgLoad=300;
                    @endphp
                    <div class="articul middle">
                    @else
                            @php
                                $imgLoad=510;
                            @endphp
                            <div class="articul">
                    @endif
                <a href="{{route('home::articul',['url'=>$item->url])}}">
                    <div class="back"
                         style="background-image: url('/{{\App\ItemGroup::getImage($item->image,$imgLoad,null,\App\Http\Controllers\Admin\BaseAdminController::$pathImageNews)}}'">
                        <div class="name">
                            <div class="date">{{(new DateTime($item->created_at))->format('d-m-Y')}}</div>
                            <p> {{$item->name}}</p>

                        </div>
                    </div>
                </a>

            </div>
                @php

                    $counter==3?$counter=1:$counter++;


                @endphp
                @endforeach
        </div>
                @include('home.parts.elements.paginate',[
                'max_page'=>$max_page,
                'current_page'=>$current_page,
                'route'=>'home::all_news'])
    </div>
    @endsection