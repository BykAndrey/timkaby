




















































module.exports={
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

if (module.exports.__esModule) module.exports = module.exports.default
;(typeof module.exports === "function"? module.exports.options: module.exports).template = "\n\n<div class=\"good middle\">\n\n    <a :href=\"getUrl(item.caturl,item.url)\">\n        <div class=\"image\" v-bind:style=\"{'background-image':'url(/'+item.image+')'}\">\n\n        </div>\n    </a>\n    <div class=\"info\">\n        <h5><a :href=\"getUrl(item.caturl,item.url)\">{{ item.name }}</a></h5>\n        <p>{{ (item.price).toFixed(2) }} р. <br>\n            <span v-if=\"item.discount>0\" class=\"discount\">-{{ item.discount }}%</span>\n        </p>\n        <div :title=\"'Рейтинг товара '+item.rating+'/5'\">\n\n            <template v-for=\"i in [0,1,2,3,4]\">\n\n                <template v-if=\"item.rating-i>1\">\n                    <img src=\"/static/mySh/images/star-full.svg\" width=\"10\" alt=\"\">\n                </template>\n                <template v-else=\"\">\n                    <template v-if=\"item.rating-i>=0.5\">\n                        <img src=\"/static/mySh/images/star-half.svg\" width=\"10\" alt=\"\">\n                    </template>\n                    <template v-else=\"\">\n                        <img src=\"/static/mySh/images/star-empty.svg\" width=\"10\" alt=\"\">\n                    </template>\n                </template>\n\n            </template>\n\n\n\n\n\n        </div>\n        <div class=\"cntrls\">\n\n            <div class=\"common-but common-but-clear\">\n                <div class=\"common-but-left common-but \" v-on:click=\"addToCart(item.id)\">В Корзину!</div>\n                <div class=\"common-but-right common-but \">\n                    <img src=\"/static/mySh/images/like.svg\" alt=\"Нравится\" width=\"20\">\n                </div>\n            </div>\n        </div>\n    </div>\n</div>\n\n"
if (module.hot) {(function () {  module.hot.accept()
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), true)
  if (!hotAPI.compatible) return
  if (!module.hot.data) {
    hotAPI.createRecord("_v-62fa1682", module.exports)
  } else {
    hotAPI.update("_v-62fa1682", module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
  }
})()}