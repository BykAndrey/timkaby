var dollar_rate=new Vue({
    el:'#item_group',
    data:{
        id_provider:$('#id_provider').val(),
        dollar_rate:1,
        dollar_price:0,
        BYN_price:$('#price').val(),
    },
    methods:{
        get_rate:function () {
            $.ajax({
                url:'/admin/itemgroup/ajax',
                data:{
                    'id_provider':dollar_rate.id_provider,
                    'action':'get_dollar_rate'
                },
                method:'get',
                success:function (data) {
                    dollar_rate.dollar_rate=data;
                    dollar_rate.dollar_price=(dollar_rate.BYN_price/data).toFixed(4);
                }
            });
            console.log(this.id_provider);
        },
        change_BYN:function () {
            dollar_rate.dollar_price=(dollar_rate.BYN_price/ dollar_rate.dollar_rate).toFixed(4);
        },
        change_dollar:function () {
            dollar_rate.BYN_price=(dollar_rate.dollar_price*dollar_rate.dollar_rate).toFixed(2);
        }
    }
});
dollar_rate.get_rate();