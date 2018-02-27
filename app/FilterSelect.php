<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class FilterSelect extends Model
{
    protected  $table='good_filter_select';
    public static function getSelectCategory($id){
        return DB::select(DB::raw('SELECT fsel.*, prop.id as id_good_prop FROM `good_filter_select` as fsel
inner join good_filter_category as filter on filter.id= fsel.id_good_filter_category
inner join good_property_category as prop on prop.id= filter.id_good_property_category
WHERE prop.id_good_category='.$id));
    }
    public static function getSelectFilter($id){
        return DB::select(DB::raw('SELECT good_filter_select.id, good_filter_select.value FROM good_filter_select left join good_filter_category on good_filter_category.id=good_filter_select.id_good_filter_category where good_filter_category.id_good_property_category='.$id));
    }

}
