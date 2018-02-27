@extends('admin.base')
@section('content')
    <h2>Создать Пользователя</h2>
    @include('admin.forms.users')
@endsection
@section('scripts')
    <script>
        $('#phone').mask('+375 (99) 999-99-99');
    </script>
@endsection