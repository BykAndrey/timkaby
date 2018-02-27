//import Vue from 'vue'
import Vue from './../plugin/vue.min.js'
import good from './../build/good.js'

var list={};
var page=1;
var size=$('select#size').val();
var filterSelectID=[];
var sortby="";
var MinPrice=0.01;
var MaxPrice=500.00;
var allow_reload=true;








function getUrlParam() {

    var url= window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    var params=JSON;
    for(var i =0; i<url.length;i++){
        // params.push([url[i].split('=')[0],url[i].split('=')[1]]);
        var len=Object.keys(params).length;
        var flag=false;
        for(var par in params){
            // console.log(par,params[par]);

            if(par==url[i].split('=')[0]){
                // console.log(url[i].split('=')[0]);
                params[par]=[params[par],url[i].split('=')[1]];
                flag=true;
            }
        }
        if(flag==false){
            params[url[i].split('=')[0]]=url[i].split('=')[1];
        }

    }
    return params;
}

/*****************************************************/
var params=getUrlParam();
if(params['page']!=null){
    page=params['page'];
}else{
    page=1;
}

size=params['size']!=null?params['size']:20;
MinPrice=params.hasOwnProperty('min_price')?params['min_price']:0;
MaxPrice=params.hasOwnProperty('rangePrice[]')?params['rangePrice[]'][1]:500;
console.log(MinPrice);
//var range1= $('#range').data("ionRangeSlider");



sortby=params.hasOwnProperty('sortby')?params['sortby']:null;
// console.log([params['filterSelectID[]']]);

if(params.hasOwnProperty('filterSelectID[]'))
    filterSelectID=filterSelectID.concat(params['filterSelectID[]']);
else{
    if(params.hasOwnProperty('filterSelectID%5B%5D'))
        filterSelectID=filterSelectID.concat(params['filterSelectID%5B%5D']);
}
//filterSelectID=params.hasOwnProperty('filterSelectID[]')?[]:[];

if(params.hasOwnProperty('sortby')){
    $('select#sortby option[value='+params['sortby'][0]+']').attr('selected', 'selected');
}

if(params.hasOwnProperty('size')){
    $('select#size option[value='+params['size']+']').attr('selected', 'selected');
}

//console.log($('select#sortby').val());
/***********************************/




function getlist() {
    //console.log("SORT BY= "+sortby);
    // console.log("PAGE= "+page);
    // console.log("SIZE= "+size);
    $('#load_gif').css('display','block');

    $.ajax({
        url:'/catalog/detskie-avtokresla',
        async:false,
        data:{
            //'action':'getListItemGroup_Catalog',
            //'url':'{{$Cat->url}}',
            'page':page,
            'size':size,
            'filterSelectID':filterSelectID,
            'sortby':sortby,
            'min_price':MinPrice,
            'max_price':MaxPrice,
            'rangePrice':[MinPrice,MaxPrice],
            'image_size':[180,null]

        },
        success:function (data) {
            // console.log(data);
            app.listel=data['goods'];
            app.count_pages=data['count_pages'];
            app.current_page=data['current_page'];
            vm.count_pages= app.count_pages;
            aside.property=data['property'];
            aside.filters=data['filters'];
            $('#load_gif').css('display','none');



            var urlParam={
                //'rangePrice':[MinPrice,MaxPrice],

            };


            MinPrice>0?urlParam['min_price']=MinPrice:0;

            page==1?null:urlParam['page']=page;
            //alert(filterSelectID);
            filterSelectID==null?null:urlParam['filterSelectID']=filterSelectID;


            //urlParam['filterSelectID']=[1];
            size!=20?urlParam['size']=size:null;
            sortby!=null?urlParam['sortby']=sortby:null;

            // console.log(Object.keys(urlParam).length);
            if(Object.keys(urlParam).length>=1){

                var st=jQuery.param(urlParam);
                window.history.pushState(urlParam,'','?'+st);
            }
            /*    $('#range1').data("ionRangeSlider").update({
                    from:MinPrice,
                    to:MaxPrice
                });
*/
            //window.history.pushState(st);
        },
        error:function (data) {
            alert(data.text);
        }
    });
}

