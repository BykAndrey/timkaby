(function ($) {
    $.fn.mytab = function () {
        var removeActive=function(){
            $(this).removeClass('active');
         
        };
        var make=function(){
            var Tab = $(this);

        $(this).find(' a.tab').click(function (event) {
            event.preventDefault();
            if(!$(this).hasClass('active')){
                var name = $(this).attr('href');
                document.location.hash=name;
                $(Tab).find('a.tab').each(removeActive);

                $(Tab).find('.tab-content.active').animate({'opacity':0},500);

                $(Tab).find('.tab-content').each(removeActive);

                $(this).addClass('active');

                $(Tab).find(name).addClass('active');
                $(Tab).find('.tab-content.active').animate({'opacity':1},500);
            }

        });

    
        };
        return this.each(make);

    };
}(jQuery));

var cycleMessageFlag=true;
var cycleMessageStack=[];
function cycleMessage(message,color='blue') {
        if(cycleMessageFlag==true){
            cycleMessageFlag=false;
            cycleMessageStack.push(message);
            console.log(cycleMessageStack);


            $('#move_to_top>.message').children('.message-content').children('span').html(message);



            if(color=='blue'){
                $('#move_to_top>.message').addClass('message-blue');
            }
            if(color=='red'){
                $('#move_to_top>.message').addClass('message-red');
            }
            if(color=='green'){
                $('#move_to_top>.message').addClass('message-green');
            }

            $('#move_to_top>.message').animate({
                width:'250px',
                padding: '0px 40px'

                },1000);


            setTimeout(function () {
                $('#move_to_top>.message').animate({
                    width:'0px',
                    padding: '0px'

                },1000);
            },1500);



            setTimeout(function () {
                if(color=='blue'){
                    $('#move_to_top>.message').removeClass('message-blue');
                };
                if(color=='red'){
                    $('#move_to_top>.message').removeClass('message-red');
                };
                if(color=='green'){
                    $('#move_to_top>.message').removeClass('message-green');
                };
                cycleMessageFlag=true;
            },3000);



        };
};

$(document).ready(function () {


    $('.tabs').mytab();


    /*ВВЕРХ!*/
    $('#move_to_top').each(function(){
        $(this).click(function(){
            $('html,body').animate({ scrollTop: 0 }, 'slow');
            return false;
        });
    });



    /*анимация для кнопок*/
    $('.common-but').on('click',function () {
       // console.log('animate');

        $(this).css('animation-name','good');

        var but=$(this);

        setTimeout(function () {
            //console.log($(but).html());
            $(but).css('animation-name','+=none');
        },1000*4);
      //  $(this).css('animation-name','none');
    });


    var menuItemShow=6;

    $('ul.list').css('display','block');



    /*если в меню больше N - элементов*/
    if($('ul.list>li').length>menuItemShow){




        $('ul.list').css('height',51*(menuItemShow+1));

        for(var i=0;i<$('ul.list>li').length;i++){
            $('ul.list>li').eq(i).css('display','none');
        }

        for(var i=0;i<menuItemShow;i++){
            $('ul.list>li').eq(i).css('display','flex');
        }
        $('ul.list>li:eq('+menuItemShow+')').after('<li class="show_more" id="show_more">Развернуть полностью</li>');
    }


    /*развернуть меню*/
    $('.content aside#aside div.toggle').click(function () {
        $('#show_more').detach();
        for(var i=0;i<$('ul.list>li').length;i++){
            $('ul.list>li').eq(i).css('display','flex');
        }
        $('ul.list').css('height','inherit');
        var menu = $('ul.list');
        if ($(menu).css('display') != 'none') {
            $('.cat_menu').removeClass('active');
            $(menu).animate({
                'widht':'hide',
                'height': 'hide',
                'opacity': 0
            }, 150);
        } else {
            $('.cat_menu').addClass('active');
            $(menu).animate({
                'height': 'show',
                'opacity': 1
            }, 250);
        };

    });

    /*Полностью раскрыть меню*/
    $('#show_more').on('click',function () {
        $('ul.list').css('height','inherit');
        for(var i=0;i<$('ul.list>li').length;i++){
            $('ul.list>li').eq(i).animate({'height':'show'},300);//.css('display','flex');
        }
        $('#show_more').detach();
    });

    /*
    * В мобильной версии
    * Открыть меню*/
    $('.content .aside_toggle').click(function () {

         if ($('aside#aside').css('left')=='0px') {
             $('aside#aside').animate({'left': -270}, 700);
             $('.content .aside_toggle').animate({'left': 0}, 700);

         }else{
             $('aside#aside').animate({'left': 0}, 700);
             $('.content .aside_toggle').animate({'left': 270}, 700);
         }
    });


});