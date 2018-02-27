
<h5>Добавить свойство к товару</h5>


<div id="addProp">
     <table class="list">
        <tr>
           <td>
               <span>Выбирете свойство</span>
           </td>

            <td>
                <span>Выбирете свойство</span>
            </td>
            <td>
                <span>Значение фильтра при котором будет выдаватся этот товар</span>
            </td>
            <td>

            </td>
        </tr>
        <tr>
            <td>
                <select v-model="idpropcategory" name="" id="idpropcategory" v-on:change="fSel()">
                    <option disabled value="">Выберите один из вариантов</option>
                    <option v-for="item in list" v-bind:value="item.id">{{ item.name }}</option>
                </select>
            </td>
            <td>
                <input v-model="propvalue" type="text">
            </td>
            <td>
                <select  v-model="idfilterselect" name="" id="idfilterselect">
                    <option selected="selected" value="0">Нет фильтра</option>
                    <option v-for="item in filterselect" v-bind:value="item.id">{{ item.value }}</option>
                </select>
            </td>
            <td>
                <button v-if="idpropcategory>0"  v-on:click="add()">Добавить свойство</button>
            </td>
        </tr>


        <tr v-for="(item,index) in properties">
            <td>

                <select v-model="item.cat_id" v-bind:value="item.cat_id" v-on:change="propSel(item.id)">

                    <option v-for="el in list"   v-bind:value="el.id">{{ el.name }}</option>
                </select>
                {{ item.cat_id }}
            </td>
            <td>
                <input type="text" v-model="item.value">
                {{ item.value }}
            </td>
            <td>

                <select  v-model="item.filter_select_id" v-bind:value="item.filter_select_id">
                    <option  value="0">Выберите один из вариантов</option>
                    <option v-for="el in item.select"  v-bind:value="el.id">{{ el.value }}</option>
                </select>
                {{ item.filter_select_id}}
            </td>
            <td>
                <span v-on:click="saveEl(item.id)">Сохранить</span>
            </td>
            <td>
                <span v-on:click="deleteProp(item.id)">Удалить</span>
            </td>
        </tr>





    </table>
</div>
<script>
        var listOfPropertyCategory={0:{'id':0,'name':'Неизвестная ошибка'}};
        var FSelect={};
        function refresh_list_prop() {


            $.ajax({
                url:'/admin/properyitem/json',
                async:false,
                data:{
                    'id':$('#id_good_item').val(),
                    'action':'getlist',
                },
                success:function (data) {

                    apps.list=data;

                }
            });

            console.log(1);
            $.ajax({
                url:'/admin/properyitem/json',
                async:false,
                data:{
                    'id':$('#id_good_item').val(),
                    'action':'getlistpropertyitem',
                },
                success:function (data) {

                    apps.properties=data;
                    console.log( apps.properties[0]);
                },
                error:function (data) {
                    console.log(data);
                }
            });

            console.log(2);
        }


        var apps=new Vue({
            el:'#addProp',
            data:{
                list:listOfPropertyCategory,
                properties:{},
                filterselect:FSelect,
                idpropcategory:0,
                idfilterselect:0,
                propvalue:'',
            },
            methods:{
                add:function () {
                    /*alert('idPropCat='+this.idpropcategory+ '\n idItem=' +$('#id_good_item').val()+
                        ' \n Propvalue='+this.propvalue+'\n IdFilterSel='+this.idfilterselect);*/
                    this.properties={};
                    $.ajax({
                        url:'/admin/properyitem/json',

                        data:{'action':'createPropertyItem',
                            'id_good_property_category':this.idpropcategory,
                                'id_item':$('#id_good_item').val(),
                            'value':this.propvalue,
                            'id_filter_select':this.idfilterselect
                        },
                        success:function (data) {
                            if(data==1){

                                ShowMessage(message="Успешно добавлено");
                            }else{
                                ShowMessage(message="Ошибка",type="error");
                            }
                        }
                    });
                    refresh_list_prop();
                },
                fSel:function () {
                    console.log(this.idpropcategory);
                    for(var i=0;i<this.list.length;i++){
                        if(this.list[i]['id']==this.idpropcategory){
                                this.filterselect=this.list[i]['select'];
                            break;
                        }
                    }

                },
                propSel:function(id){

                    for(var i=0;i<this.properties.length;i++){
                        console.log(2);
                        if(this.properties[i]['id']==id){

                            for(var j=0;j<this.list.length;j++){
                                if(this.properties[i]['cat_id']==this.list[j]['id']){
                                    this.properties[i]['select']=this.list[j]['select'];
                                    this.properties[i]['filter_select_id']=0;
                                }
                            }

                        }else{
                            continue;
                        }
                    }
                },
                saveEl:function (id) {
                    console.log(1);
                    for(var i=0;i<this.properties.length;i++){
                        console.log(id);
                        if(this.properties[i]['id']==id){
                            console.log('id='+id);
                            console.log('cat_id='+this.properties[i]['cat_id']);
                            console.log('id='+id);
                            console.log('id='+this.properties[i]['value']);
                            if(this.properties[i]['value'].length>0){
                                $.ajax({
                                    url:'/admin/properyitem/json',
                                    data:{
                                        'action':'savePropertyItem',
                                        'id':this.properties[i]['id'],
                                        'cat_id':this.properties[i]['cat_id'],
                                        'value':this.properties[i]['value'],
                                        'filter_select_id':this.properties[i]['filter_select_id'],
                                    },
                                    success:function (data) {
                                        if(data==1){
                                            ShowMessage();
                                            refresh_list_prop();
                                        }else{
                                            ShowMessage(message=data,type="error");
                                        }

                                    },
                                    error:function (xhr, status, error) {

                                        alert(xhr.responseText );
                                        ShowMessage(message=error,type="error");
                                    }
                                });
                            }else{
                                ShowMessage(message='Заполните данные правильно',type="error");
                            }


                        }
                    }
                },
                deleteProp:function (id) {
                    $.ajax({
                        url:'/admin/properyitem/json',
                        data:{
                            'action':'deletePropertyItem',
                            'id':id
                        },
                        success:function (data) {
                            if(data==1){
                                ShowMessage(message="Успешно удалено");

                            }else{
                                ShowMessage(message=data,type="error");
                            }
                        },
                        error:function (xhr, status, error) {

                            alert(xhr.responseText );
                            ShowMessage(message=error,type="error");
                        }


                    });
                    refresh_list_prop();
                }
            }
        });

        refresh_list_prop();
</script>