
/*  добавить в понравившиеся товары  */

function  addToFavorite(id) {

    $.ajax({
        url:'/ajax',
        method:'get',

        data:{
            'action':'addToFavorite',
            'id':id
        },
        success:function (data) {

            if(data==1){
                cycleMessage('Товар добавлен в "Понравившийся товар"');
            }

            if(data==0){
                cycleMessage('Товар уже есть в "Понравившийся товар"');
            }

            if(data==-1){
                cycleMessage('Зарегистрируйтесь на сайте','red');
            }

        },
        error:function () {
            console.log('error');
        }
    });


}
function  removeFromFavorite(id,el) {

    $.ajax({
        url:'/ajax',
        method:'get',
        async:true,
        data:{
            'action':'removeFromFavorite',
            'id':id
        },
        success:function (data) {
            location.reload();
        },
        error:function () {
            console.log('error');
        }
    });

    el.preventDefault();
}


/*добавить в корзину по id*/

function addToCart(id) {
    //console.log(1);
    $.ajax({
        url:'/cart/cart_add',
        method:'get',
       // async:false,
        data:{
            'id':id
        },
        success:function (data) {
            if(data==1){
                header_cart.refresh();

                cycleMessage('Товар добавлен в "Корзина"');
            }
        },
        error:function () {
            console.log('error');
        }
    });
}


