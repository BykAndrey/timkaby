@extends('home.base')


@section('data')

    <div class="block_good">
        <div class="head">
            <h2>Пароль изменен</h2>
        </div>
        <div class="profile">
            <h2>Пароль успешно изменен</h2>
            <a href="{{route('user::profile')}}"> <span class="common-but">К профилю</span></a>
        </div>
    </div>
    @endsection