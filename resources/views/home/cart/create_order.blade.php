@extends('home.base')
@section('header')
    <title>Оформление заказа - Timka.by</title>
    <meta name="description" content="Оформление заказа - Timka.by">
    @endsection
@section('data')
    <div class="block_good">
        @include('home.parts.elements.breadcrumbls')
        <div class="head">
            <h2>Оформление заказа</h2>
        </div>
        <div class="help">
            Коректно заполните форму заказа и в ближайшее время наш специалист свяжется с вами для подтверждения заказа.
            {{$option->name}} {{$option->price}}
        </div>
        <div class="user_log">

                @if(count($errors)>0)
                    <div class="help help-error">
                        Перепроверте введенные данные
                    </div>
                    @endif

            {!! Form::open() !!}
            <table>
                <tr>
                    <td>Имя:</td>
                    <td>
                        {{csrf_field()}}
                        <input type="text"
                               name="name"
                               class="common-input"
                               min="2"
                               required
                               placeholder="Имя"
                               value="{{old('name')?old('name'):$order_data->name}}">

                        <div class="input-help input-help-required">Обязательное поле</div>
                    </td>
                </tr>
                <tr>
                    <td>Телефон:</td>
                    <td>
                        <input type="text"
                               name="phone"
                               class="common-input"
                               min=7
                               required
                               placeholder="+375 (25) 555-55-55"
                               value="{{old('phone')?old('phone'):$order_data->phone}}">
                        <div class="input-help input-help-required">Обязательное поле</div>
                    </td>
                </tr>
                <tr>
                    <td>Адрес доставки:</td>
                    <td>
                      <!--  <textarea name="address" cols="30" rows="10" class="common-input">
                            {{old('adress')?old('adress'):$order_data->adress}}
                        </textarea>-->
                          <input type="text"
                                 name="adress"
                                 class="common-input"



                                 value="{{old('adress')?old('adress'):$order_data->adress}}">
                    </td>
                </tr>
                <tr>
                    <td>
                        Особенности при доставке:
                    </td>
                    <td>
                        <textarea name="feature" id="" cols="30" rows="10" class="common-input">
                            {{old('feature')?trim(old('feature')):trim($order_data->feature)}}
                        </textarea>
                    </td>
                </tr>

            </table>
                <input type="submit" value="Заказать!" class="common-but">
            {!! Form::close() !!}
        </div>
    </div>
    @endsection
@section('sctipts')
    @endsection