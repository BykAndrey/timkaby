<!DOCTYPE html>
<html lang="ru">
    <head>
        <link rel="stylesheet" href="{{ URL::asset('static/css/admin_style.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('static/js/plugin/jquery-te-1.4.0.css') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--<script
                src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
                crossorigin="anonymous"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->

        <script src="{{URL::asset('static/js/plugin/jquery-3.2.1.min.js')}}" ></script>
    <!-- <script src="{{URL::asset('static/js/plugin/jquery.tmpl.js')}}" ></script>-->
        <script src="{{URL::asset('static/js/plugin/jquery-te-1.4.0.min.js')}}" ></script>
        <script src="{{URL::asset('static/js/plugin/jquery-ui.js')}}" ></script>
    <!--  <script src="{{URL::asset('static/js/plugin/jquery.slugify.js')}}" ></script>-->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
        <script  src="{{URL::asset('static/js/admin/admin_category.js')}}" ></script>
        <script>
            $( function() {

                $( "#tabs" ).tabs();
                //$("#url").css('class','');
               // $("#url").slugify("#title");
                $(".name").on('change paste keyup',function () {
                    //console.log(1);
                    $(".url").val(url_slug($(".name").val()));
                })
                $(".text_redactor").jqte();
            } );
            function ShowMessage(message='Действие выполнино',type='green') {
                $('#message.message').css('display','block');
                $('#message.message').css('opacity','1');
                $('#message.message').css('height','50');
                if(type=='green'){
                    $('#message.message').children('span').html(message);
                }else{
                    $('#message.message').addClass('error');
                    $('#message.message').children('span').html(message);
                }

                setTimeout(function () {

                    $('#message.message').animate({'opacity':'0'},1500);
                },1500);
                setTimeout(function () {

                    $('#message.message').css('height','0');
                },3000);

            }
        </script>
        <script src="https://unpkg.com/vue"></script>
        <title>Admin Panel</title>
    </head>
    <body>
        <header>
            <div class="links">
                <h3><a href="/">На сайт</a></h3>
            </div>
            <div class="links">
                <h3>Магазин</h3>
                <ul>

                    @foreach($header_menu as $li)
                        @if($li['place']==1)
                        <li> <a href="{{$li['route']}}">{{$li['templateName']}}</a></li>
                        @endif
                    @endforeach
                </ul>

            </div>
            <div class="links">
                <h3>Разделы</h3>
                <ul>
                @foreach($header_menu as $li)
                    @if($li['place']==2)
                            <li>  <a href="{{$li['route']}}">{{$li['templateName']}}</a></li>
                    @endif
                @endforeach
                </ul>
            </div>
            <div class="links">
                <h3>Пользователи</h3>
                <ul>
                @foreach($header_menu as $li)
                    @if($li['place']==3)
                      <li> <a href="{{$li['route']}}">{{$li['templateName']}}</a></li>
                    @endif
                @endforeach
                </ul>
            </div>
            <div class="links">
                <h3>Import</h3>
                <ul>
                    <li><a href="{{route('admin::loadOneGood')}}">Import One Good</a></li>
                </ul>
            </div>

        </header>
        <div class="content">
            <div id="message" class="message" style="display: none">
                <span>Действие выполнено</span>
            </div>
            <div class="bread_crumbs">
            @foreach($bread_crumbs as $key=>$crumb)
                <a href="{{$crumb}}">{{$key}}</a> \
                @endforeach
            </div>

            @yield('content')
        </div>
        <footer>

        </footer>
    @yield('scripts')
    </body>
</html>