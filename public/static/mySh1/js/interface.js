(function ($) {
    $.fn.mytab = function () {
        var removeActive=function(){
            $(this).removeClass('active');
         
        }
        var make=function(){
            var Tab = $(this);

        $(this).find(' a.tab').click(function (event) {

            
                

            event.preventDefault();

            var name = $(this).attr('href');
            document.location.hash=name;
            $(Tab).find('a.tab').each(removeActive);

            $(Tab).find('.tab-content.active').animate({'opacity':0},500);

            $(Tab).find('.tab-content').each(removeActive);
   
            $(this).addClass('active');
         
            $(Tab).find(name).addClass('active');
            $(Tab).find('.tab-content.active').animate({'opacity':1},500);
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
                padding: '0px 40px',

                },1000);


            setTimeout(function () {
                $('#move_to_top>.message').animate({
                    width:'0px',
                    padding: '0px',
                //    opacity: '0',
                },1000);
            },1500);



            setTimeout(function () {
                if(color=='blue'){
                    $('#move_to_top>.message').removeClass('message-blue');
                }
                if(color=='red'){
                    $('#move_to_top>.message').removeClass('message-red');
                }
                if(color=='green'){
                    $('#move_to_top>.message').removeClass('message-green');
                }
                cycleMessageFlag=true;
            },3000);



        }
}

$(document).ready(function () {


    $('.tabs').mytab();






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

    $('.content aside#aside div.toggle').click(function () {
        var menu = $('ul.list');
        if ($(menu).css('display') != 'none') {
            $(menu).animate({
                'height': 'hide',
                'opacity': 0
            }, 150);
        } else {
            $(menu).animate({
                'height': 'show',
                'opacity': 1
            }, 250);
        }

    });



});