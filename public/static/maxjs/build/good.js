

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
           // header_cart.refresh();
        }
    }
}

if (module.exports.__esModule) module.exports = module.exports.default
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  if (!module.hot.data) {
    hotAPI.createRecord("_v-5f1fb262", module.exports)
  } else {
    hotAPI.update("_v-5f1fb262", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}