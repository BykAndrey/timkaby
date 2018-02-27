var vm=Vue.component('paginate',{
    template:`
                <div class="paginate">

                <a v-if="current_page>1" href="#" v-on:click="prev($event)">
                    <div class="point"><<</div>
                </a>
                    <template v-for='i in [2,1,0,-1,-2]' v-if='current_page-i>0 && current_page-i<=count_pages'>
                    
                        <a href="#"  v-on:click="point(current_page-i,$event)" >
                            <div class="point selected" v-if="i==0">{{ current_page-i }}</div>
                            <div class="point" v-else>{{ current_page-i }}</div>
                        </a>
                        
                    </template>

                <a v-if="current_page<count_pages" href="#" v-on:click="next($event)">
                    <div class="point"> >> </div>
                </a>
            </div>

                `,
    props:['count_pages','current_page'],

    methods:{
        next:function (event) {
            if(page+1<=this.count_pages){
                page++;
                this.current_page=page;
                //getlist();

                this.$emit('reload', this.current_page);
            }
            event.preventDefault();
        },
        prev:function (event) {
            if(page-1>0){
                page--;
                this.current_page=page;
                //getlist();
                this.$emit('reload', this.current_page);
            }
            event.preventDefault();

        },
        point:function (p,event) {
            page=p;
            this.current_page=page;
            //getlist();
            this.$emit('reload', this.current_page);
            event.preventDefault();

        },

    }

});