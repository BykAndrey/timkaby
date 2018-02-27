@extends('home.base')
@section('header')
    <title>{{$articul->title}} Timka.by</title>
    <meta name="description" content="{{$articul->meta_description}}">
@endsection


@section('data')
    <div class="block_good">
        @include('home.parts.elements.breadcrumbls')
        <div class="head">
            <h2>{{$articul->name}}</h2>
        </div>

        <div class="news">
       {!! $articul->content !!}
        </div>
    </div>
@endsection