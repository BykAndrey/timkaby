function setItemActive (id,el) {

    $.ajax({
        url:'/admin/item/ajax',
        data:{
            'action':'setActive',
            'id':id
        },
        success:function (data) {

            if(data==0){
                $(el).removeClass('but_green');
                $(el).addClass('but_red');
            }
            if(data==1){
                $(el).removeClass('but_red');
                $(el).addClass('but_green');
            }
            //  console.log(data);
        },
        error:function () {
            console.log('error');
        }
    });
    // console.log(2);
}


function setItemNew (id,el) {

    $.ajax({
        url:'/admin/item/ajax',
        data:{
            'action':'setNew',
            'id':id
        },
        success:function (data) {

            if(data==0){
                $(el).removeClass('but_green');
                $(el).addClass('but_red');
            }
            if(data==1){
                $(el).removeClass('but_red');
                $(el).addClass('but_green');
            }
            //  console.log(data);
        },
        error:function () {
            console.log('error');
        }
    });
    // console.log(2);
}

function setItemDiscount(id,el) {

    console.log("id="+id);
    console.log("val="+$(el).val());
    console.log(parseInt($(el).val()));
    var discount=parseInt($(el).val());

    $.ajax({
        url:'/admin/item/ajax',
        data:{
            'action':'setDiscount',
            'id':id,
            'discount':discount
        },
        success:function(data){
            console.log(data);
        },
        error:function(data){
            console.log(data);
        }
    });
}

function setItemPrice(id,el) {

    console.log("id="+id);
    console.log("val="+$(el).val());
    console.log(parseFloat($(el).val()));
    var price=parseFloat($(el).val());

    $.ajax({
        url:'/admin/item/ajax',
        data:{
            'action':'setPrice',
            'id':id,
            'price':price
        },
        success:function(data){
            console.log(data);
        },
        error:function(data){
            console.log(data);
        }
    });
}