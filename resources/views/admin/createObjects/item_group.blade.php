@extends('admin.base')

@section('content')
    <h2>Создание нового товара</h2>
    @include('admin.forms.item_group')


    <script src="{{URL::asset('/static/js/admin/admin_item_group.js')}}"></script>
@endsection
