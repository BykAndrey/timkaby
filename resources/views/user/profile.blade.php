@extends('home.base')
@section('header')
    <title>Профиль {{$user_data->name}} - Timka.by</title>
    @endsection
@section('tree')
    @include('user.tree')
    @endsection

@section('data')
    <div class="block_good">
        @include('home.parts.elements.breadcrumbls')
        <div class="head">
            <h2>Профиль</h2>
        </div>
        <div class="profile" id="profile">

                <div id="maindata" class="tab-content active">
                    <fieldset>
                        <legend>Основные данные</legend>
                        <table>
                            <tr>
                                <td>Email:</td>
                                <td>{{$user_data->email}}</td>
                            </tr>
                            <tr>
                                <td>Имя:</td>
                                <td>{{$user_data->name}}</td>
                            </tr>

                            <tr>
                                <td>Пароль:</td>
                                <td>
                                    <a  href="{{route('user::changepassword')}}" >
                                        <div>Сменить пароль</div></a>
                                </td>
                            </tr>
                        </table>
                    </fieldset>

                    <fieldset>
                        <legend>Дополнительные данные</legend>
                        <table>
                            <tr>
                                <td>Мобильный телефон:</td>
                                <td>

                                        <input  class="phone_mask" type="text"  v-model="phone" id="phone">

                                        <a href="#"  v-on:click="save_phone" ref="phone">
                                            <div>Сохранить&nbsp;телефон</div>
                                        </a>
                              
                                </td>
                            </tr>
                            <tr>
                                <td>Адрес:</td>
                                <td>

                                        <input type="text" value="{{$user_data->adress}}" v-model="adress">

                                        <a href="#" v-on:click="save_adress"  ref="adress">
                                            <div>Сохранить&nbsp;адресс</div>
                                        </a>

                                </td>
                            </tr>
                            <tr>
                                <td>Особенности при доставке:</td>
                                <td>
                                    <textarea name="" id="" cols="30" rows="10" v-model="feature"> {{$user_data->feature}}</textarea>

                                
                                        <a href="#" v-on:click="save_feature" ref="feature">
                                            <div>Сохранить&nbsp;особенности</div>
                                        </a>
                                  
                                </td>
                            </tr>
                        </table>
                    </fieldset>

                </div>


    </div>
    </div>

@endsection

@section("scripts")
    <script src="{{URL::asset('static/js/plugin/jquery.maskinput.js')}}"></script>
    <script>

     /*   jQuery(function($) {
            //$.mask.definitions['~']='[+-]';
          //  $('input[type="text"]#phone').mask('+375 (99) 999-99-99');
            console.log(1);
        });
*/
        var profile=new Vue({
            el:"#profile",
            data:{
                feature:'{{$user_data->feature}}',
                phone:'{{$user_data->phone}}',

                adress:'{{$user_data->adress}}'

            },

            methods:{
                save_phone:function (event) {
                    event.preventDefault();
                    var phone=$('input[type="text"]#phone').val();

                    if(phone.length>=19)
                    $.ajax({
                        url:'/user_ajax',
                        data:{
                            'action':'save_phone',
                            '_token':'{{csrf_token()}}',
                            'phone':phone,
                        },

                        method:'post',
                        success:function (data) {
                            $(profile.$refs.phone).children('div').css({'animation-name':'good'});
                            setTimeout(function () {
                                $(profile.$refs.phone).children('div').css({'animation-name':'none'});
                            },4000);
                            //console.log(data);
                            console.log('phone saved');
                        },
                        error:function (data) {
                            $(profile.$refs.phone).children('div').css({'animation-name':'bad'});
                            setTimeout(function () {
                                $(profile.$refs.phone).children('div').css({'animation-name':'none'});
                            },4000);
                        }
                    });

                },
                save_adress:function (event) {
                    event.preventDefault();

                    $.ajax({
                        url:'/user_ajax',
                        data:{
                            'action':'save_adress',
                            '_token':'{{csrf_token()}}',
                            'adress':profile.adress,
                        },
                        method:'post',
                        success:function (data) {
                            $(profile.$refs.adress).children('div').css({'animation-name':'good'});
                            setTimeout(function () {
                                $(profile.$refs.adress).children('div').css({'animation-name':'none'});
                            },4000);
                            console.log(data);
                        },
                        error:function (data) {
                            $(profile.$refs.adress).children('div').css({'animation-name':'bad'});
                            setTimeout(function () {
                                $(profile.$refs.adress).children('div').css({'animation-name':'none'});
                            },4000);
                        }
                    });
                    console.log('adress saved' +this.adress);
                },
                save_feature:function (event) {
                    event.preventDefault();


                    $.ajax({
                        url:'/user_ajax',
                        data:{
                            'action':'save_feature',
                            '_token':'{{csrf_token()}}',
                            'feature':profile.feature,
                        },
                        method:'post',
                        success:function (data) {
                            $(profile.$refs.feature).children('div').css({'animation-name':'good'});
                            setTimeout(function () {
                                $(profile.$refs.feature).children('div').css({'animation-name':'none'});
                            },4000);
                            console.log(data);
                        },
                        error:function (data) {
                            $(profile.$refs.feature).children('div').css({'animation-name':'bad'});
                            setTimeout(function () {
                                $(profile.$refs.feature).children('div').css({'animation-name':'none'});
                            },4000);
                        }
                    });
                    console.log('feature saved');
                }
            }
        })
    </script>
    @endsection
