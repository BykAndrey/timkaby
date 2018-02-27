@extends('home.base')

@section('header')
    <title>{{$title_main_page}}</title>
    <meta name="description" content="{{$seo_description_main_page}}"/>
@endsection
@section('data')
@if(count($slides)>0)
        <div class="slider-home">
            <div class="display">
                @php
                    $iter=0;
                @endphp
                @foreach($slides as $slide)
                    <div class="slide @if($iter==0) active @endif" style="background-image: url('/{{\App\ItemGroup::getImage($slide->image,830,null,\App\Http\Controllers\Admin\BaseAdminController::$pathslideImage)}}')">
                         <div class="info">
                             <div class="name">
                                 {!! $slide->name!!}


                                 @if($slide->discount>0)
                                        <span class="discount">-{{$slide->discount}}%</span>
                                     @endif
                             </div>
                             <div class="description">
                                 {!!  $slide->description!!}
                             </div>
                             <div class="controlls">
                                 <div class="lookmore">
                                     <a href="{{$slide->url}}">Подробнее</a>
                                 </div>
                             </div>
                         </div>
                    </div>
                    @php
                        $iter=$iter+1;
                    @endphp
                @endforeach
            </div>
            @if(count($slides)>1)
            <div class="marks">
                @php
                    $iter=0;
                @endphp
                @foreach($slides as $slide)
                    <div class="mark @if($iter==0) active @endif"></div>
                    @php
                        $iter=$iter+1;
                    @endphp
                    @endforeach
            </div>
            <div class="controlls">

                <div class="left but">
                    <img src="{{URL::asset('static/img/left.svg')}}" alt="Left">
                </div>

                <div class="right but">
                    <img src="{{URL::asset('static/img/right.svg')}}" alt="Right">
                </div>

            </div>
                @endif
        </div>
@endif
        @foreach($list_block as $block)
            @include('home.parts.list.home.block_good',['block'=>$block])
        @endforeach
        <div class="">
            {!! $text_main_page !!}
        </div>

    @endsection



@section('scripts')
    <script src="{{URL::asset('/static/js/homepageslider.js')}}">

    </script>
    @endsection