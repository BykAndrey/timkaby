<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\FilterItem;
use App\FilterSelect;
use App\Item;
use App\ItemGroup;
use App\PropertyCategory;
use App\PropertyItem;
use Illuminate\Http\Request;

use App\Http\Requests;
use Mockery\Exception;

class PropertyItemController extends BaseAdminController
{

    /*ajax function*/

    public function getJsonData(Request $request){

        if($request->has('action')){

            $action=$request->input('action');
            switch ($action){
                //-------------------------------------------------------
                case 'getlistpropertyitem':

                    $id=$request->input('id');
                    $item=Item::where('id',$id)->first();
                    if($item!=null){
                        $listProp=PropertyItem::getListProperty($item->id);
                       //echo json_encode($listProp);
                        //echo '<br>';
                        foreach ($listProp as $i){
                            $i->select=FilterSelect::getSelectFilter($i->cat_id);
                        }
                        return $listProp;
                    }


                    break;
//---------------------------------------------------


//--------------------------------------------------
                case 'getlist':

                    $id=$request->input('id');
                    $item=Item::where('id',$id)->first();
                    $itemG=ItemGroup::where('id',$item->id_good_item_group)->first();
                    if($itemG){

                        $listProp=PropertyCategory::where('id_good_category',$itemG->id_good_category)->get();

                        foreach ($listProp as $item){
                            $item['select']=FilterSelect::getSelectFilter($item->id);
                        }
                        return $listProp;

                    }
                    else{
                        return 'error';
                    }

                    break;
//-------------------------------------------------
            //---------------------------------------

                case 'createPropertyItem':
                    $id_good_property_category=$request->input('id_good_property_category');
                    $id_item=$request->input('id_item');
                    $value=$request->input('value');

                    $propItem=new PropertyItem();
                    $propItem->value=$value;
                    $propItem->id_good_property_category=$id_good_property_category;
                    $propItem->id_good_item=$id_item;
                    $propItem->save();

                    if($request->input('id_filter_select')!=0){
                        $filter_item=new FilterItem();
                        $filter_item->id_good_property_item=$propItem->id;
                        $filter_item->id_good_filter_select=$request->input('id_filter_select');
                        $filter_item->save();
                    }
                    return 1;
                    break;
                case 'savePropertyItem':
        try{
            $propItem=PropertyItem::where('id',$request->input('id'))->first();

            $propItem->value=$request->input('value');

            $propItem->id_good_property_category=$request->input('cat_id');

            $propItem->save();

            if($request->input('filter_select_id')==0){
                $filter=FilterItem::where('id_good_property_item',$propItem->id)->first()->delete();

            }else{
                $filter=FilterItem::where('id_good_property_item',$propItem->id)->first();
                if($filter==null){
                    $filter=new FilterItem();
                    $filter->id_good_property_item=$propItem->id;
                    $filter->id_good_filter_select=$request->input('filter_select_id');
                    $filter->save();
                }else{
                    $filter->id_good_filter_select=$request->input('filter_select_id');
                    $filter->save();
                }

            }
            return 1;
        }
                catch (Exception $ex){
                            return 'Error (savePropertyItem)';
                }
                    break;



                case 'deletePropertyItem':
                    $propItem=PropertyItem::where('id',$request->input('id'))->first()->delete();
                    return 1;
                    break;
            }
        }
    }
}


