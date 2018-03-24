/*
*
*
*
*           slider->display->slide
*           slider->controls->marks->mark
*
*
*
* */
(function () {

    
    jQuery.fn.simple_slider=function(options){
            
        options=$.extend({
            width:100
        },options);
        var slides=$(this).find('.display').children('.slide');
        var marks=$(this).find('.controls .marks').children('.mark');

        var Count=$(slides).length;



        var setUnactive=function () {
            $(slides).each(function (i,el) {
                if($(el).hasClass('active')){
                    $(el).animate({'opacity':0},1000);
                    setTimeout(function () {
                        $(el).removeClass('active');
                    },1000)
                }

            });
        }
        
        
        var setActive=function (id) {
            if(!$(slides).eq(id).hasClass('active')){
                setUnactive();
                $(slides).eq(id).animate({'opacity':1},1000);
                $(slides).eq(id).addClass('active');
            }

        }


        
        
        var make=function(){


            console.log($(marks));
            setUnactive();
            $(slides).eq(0).css('opacity',1);
            $(slides).eq(0).addClass('active');

            $(slides).click(function () {

            });

            $(marks).click(function () {
                    
                var mark=$(marks).index(this);
                setActive(mark);
                    
            });

        };

        return this.each(make);

    };


})(jQuery);

