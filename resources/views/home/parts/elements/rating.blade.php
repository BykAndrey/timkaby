@php
    $rate=$rating;

@endphp
@for($i=0;$i<5;$i++)
    @if($rate>=1)
        <img src="{{URL::asset('static/img/star-full.svg')}}" width="{{$size}}" alt="{{$rating}}">

        @php
            $rate--;
        @endphp

    @else
        @if($rate>=0.5)
            <img src="{{URL::asset('static/img/star-half.svg')}}" width="{{$size}}" alt="{{$rating}}">
            @php
                $rate=0;
            @endphp
        @else
            <img src="{{URL::asset('static/img/star-empty.svg')}}" width="{{$size}}" alt="{{$rating}}">
            @php
                $rate=0;
            @endphp
        @endif
    @endif
@endfor