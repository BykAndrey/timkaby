@extends('home.base')

@section('header')

    <title>Вход - Timka.by</title>
    <meta name="description" content="Вход - Timka.by">
    @endsection
@section('data')
    <div class="block_good">
        @include('home.parts.elements.breadcrumbls')
        <div class="head">
            <h2>Вход</h2>
        </div>


        <div class="user_log">
                <div class="social">
                    <span>Авторизуйтесь через социальную сеть:</span>
                    <div>
                        <a href="{{route('user::social',['social'=>'vk','action'=>'login'])}}">

                            <img src="{{URL::asset('static/img/vk.svg')}}" alt="VK" width="50"></a>
                    </div>

                    <span>Или</span>
                </div>

                @if(isset($error))
                <div class="error">
                    <ul>

                            <li>{{ $error }}</li>

                    </ul>
                </div>
                @endif

            {!! Form::open() !!}
                <table>
                    <tr>
                        <td> {!! Form::label('email','Email:') !!}</td>
                        <td>    {!! Form::email('email') !!}</td>
                    </tr>
                    <tr>
                        <td> {!! Form::label('password','Пароль:') !!}</td>
                        <td> {!! Form::password('password') !!}</td>
                    </tr>
                </table>







            <input type="submit" value="Войти">
            {!! Form::close() !!}

        </div>
    </div>
    @endsection