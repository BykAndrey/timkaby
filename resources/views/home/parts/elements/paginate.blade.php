@php


/*['page'=>$current_page-1]*/
@endphp


<div class="paginate">

    @if($current_page!=1)
        <a href="{{route($route,array_merge(['page'=>$current_page-1],isset($routeParams)?$routeParams:[]))}}">
            <div class="point"><<</div>
        </a>
    @endif
    @for($i=-2;$i<3;$i++)
        @if(($current_page+$i)>0)

            @if(($max_page>=$current_page+$i))

                <a href="{{route($route,array_merge(['page'=>$current_page+$i],isset($routeParams)?$routeParams:[]))}}">
                    <div class="point {{$i==0?print(' selected '):null}}">{{$current_page+$i}}</div>
                </a>
            @endif
        @endif
    @endfor
    @if($max_page>$current_page+1)
        <a href="{{route($route,array_merge(['page'=>$current_page+1],isset($routeParams)?$routeParams:[]))}}">
            <div class="point">>></div>
        </a>
    @endif
</div>