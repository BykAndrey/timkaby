

@if(count($widget_news)>0)
<div class="widget-news">
    <h2 class="head">
        <a href="{{route('home::all_news')}}">
            Новости
        </a>
    </h2>

    <div class="display">
        @php
        $i=0;
        @endphp
        @foreach($widget_news as $new)
            <div class="slide"
                 style="background-image:url(/{{\App\ItemGroup::getImage($new->image,250,null,\App\Http\Controllers\Admin\BaseAdminController::$pathImageNews)}}); opacity: 0;">
                    <p><a href="{{route('home::articul',['url'=>$new->url])}}">{{$new->name}}</a></p>
            </div>
            @endforeach
    </div>
    <div class="controls">
        <div class="marks">
            @foreach($widget_news as $new)
                <div class="mark"></div>
                @endforeach
        </div>
    </div>

</div>

@endif