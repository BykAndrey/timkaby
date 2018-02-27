@extends('home.base')
@section('header')

    <title>Регистрация - Timka.by</title>
    <meta name="description" content="Регистрация - Timka.by">
@endsection

@section('data')
    <div class="block_good">
        @include('home.parts.elements.breadcrumbls')
        <div class="head">
            <h2>Регистрация</h2>
        </div>
        <div class="user_log">

            <div class="social">
                <span>Регистрируйтесь через социальную сеть:</span>
                <div>
                    <a href="{{route('user::social',['social'=>'vk','action'=>'regist'])}}">
                        <img src="{{URL::asset('static/img/vk.svg')}}" alt="VK" width="50">
                    </a>
                </div>

                <span>Или</span>
            </div>

            @if (count($errors) > 0 )
                <div class="error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::open() !!}

                <table>
                    <tr>
                        <td>
                            {!! Form::label('name','Имя:') !!}
                        </td>
                        <td>
                            {!! Form::text('name',old(''),['min'=>6]) !!}
                        </td>
                    </tr>

                    <tr>
                        <td>{!! Form::label('email','Email:') !!}</td>
                        <td> {!! Form::email('email') !!}</td>
                    </tr>
                    <tr>
                        <td> {!! Form::label('password','Пароль:') !!}</td>
                        <td> {!! Form::password('password') !!}</td>
                    </tr>
                    <tr>
                        <td> {!! Form::label('password_confirmation','Повторите пароль:') !!}</td>
                        <td>  {!! Form::password('password_confirmation') !!}</td>
                    </tr>
                </table>
            <input type="submit" value="Войти">
            {!! Form::close() !!}

        </div>
    </div>
@endsection