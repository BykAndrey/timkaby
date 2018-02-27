<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use Illuminate\Support\Facades\DB;

class PropertyCategory extends Model
{
    protected  $table="good_property_category";

    public static function get_category_property($id){
        $cat =Category::where('id',$id)->first();
        if($cat){
            return DB::select(DB::raw("select prop.* ,count(filter.id) as count_filter from good_property_category as prop left JOIN good_filter_category as filter ON filter.id_good_property_category= prop.id WHERE prop.id_good_category= 3
GROUP by prop.id"));
        }
    }
}

/* SELECT prop.* ,count(filter.id) as count_filter
FROM good_property_category as prop   left JOIN good_filter_category as filter
 ON filter.id_good_property_category= prop.id
WHERE prop.id_good_category= 3
GROUP by prop.id
