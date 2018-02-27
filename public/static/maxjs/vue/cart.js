var header_cart=new Vue({
    el:'#header_cart',
    data: {
        count: 1,
        good_price:1,
    },
    created:function () {
        this.refresh();
    },
    mounted:function () {
        console.log('Headere cart mounted');
        $('#header_cart>.info').css('display','block');


        console.log('Headere cart mounted');
    },
    methods:{
        refresh:function () {
            //alert(1);
            $.ajax({
                url:'/cart/ajax',
                data:{
                    'action':'get_cart_data'
                },
                success:function (data) {
                    header_cart.count=data['count'];
                    header_cart.good_price=data['good_price'];
                }
            })
        }
    }
});