////////////PAGINATE////////////////////
var vm=Vue.component('paginate',{
    template:`
            <div class="paginate">

            <a href="#" v-on:click="prev()">
                <div class="point"><<</div>
            </a>

                <a href="#" v-for="i in count_pages" v-on:click="point(i)" >
                    <div class="point selected" v-if="i==current_page">@{{ i }}</div>
                    <div class="point" v-else>@{{ i }}</div>
                </a>


            <a href="#" v-on:click="next()">
                <div class="point">>></div>
            </a>
        </div>

            `,
    props:['count_pages','current_page'],
    /* data:function () {
         return{
             count_pages: 0,
             current_page:0
         }
     },*/
    methods:{
        next:function () {
            if(page+1<=this.count_pages){
                page++;
                current_page=page;
                getlist();
            }
        },
        prev:function () {
            if(page-1>0){
                page--;
                current_page=page;
                getlist();
            }

        },
        point:function (p) {
            page=p;
            current_page=page;
            getlist();

        },

    }

});
vm.count_pages=1;



/////////////////GOOD//////////////////

Vue.component('item',{
    template:`
            <div class="list_good">
                <good v-for="item in items"
                  :item="item"
                  :key="item.id"></good>
            <h2 v-if="items.length==0">По данным фильтрам товара нет.</h2>
            </div>
            `,
    props:['items'],
    methods:{
        getUrl:function (caturl,url) {
            var url='/catalog/'+caturl+'/'+url;
            return url;
        },
        toCatd:function (caturl,url) {
            window.location=this.getUrl(caturl,url);
        }
    }
});

//console.log(getUrlParam()['rangePrice[]'][0]);

///////////////////FILTERS//////////////////////////////////
var Prop=Vue.component('property',{
    template:`<div>
                    <ul>
                    <li class="range">
                        <span>Цена</span><br>
                        <span>От:</span>
                        <input type="number"  step="0.01"  placeholder="0.01" v-model="minPrice" >
                        <span>До:</span>
                        <input type="number" step="0.01" placeholder="500.00" v-model="maxPrice">
                      </li>
                        <li v-for="item in properyes" >
                     <span> @{{item.name}}</span>
                      <ul>

                      <li v-for="sel in item.selects" >
                                    <input
                                    :id="'f-'+sel.id"
                                    :name="'f-'+sel.id"
                                    type="checkbox"
                                    class="radio"
                                    :value="sel.id"
                                    v-model="filterselect">



                                    <label :for="'f-'+sel.id"> @{{ sel.value }}</label>

                                </li>
                            </ul>
                        </li>

                    </ul>

                    <button v-on:click="filterSet()">Применить</button>

</div>`,
    props:['properyes'],
    data:function () {
        return {
            filterselect:filterSelectID,
            minPrice:MinPrice,
            maxPrice:MaxPrice
            // Price:MinPrice+';'+MaxPrice
        }
    },
    methods:{
        filterSet:function () {
            filterSelectID=this.filterselect;

            MinPrice=this.minPrice;
            MaxPrice=this.maxPrice;


            page=1;
            getlist();
        }
    }
});

var aside=new Vue({
    el:'#aside',

    data:{
        property:{},
        filters:{}
    }
})



var app= new Vue({
    el:'#catalog',
    component:{
        good:good
    },
    data:{
        listel:list,
        count_pages:1,
        current_page:1

    },
    created:function () {






    },
    methods:{
        sortby:function (reload=false) {

            sortby=$('select#sortby').val();
            if(reload==true){
                page=1;
                current_page=1;

                getlist();
            }

        },
        sizeL:function () {

            size=$('select#size').val();
            page=1;
            current_page=1;
            getlist();

        },

    }
});

getlist();