@extends('home.base')


@section('header')
    <title>Смена пароля пользователя - Timka.by</title>
    @endsection

@section('data')
    <div class="block_good">
        @include('home.parts.elements.breadcrumbls')
        <div class="head">
            <h2>Смена пароля пользователя</h2>
        </div>
        <div class="user_log">
            @if (count($errors) > 0 )
                <div class="error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::open(['url'=>route('user::changepassword'),'method'=>'post']) !!}
            <table>
                @if($old_pass_exist==true)
                    <tr>
                        <td>
                            {!! Form::label('old_password','Старый пароль') !!}
                        </td>
                        <td>
                            {!! Form::password('old_password') !!}
                        </td>
                    </tr>
                    @endif
                <tr>
                    <td> {!! Form::label('password','Пароль') !!}</td>
                    <td> {!! Form::password('password') !!}</td>
                </tr>
                <tr>
                    <td> {!! Form::label('password_confirmation','Повтор пароля:') !!}</td>
                    <td> {!! Form::password('password_confirmation') !!}</td>
                </tr>
            </table>


                <input type="hidden" value="{{$old_pass_exist}}">
            <input type="submit" value="Сохранить">
            {!! Form::close() !!}
        </div>
    </div>
    @endsection