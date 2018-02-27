
var good1 =Vue.component('good',{
    template:`
    <div class="good middle">
                <div v-if="item.discount>0" class="flag_discount">
                    <img src="/static/img/red_flag.svg" width="90" alt="RED FLAG">
                    <p>-{{item.discount}}%</p>
                </div>
                <a v-bind:href="getUrl(item.caturl,item.url)">
                    <div class="image" v-bind:style="{'background-image':'url(/'+item.image+')'}">

                    </div>
                </a>
                <div class="info">
                    <h5><a v-bind:href="getUrl(item.caturl,item.url)">{{ item.name }}</a></h5>
                    <p>{{ parseFloat(item.price).toFixed(2) }}&nbsp;р. &nbsp; &nbsp; 
                       
                    <strike v-if="item.discount>0">{{ parseFloat(item.old_price).toFixed(2) }}&nbsp;р.</strike>
               <!--     <br>
                     <span v-if="item.discount>0" class="discount">-{{ item.discount }}%</span>-->
                     </p>
                    <div v-bind:title="'Рейтинг товара '+item.rating+'/5'">
                      
                       <template v-for="i in [0,1,2,3,4]">
                    
                               <template  v-if="item.rating-i>=1" >
                                     <img src="/static/img/star-full.svg" width="14" alt=""/>
                              </template>
                              <template v-else>
                                  <template v-if="item.rating-i>=0.5">
                                        <img  src="/static/img/star-half.svg" width="14" alt="">
                                  </template>
                                    <template v-else>
                                     <img  src="/static/img/star-empty.svg" width="14" alt="">
                                    </template>
                               </template>
                             
                        </template>
                                                          
                        
                    </div>
                    <div class="cntrls">
                     
                        <div class="common-but common-but-clear">
                            <div class="common-but-left common-but " v-on:click="addToCart(item.id)">В &nbsp; корзину</div>
                            <div class="common-but-right common-but " v-on:click="addToFavorite(item.id)" title="Добавить в избранное">
                                    <img src="/static/img/like.svg" alt="Нравится" width="20" title="Добавить в избранное">
                            </div>
                        </div>
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
                        cycleMessage('Товар добавлен в "Корзина"');
                    }else{
                        cycleMessage('Ошибка');
                    }
                }
            });
            header_cart.refresh();
        },
        addToFavorite:function (id) {
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
    }

})