<script>
    var good =Vue.component('good_vue',{
        template:`
<div class="good middle">

    <a :href="getUrl(item.caturl,item.url)">
        <div class="image" v-bind:style="{'background-image':'url(/'+item.image+')'}">

        </div>
    </a>
    <div class="info">
        <h5><a :href="getUrl(item.caturl,item.url)">@{{ item.name }}</a></h5>
        <p> @{{ (item.price).toFixed(2) }} р. <br>
            <span v-if="item.discount>0" class="discount">Скидка @{{ item.discount }}%</span>
        </p>
        <div title="Рейтинг товара">
            <img src="{{URL::asset('static/img/star-full.svg')}}" width="10" alt="">
            <img src="{{URL::asset('static/mySh/images/star-full.svg')}}" width="10" alt="">
            <img src="{{URL::asset('static/mySh/images/star-half.svg')}}" width="10" alt="">
            <img src="{{URL::asset('static/mySh/images/star-empty.svg')}}" width="10" alt="">
            <img src="{{URL::asset('static/mySh/images/star-empty.svg')}}" width="10" alt="">
        </div>
        <div class="cntrls">
            <button title="Добавить в корзину">
                <img src="{{URL::asset('static/mySh/images/tocart.svg')}}" alt="Добавить в корзину" width="20">
            </button>
            <button title="Нравится"><img src="{{URL::asset('static/mySh/images/like.svg')}}" alt="Нравится" width="20"></button>
            <button title="Промотр товара" v-on:click="toCatd(item.caturl,item.url)">
                <img src="{{URL::asset('static/mySh/images/eye.svg')}}" alt="Промотр товара" width="20"></button>
        </div>
    </div>
</div>


`,
        props:['item'],
        methods:{
            getUrl:function (caturl,url) {
                var url='/catalog/'+caturl+'/'+url;
                return url;
            },
            toCatd:function (caturl,url) {
                window.location=this.getUrl(caturl,url);
            }
        }

    })
</script>
