<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Item extends Model
{
    protected $table='good_item';
    public  static function admin_getList(){
        return DB::select(DB::raw('select good_item.*, good_item_group.name as item_group from good_item
inner join good_item_group on good_item_group.id= good_item.id_good_item_group'));
    }

    public static function getPrice($price,$dis){
        return $price-(($price*$dis)/100);
    }

}
