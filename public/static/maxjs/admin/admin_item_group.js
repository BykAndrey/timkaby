/*Function  definding a price for Item_group and children items*/
function setPrice_item_group(id,el){
    console.log("id="+id);
    console.log("val="+$(el).val());
    console.log(parseFloat($(el).val()));
    var price=parseFloat($(el).val());

    $.ajax({
        url:'/admin/itemgroup/ajax',
        data:{
            'action':'setNewPrice',
            'id':id,
            'price':price
        },
        success:function(data){
            console.log(data);
        },
        error:function(data){
            console.log(data);
        }
    })
}




/*Function  definding a discount for Item_group and children items*/
function setDiscount_item_group(id,el){
    console.log("id="+id);
    console.log("val="+$(el).val());
    console.log(parseInt($(el).val()));
    var discount=parseInt($(el).val());

    $.ajax({
        url:'/admin/itemgroup/ajax',
        data:{
            'action':'setNewDiscount',
            'id':id,
            'discount':discount
        },
        success:function(data){
            console.log(data);
        },
        error:function(data){
            console.log(data);
        }
    })
}


/*Загрузка картинки через ajax*/
function uploadImage(token,image) {
    var form=new FormData();
    form.append('_token',token);
    form.append('action','uploadImage');
    form.append('image',image);


    var nameImage='';
    $.ajax({
        url:'/admin/itemgroup/ajax',
        data:form,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        async:false,
        success:function(data) {
            nameImage=data;
            console.log(data);
        }
    });
    return nameImage;
}





$(document).ready(function () {
    $('#upload').click(function (e) {
        e.preventDefault();
        var token=$('input[name="_token"]').val();
        console.log(token);
        var image=$('#image')[0].files[0];
        if(image!=null){
            var name=(uploadImage(token,image));//"1518506290.jpg";//
            $('#ajaxImage').attr('src',"/static/imagesItem/"+name);
            $('input[name="ajaxImageField"]').val(name);
        }

        // $('input[type="file"]')
    })
});