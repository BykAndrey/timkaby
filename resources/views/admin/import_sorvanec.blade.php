@extends('admin.base')



@section('content')

    <div>
        <form action="{{route('admin::load_goods')}}" method="post">
            {{csrf_field()}}
            <input type="text" name="name">
            {!! Form::select('id_good_category', $category_list,old('') ) !!}
            <input type="submit">
        </form>
    </div>

    @endsection