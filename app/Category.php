<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Cache;
class Category extends Model
{
    protected $table="good_category";

   // public static function admin_getListobject($from=0,$to=3){
    public static function admin_getListobject($ar=array('from'=>0,'to'=>3)){
        $from=$ar['from'];
        $to=$ar['to'];
        $sortby=$ar['sortby'];
        $sortMethod=$ar['sortMethod'];




        return DB::select(DB::raw('select * from (SELECT good_category.*,
                                  cat.name as parent_name 
                                  from good_category 
                                  inner join good_category as cat 
                                  on cat.id=good_category.id_parent
                                  union 
                                  SELECT *, good_category.id_parent as parent_name 
                                  FROM good_category 
                                  WHERE id_parent=0) as category'.' ORDER BY '.$sortby.' '.$sortMethod.'  limit '.$from.','.$to));
#SELECT good_category.*, cat.name as parent_name from good_category
        #  inner join good_category as cat on cat.id=good_category.id_parent
    }
    public static  function  admin_getListobject_select($where=''){
        if($where!=''){
            return DB::select(DB::raw('select id, name, is_active,id_parent from good_category where '.$where));
        }
        return DB::select(DB::raw('select id, name, is_active,id_parent from good_category '));
    }




    /*BaseContoller*/
    public static function getActiveCategoryWithSubCat(){
       /* $B_c=Cache::remember('categories', 60, function() {
           return  Category::where('is_active',1)->where('id_parent',0)->get();
        });
*/$B_c =Category::where('is_active',1)->where('id_parent',0)->get();
        foreach ($B_c as $item) {
            $item['subcat']=Category::where('is_active',1)->where('id_parent',$item->id)->get();
        }
        return $B_c;
    }




    /*GET ITEMS FORM ALL SUBCATEGORY*/
    public static function getItemsParentCategory($id,$where=''){
        return DB::select(DB::raw('SELECT item.*,
 (item.price-(item.discount*item.price)/100) as price,
 item.price as old_price, cat.url as caturl FROM good_item as item
inner join good_item_group as itemg on itemg.id=item.id_good_item_group
inner join good_category as cat on cat.id=itemg.id_good_category

where cat.id_parent='.$id.' and item.is_active=1 and cat.is_active=1  '.$where));
    }






}
