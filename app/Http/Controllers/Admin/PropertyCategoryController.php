<?php

namespace App\Http\Controllers\Admin;

use App\FilterCategory;
use App\PropertyCategory;
use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests;

class PropertyCategoryController extends BaseAdminController
{
    public  function create(Request $request){
        if($request->isMethod('get')){

        }

        if($request->isMethod('post')){
            $new =new \App\PropertyCategory();
            $new->id_good_category=$request->input('id_good_category');
            $new->name=$request->input('name');
            $new->save();
           return ['name'=>$new->name,'id'=>$new->id,'id_good_category'=>$new->id_good_category];
           // return \App\PropertyCategory::where('id_good_category',$new->id_good_category)->get();
        }
    }

    public  function edit($id,Request $request){
        if($request->isMethod('get')){
            $cat=Category::admin_getListobject_select();
            $select_cat=[];
            foreach ($cat as $i){
                if($i->id_parent>0)
                    $i->is_active ? $select_cat[$i->id]=$i->name." - Активная": $select_cat[$i->id]=$i->name." - Не активная";
            }
            $this->data['category_list']=$select_cat;
            $model=PropertyCategory::where('id',$id)->first();
            $this->data['model']=$model;
            $this->data['filter']=FilterCategory::where('id_good_property_category',$id)->first();

            $cat=Category::where('id',$model->id_good_category)->first()->name;
            $this->addBreadCrumbls('Категории',route('admin::good_category'));
            $this->addBreadCrumbls($cat,route('admin::good_category_edit',['id'=>$model->id_good_category]));
            $this->addBreadCrumbls('Свойства',route('admin::good_category_edit',['id'=>$model->id_good_category]).'#property');
            $this->addBreadCrumbls($model->name,route('admin::good_property_category_edit',['id'=>$model->id]));

            return view('admin.editObjects.propertycategory',$this->data);
        }
        if($request->isMethod('post')){
                $prop=PropertyCategory::where('id',$id)->first();
                $prop->id_good_category=$request->input('id_good_category');
                $prop->name=$request->input('name');
                $prop->save();
        }


    }

    public function delete($id){
        $a=PropertyCategory::where('id',$id)->first();
        $b=0;
        ($a->delete())?$b=1:$b=0;
        return $b;
    }

    public function getList($id){
        return \App\PropertyCategory::where('id_good_category',$id)->get();
    }
}
