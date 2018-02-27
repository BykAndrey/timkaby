<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PropertyItem extends Model
{
    protected $table="good_property_item";
    public static function getListProperty($id){
        return DB::select(DB::raw('SELECT itemprop.id,catprop.id as cat_id, itemprop.value, filtersel.id as filter_select_id from good_property_item as itemprop inner join good_property_category as catprop on catprop.id=itemprop.id_good_property_category left JOIN good_filter_item as filteritem on filteritem.id_good_property_item=itemprop.id left JOIN good_filter_select as filtersel on filtersel.id=filteritem.id_good_filter_select where itemprop.id_good_item='.$id));
    }
}
