var quick_order=Vue.component('quick_order',{
    template:`
    <div class="quick_order" >
    <div class="quick_order-display">
            <div class="exit" v-on:click="close()">
            <img src="http://timka.by/static/img/cross.svg" alt="выход" width="25">
</div>
            <h2 class="head">Быстрая покупка</h2> <div class="help">В ближайшее время специалист свяжется с Вами для подтверждения заказа</div>
            <div class="quick_order-content">
           
                <div class="quick_order-good">
                   <fieldset>
                        <legend>Товар</legend>
                        <img :src="'/static/imagesItem/'+item.image" :alt="item.name" width="180"><br>
                        
                        <h4>{{item.name}}</h4>
                        <h3>{{item.price-(item.discount*item.price/100)}}&nbsp;руб.</h3>
                    </fieldset>
                    
                </div>
                
                <div class="quick_order-user">
                    <fieldset>
                        <legend>Данные для заказа</legend>
                        <label for="quick_name">Имя:</label>
                        <input type="text" class="common-input" id="quick_name" v-model="user.name" v-on:keyup="changePhone">
                        <label for="phone_number">Телефон:</label>
                        <input type="text" class="common-input" id="phone_number" v-model="user.phone" v-on:keyup="changePhone">
                        <label for="quick_adress">Адрес доставки:</label>
                        <input type="text" class="common-input" id="quick_adress"  v-model="user.adress">
                        <label for="quick_delivery">Спостоб доставки:</label>
                        <select v-model="selectDelivery" name="quick_delivery" id="quick_delivery" class="common-select common-select_width_full common-select_margin_no" >
            
                          
                            <option v-for="opt in options_delivery" :value="opt.id">{{opt.name}} ({{opt.text_price}})</option>
                        </select>
                        <label for="quick_feature">Комментарий:</label>
                        <textarea class="common-input" id="quick_feature"  v-model="user.feature">
                        </textarea>
                    </fieldset>
                </div>
            </div>
            <div class="quick_order-controls">
            <div >
                <button class="common-but common-but-red common-but_width_full" v-on:click="buy">Заказать! </button>
              </div>
              
              <div v-if="auth==false" >
                    <button class="common-but">Авторизация</button>
                    <button class="common-but">Регистрация</button>
                </div>
                
            </div>
        </div>
        </div>
    `,
    props:['item'],
    data:function () {
        return {
            item:this.item,
            user:{
                name:'',
                phone:'',
                adress:'',
                feature:''
            },
            auth:false,
            options_delivery:null,
            selectDelivery:0
        }
    },
    created:function () {
        var delivery={};
        $.ajax({
            url:'/cart/ajax',
            async:false,
            data:{
                'action':'getOptionDelivery'
            },
            success:function (data) {
                delivery=data;
            }
        });
        this.options_delivery=delivery;
        //console.log(this.options_delivery);
        this.selectDelivery=this.options_delivery[0]['id'];

       $.ajax({
           url:'/ajax',
           async:false,
           data:{
               'action':'getAuthUser'
           },
           success:function (data) {
              // console.log(2);
               quick_order.user=data;
               //console.log(quick_order.user.name);
           }
       });
        this.user=quick_order.user;
        if(this.name!=null || this.name!=''){
            this.auth=true;
        };



    },
    mounted:function () {
        $('#phone_number').mask('+375 (99) 999-99-99');

    },
    methods:{
        changePhone:function () {


            var myRe = /.+(375)\s\(\d{2}\)\s(\d{3})\-(\d{2})\-(\d{2})/;

            var myArray = myRe.exec( $('#phone_number').val());

            if(myArray==null){
                $('#phone_number').addClass('common-input_error');
            }else{
                $('#phone_number').removeClass('common-input_error');
            }
            this.user.phone=$('#phone_number').val();
            console.log(this.selectDelivery);
        },
        close:function () {
            this.$emit('close');
        },
        buy:function () {


            var send=true;
            var myRe = /.+(375)\s\(\d{2}\)\s(\d{3})\-(\d{2})\-(\d{2})/;

            var myArray = myRe.exec( $('#phone_number').val());

            if(myArray==null){
                send=false;
            };

            if(this.user.name!=undefined)
            if(this.user.name.length<3){
                send=false;
                $('#quick_name').addClass('common-input_error');
            };

            if(this.user.adress!=undefined)
            if(this.user.adress.length<5){
                send=false;

                $('#quick_adress').addClass('common-input_error');
            }else{

            };


            if(send==true){
                var item=this.item;
                var delivery=this.selectDelivery;
                var user=this.user

                    $.ajax({
                        url:'/cart/ajax',
                        data:{
                            'action':'quick_order',
                            'id_item':item.id,
                            'user_name':user.name,
                            'user_phone':user.phone,
                            'user_adress':user.adress,
                            'user_feature':user.feature,
                            'delivery':delivery
                        },
                        success:function (data) {
                            //alert(data);
                            cycleMessage('Заказ принят!');
                        }
                    });



                this.$emit('close');
            }else{
                
            };
            
        },
    },
});

