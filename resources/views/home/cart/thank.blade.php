@extends('home.base')
@section('header')
    @endsection
@section('data')
    <div class="block_good">
        <div class="head"></div>
        <div>
            <h1>Спасибо за покупку</h1>
            <p class="help">Наш специалист свяжется с вами в ближайшее время</p>
            <a href="{{route('home')}}">
                <div class="common-but">
                    На главную
                </div>
            </a>
        </div>
    </div>
    @endsection