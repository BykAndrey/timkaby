@extends('home.base')

@section('header')
    <title>{{$page->title}} -Timka.by </title>
    <meta name="description" content="{{$page->meta_description}}"/>
@endsection

@section('data')

    <div class="block_good">
        @include('home.parts.elements.breadcrumbls')
        <div class="head">
            <h2><a href="">{{$page->name}}</a></h2>
        </div>

        <div>{!! $page->content !!}</div>
    </div>
    @endsection
