/*SLIDER*/
$(document).ready(function(){
    var list_slides=$('.slider-home>.display>.slide');
    var marks=$('.slider-home>.marks>.mark');
    var avtive_slide_id=0;
    var max_slide=$(list_slides).length;
    var allow_move=true;

    function  NextSlide() {
        GoLeftSlide();
        setInterval(function () {
            NextSlide();
        },10000);
    }

    if(max_slide>1){
        setInterval(function () {
            NextSlide();
        },10000);

    }




    function GoLeftSlide(){
        if(allow_move==true) {
            allow_move=false;
            $(list_slides).each(function (ind, el) {
                if ($(el).hasClass('active')) {

                    $(el).animate({'left': '-840px', 'opacity': 0}, 1000);
                    // $(el).removeClass('active');
                    avtive_slide_id = ind;
                }
            });
            if (avtive_slide_id + 1 >= max_slide) {
                $(list_slides).eq(0).addClass('preactive');
            } else {
                $(list_slides).eq(avtive_slide_id + 1).addClass('preactive');
            }
            setTimeout(function () {
                $(list_slides).each(function (ind, el) {
                    if ($(el).hasClass('active')) {

                        $(el).animate({'left': '0px', 'opacity': 1}, 100);
                        $(el).removeClass('active');
                        $(marks).eq(ind).removeClass('active');

                    }
                });
                if (avtive_slide_id + 1 >= max_slide) {
                    $(list_slides).eq(0).removeClass('preactive');
                    $(list_slides).eq(0).addClass('active');
                    $(marks).eq(0).addClass('active');
                    avtive_slide_id = 0;
                } else {
                    $(list_slides).eq(avtive_slide_id + 1).removeClass('preactive');
                    $(list_slides).eq(avtive_slide_id + 1).addClass('active');
                    $(marks).eq(avtive_slide_id + 1).addClass('active');
                    avtive_slide_id++;
                }
                allow_move=true;
            }, 1000);


        }
    }

    function GoRightSlide() {
        if(allow_move==true) {
            allow_move = false;
            $(list_slides).each(function (ind, el) {
                if ($(el).hasClass('active')) {

                    $(el).animate({'left': '840px', 'opacity': 0}, 1000);
                    // $(el).removeClass('active');
                    avtive_slide_id = ind;
                }
            });
            if (avtive_slide_id - 1 < 0) {
                $(list_slides).eq(max_slide - 1).addClass('preactive');
            } else {
                $(list_slides).eq(avtive_slide_id - 1).addClass('preactive');
            }
            setTimeout(function () {
                $(list_slides).each(function (ind, el) {
                    if ($(el).hasClass('active')) {

                        $(el).animate({'left': '0px', 'opacity': 1}, 100);
                        $(el).removeClass('active');
                        $(marks).eq(ind).removeClass('active');

                    }
                });
                if (avtive_slide_id + 1 < 0) {
                    $(list_slides).eq(max_slide - 1).removeClass('preactive');
                    $(list_slides).eq(max_slide - 1).addClass('active');
                    $(marks).eq(max_slide - 1).addClass('active');
                    avtive_slide_id = max_slide - 1;
                } else {
                    $(list_slides).eq(avtive_slide_id - 1).removeClass('preactive');
                    $(list_slides).eq(avtive_slide_id - 1).addClass('active');
                    $(marks).eq(avtive_slide_id - 1).addClass('active');
                    avtive_slide_id--;
                }
                allow_move=true;
            }, 1000);

        }
    }


    /*Left Slide*/
    $('.slider-home>.controlls>.left').click(function () {
        GoLeftSlide();

    });


    /*Left Slide*/
    $('.slider-home>.controlls>.right').click(function () {
        GoRightSlide()
    });
    $('.slider-home>.marks>.mark').click(function (e) {
        if (allow_move == true) {
            allow_move = false;

            var id = $('.slider-home>.marks>.mark').index(this);
            $(list_slides).each(function (ind, el) {
                if ($(el).hasClass('active') && id !=ind) {
                    $(el).animate({'opacity': 0}, 1000);
                    // $(el).removeClass('active');
                    avtive_slide_id = id;

                }
            });
            $(list_slides).eq(id).addClass('preactive');
            setTimeout(function () {
                $(list_slides).each(function (ind, el) {
                    if ($(el).hasClass('active')) {

                        $(el).animate({'left': '0px', 'opacity': 1}, 10);
                        $(el).removeClass('active');
                        $(marks).eq(ind).removeClass('active');

                    }
                });
                $(list_slides).eq(id).removeClass('preactive');
                $(list_slides).eq(id).addClass('active');
                $(marks).eq(id).addClass('active');
                allow_move=true;
            },1000);
        }
    });
});