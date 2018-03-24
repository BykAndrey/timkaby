
<h5>Добавить свойство</h5>
<div id="PROP">
<form id="good_property_category_create" method="post" action="{{route('admin::good_property_category_create')}}">
    {{csrf_field()}}
    <input type="hidden" name="id_good_category" value="{{$model->id}}">
    <label for="name">Название свойства</label>
    <br>
    От 3 символов:<input type="text" name="name" v-model="name">
    <input type="submit" value="Добавить свойство" v-on:click="addProp($event)">

</form>
    <button v-on:click="reloadList">Обновить список</button>


<h5 id="refresh">Таблица свойств и фильтров</h5>
<table id="listProperty">
    <caption><th>Название свойства</th><th>Название фильтра</th><th>Фильтры</th><th>Удалить</th><th>Редактировать</th></caption>

      <tr v-for="item in listProp">
          <td>
              @{{item.name}}
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>    <a id="action_remove" :href="'/admin/properycategory/delete/'+item.id">Удалить</a> </td>
          <td>    <a :href="'/admin/properycategory/edit/'+item.id">Редактировать</a> </td>
      </tr>

</table>
</div>
<script>
    var prop=new Vue({
        el:'#PROP',
        data:{
            name:'',
            id_category:{{$model->id}},
            listProp:[],
            token:'{{csrf_token()}}'
        },
        created:function () {
            this.reloadList();
        },
        methods:{
            addProp:function (event) {
                event.preventDefault();
                if(this.name.length>=3){
                    console.log(prop.name);
                    console.log(prop.id_category);

                    console.log(prop.token);
                    $.ajax({
                        url:'{{route('admin::good_property_category_create')}}',
                        method:'post',
                        async:false,
                        data:{
                            'name':prop.name,
                            '_token':prop.token,
                            'id_good_category':prop.id_category},
                        success: function (data) {
                          //  alert(1);
                            // $('#template').tmpl(data).appendTo('#listProperty');


                        },
                        error:function (data) {
                            alert(2);
                        }
                    });
                }
                this.reloadList();
            },
            reloadList:function () {
                console.log('start reload');
                $.ajax({
                    url:'/admin/properycategory/getlist/'+this.id_category,
                    method:'get',
                    data:{'id':this.id_category},
                    dataType:'json',
                    success: function (data) {
                        console.log(data)
                        prop.listProp=data;

                    },
                    error:function(data){
                        console.log('Error Reload');
                    }
                    });
                console.log('finish reload');
                }
        }

    })
</script>


<script id="template" type="text/x-jQuery-tmpl">
   <tr>
       <td>
           ${name}
    </td>
    <td>

    </td>
    <td>

    </td>
    <td>    <a id="action_remove" href="/admin/properycategory/delete/${id}">Удалить</a> </td>
        <td>    <a href="/admin/properycategory/edit/${id}">Редактировать</a> </td>
</tr>
</script>