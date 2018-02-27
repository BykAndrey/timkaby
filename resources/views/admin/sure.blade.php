@extends('admin.base')
@section('content')
    <p class="pay_attention">Все связанные данные будут автоматически удалены</p>
    <p class="warning">Вы уверены? </p>
    <form action="{{$route}}" method="post">
        {{csrf_field()}}
        <input type="submit" class="save" value="Удалить {{$name}}">
    </form>
    @endsection