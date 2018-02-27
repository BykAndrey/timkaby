<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\FilterCategory;
use App\FilterSelect;
use App\PropertyCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use Mockery\Exception;

class FilterCategoryController extends BaseAdminController
{
    public function createbyprop($id,Request $request){
        $this->data['property']=PropertyCategory::where('id',$id)->first();
        $this->data['category']=Category::where('id',$this->data['property']->id_good_category)->first();

        return view('admin.createObjects.filtercategory',$this->data);
    }


    public function create(Request $request){
        $new=new FilterCategory();
        $new->id_good_property_category=$request->input('id_good_property_category');
        $new->name=$request->input('name');
        $new->save();
        return redirect(route('admin::good_property_category_edit',['id'=> $new->id_good_property_category]));

    }


    public function edit($id,Request $request){
        if($request->isMethod('post')){
            $filter=FilterCategory::where('id',$id)->first();
            $filter->id_good_property_category=$request->input('id_good_property_category');
            $filter->name=$request->input('name');
            $filter->save();
            //echo  $id.'    '.$filter->id_good_property_category;
            return redirect(route('admin::good_property_category_edit',['id'=> $filter->id_good_property_category]));
        }
    }


    public function delete($id,Request $request){
        $filter=FilterCategory::where('id',$id)->first();
        if($filter){
            $prop_id= $filter->id_good_property_category;
            $filter->delete();
            return redirect(route('admin::good_property_category_edit',['id'=> $prop_id]));
        }else{
            return 'Error';
        }
    }

    /* AJAX отдает список значений для фильтра*/
    public function  getListFilterSelect($id,Request $request){
        $list=FilterSelect::where('id_good_filter_category',$id)->get();
        return $list;
    }
    /* Удаляет значение фильтра */
    public function deleteFilterSelectItem($id,Request $request){
        $select=FilterSelect::where('id',$id)->first();
        if($select){
            $select->delete();
            return 1;
        }
        return 0;
    }


    /*Добавляет значение к фильтру*/

    public function addFilterSelectItem(Request $request){
        $id_filter=$request->input('id_filter');
        $value=$request->input('value');
        $filter=FilterCategory::where('id',$id_filter)->first();

        if($filter!=null){
            $new=new FilterSelect();
            $new->id_good_filter_category=$id_filter;
            $new->value=$value;
            $new->save();
            return 1;
        }
        return 0;
    }
    public function saveFilterSelectList(Request $request){
            $list=$request->input('list');
            try{
                foreach ($list as $item) {
                    $val=FilterSelect::where('id',$item['id'])->first();
                    if($val!=null){
                        $val->value=$item['value'];
                        $val->save();
                    }

                }
                return 1;
            }
            catch (Exception $ex){
                return $ex.msg;

        }
    }

}
