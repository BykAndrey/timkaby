<template>
  <h1>Hello</h1>
</template>


<script>
    module.exports= {
        name:'good',
        props:['item'],
        methods:{
            getUrl:function (caturl,url) {
                var url='/catalog/'+caturl+'/'+url;
                return url;
            },
            toCatd:function (caturl,url) {
                window.location=this.getUrl(caturl,url);
            },
            addToCart:function (id) {
                $.ajax({
                    url:'/cart/cart_add',
                    method:'get',
                    async:false,
                    data:{
                        'id':id
                    },
                    success:function (data) {
                        if(data==1){

                        }
                    }
                });
                header_cart.refresh();
            }
        }
    }
</script>