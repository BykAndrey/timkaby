<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;


class ItemGroup extends Model
{
    protected $table="good_item_group";


    /*Возращает картинку ужимая по высоте или ширине*/
    public static function getImage($src,$width,$height,$path='static/imagesItem'){
        try{

            $newname=$path.'/'.$src;
            if(!file_exists($newname)){
                return 'static/img/imagenot.gif';
            }
        if($src!=null){
            if($width==null and $height==null){
                $newname=$path.'/'.$src;
                if(!file_exists($newname)){
                    return $newname;
                }

            }
            if($width!=null or $height!=null){
                $name=$src;
                $size=[$width,$height];
                $ar=explode('.',$name);
                $newname=$path.'/'.$ar[0].'_'.$size[0].'_'.$size[1].'.'.$ar[1];

                if(!file_exists($newname)){
                    $img = Image::make($path.'/'.$name)->resize($size[0], $size[1],function ($constraint){
                        $constraint->aspectRatio();

                    })->save($newname);



                    return $newname;
                }else{

                    return $newname;
                }
            }else{
                return $path.'/'.$src;
            }
        }
        else{
            return 'static/img/imagenot.gif';
        }
        }
        catch (Exception $ex){
            return 'static/img/imagenot.gif';
        }
    }








    public  static function admin_getList($ar=array()){
        $query='select good_item_group.*, good_category.name as category_name from good_item_group
inner join good_category on good_category.id= good_item_group.id_good_category';

        $where=false;
        if(isset($ar['provider'])){

            if($ar['provider']!=0){
                $query.=' where id_provider = '.$ar['provider'];
                global  $where;
                $where=true;
            }
        }


        if(isset($ar['brand'])){
            if($ar['brand']!=0){

                if ($where==false){
                    $query.=' where ';
                }else{
                    $query.=' and ';
                }
                $query.=' id_brand = '.$ar['brand'];


                $where=true;
            }
        }


        if(isset($ar['category'])){
            if($ar['category']!=0){

                if ($where==false){
                    $query.=' where ';
                }else{
                    $query.=' and ';
                }
                $query.=' id_good_category = '.$ar['category'];


                $where=true;
            }
        }



        if(isset($ar['from']) and isset($ar['to'])){
            $query.=' ORDER BY updated_at desc LIMIT '.$ar['from'].' ,'.$ar['to'];
        }


        //echo $query;
        return DB::select(DB::raw($query));
    }


    public static function  getListItemGroup_Catalog($ar=array('sortby'=>"ORDER BY price ASC")){
        $id=$ar['id'];
        $page=$ar['page'];
        $size=$ar['size'];
        $fi=$ar['fi'];
        $rangePrice=$ar['price'];

        $count=$ar['count'];
        $sortby=$ar['sortby'];

        $list=[];
        if($fi!=null)
            //echo json_decode($fi);
        foreach ($fi as $i){
            $filterselect=FilterSelect::where('id',$i)->first();
            $key=$filterselect->id_good_filter_category;
            if(array_key_exists($key,$list)){
                $list[$key][]=$i;
            }else{
                $list[$key]=[];
                $list[$key][]=$i;
            }
        }
        //echo  json_encode($list);
        if($count==false){
            $page--;
            $sqlRequest='SELECT good_item.id,
                          good_item.name,
                          good_item.url,
                          good_item.discount,
                  (good_item.price-(good_item.price*good_item.discount)/100) as price,
                  good_item.image, good_item.rating,good_item.price as old_price,
                  cat.url as caturl from good_item
                inner join good_item_group on good_item_group.id=good_item.id_good_item_group
                inner join good_category as cat on cat.id=good_item_group.id_good_category ';
            $index=0;
            if($list!=null)
            foreach ($list as $i){

                $filter=str_replace(array("[","]"),array('(',')'),json_encode($i));
                $filter=str_replace('"',' ',$filter);
                $and='';
                /* if ($index!=0){
                     $and=' and ';
                 }else{
                     $and=' where ';
                 }*/
                $index!=0? $and=' and ': $and=' where ';
                $sql=$and.' good_item.id in (SELECT item.id from good_item as item
            inner join good_item_group as itemG on itemG.id=item.id_good_item_group
            inner join good_property_item as itemP on itemP.id_good_item=item.id
            inner join good_filter_item as fi on fi.id_good_property_item=itemP.id
                                        where itemG.id_good_category='.$id.
                    ' and item.is_active=1   and fi.id_good_filter_select in '.$filter.'
                              ) ';
                $sqlRequest=$sqlRequest.$sql;

                $index++;

            }

            count($list)>0? $and=' and ': $and=' where ';
            $sqlRequest=$sqlRequest.' '.$and.'  good_item.id in (SELECT good_item.id from good_item) and good_item_group.id_good_category='.$id.
            ' and good_item.is_active=1 
             having price  >='.
                    $rangePrice[0].' and price <='.$rangePrice[1];
           //echo $sqlRequest;
            //echo json_encode($rangePrice);
            return   DB::select(DB::raw($sqlRequest.' '.$sortby.' LIMIT '.$page*$size.', '.$size));

        }else{
        try{
            $sqlRequest='SELECT COUNT(good_item_group.id) as count  from good_item
                inner join good_item_group on good_item_group.id=good_item.id_good_item_group ';


            $index=0;
            if($list!=null){
                foreach ($list as $i){

                    $filter=str_replace(array("[","]"),array('(',')'),json_encode($i));
                    $filter=str_replace('"',' ',$filter);
                                                         //   $he=null;
                                                      ///$he=  ($index != 0 ? ($he = ' and ') : ($and = ' where '));
                    $index!=0? $and=' and ': $and=' where ';
                    $sql=$and.' good_item.id in (SELECT item.id from good_item as item
            inner join good_item_group as itemG on itemG.id=item.id_good_item_group
            inner join good_property_item as itemP on itemP.id_good_item=item.id
            inner join good_filter_item as fi on fi.id_good_property_item=itemP.id
                                        where itemG.id_good_category='.$id.
                        ' and item.is_active=1  and fi.id_good_filter_select in '.$filter.'
                              ) ';
//echo '<br>'.$sql.'<br>';
                                                        $sqlRequest=$sqlRequest.$sql;

                                                        $index++;

                                    }
                                }
            $and='';

            count($list)>0? $and=' and ': $and=' where ';

            $sqlRequest=$sqlRequest.' '.$and.'  good_item.id in (SELECT good_item.id from good_item) and good_item_group.id_good_category='.$id.
                ' and good_item.is_active=1  
                and good_item.price >= '.
                $rangePrice[0].' and good_item.price <='.$rangePrice[1];
       //     echo $sqlRequest.' GROUP by good_item_group.id';
           // echo $sqlRequest;
            $response=DB::select(DB::raw($sqlRequest.' '));
            if(count($response)!=0){

                return $response[0]->count;
            }

            return 0;
            //return   DB::select(DB::raw($sqlRequest.' GROUP by good_item_group.id'));
        }
        catch (Exception $rx){

        }

        }

    }
    public static function  test($id, $fi,$page=1,$size=1){
        $list=[];
        foreach ($fi as $i){
            $filterselect=FilterSelect::where('id',$i)->first();
            $key=$filterselect->id_good_filter_category;
            if(array_key_exists($key,$list)){
                $list[$key][]=$i;
            }else{
                $list[$key]=[];
                $list[$key][]=$i;
            }
        }
        $sqlRequest='select good_item_group.* from good_item_group  ';
        $index=0;

        foreach ($list as $i){

            $filter=str_replace(array("[","]"),array('(',')'),json_encode($i));
            $and='';
            if ($index!=0){
                $and=' and ';
            }else{
                $and=' where ';
            }
            $sql=$and.' id in (select itemG.id from good_item_group as itemG
                        inner JOIN good_item as item on item.id_good_item_group=itemG.id
                        inner join good_property_item as itemP on itemP.id_good_item=item.id
                        inner join good_filter_item as fi on fi.id_good_property_item=itemP.id
                                        where itemG.id_good_category='.$id.'
                                        and itemG.is_active=1  and fi.id_good_filter_select in '.$filter.'
                              ) ';
            $sqlRequest=$sqlRequest.$sql;

            $index++;

        }

        count($list)>0? $and=' and ': $and=' where ';
        $sqlRequest=$sqlRequest.' '.$and.'  good_item_group.id in (select itemG.id from good_item_group as itemG)';
        return   DB::select(DB::raw($sqlRequest.' GROUP by good_item_group.id LIMIT '.$page*$size.', '.$size));

    }













    public static function getListItemGroup_Catalog_id_base($ar=array('count'=>false,'page'=>1,'size'=>1)){
        $id=$ar['id'];
        $page=$ar['page'];
        $size=$ar['size'];
        $where=$ar['where'];
        $count=$ar['count'];
        $sortby=$ar['sortby'];
       // $rangePrice=$ar['price'];
        $min_price=$ar['min_price']>0?$ar['min_price']:0;
        $max_price=$ar['max_price'];

        $priceQuery='price >='.$min_price;
        if($max_price!=null and $max_price>$min_price){
            $priceQuery.=' and price <='.$max_price;
        }

        if($count==false){
        $page--;


            $query='
                    SELECT item.id,
                          item.name,
                          item.url,
                          item.discount,
                          item.rating,
                  (item.price-(item.price*item.discount)/100) as price,
                  item.image,
                  item.price as old_price,
                  cat.url as caturl FROM good_item as item
                                    inner join good_item_group as itemg on itemg.id=item.id_good_item_group
                                    inner join good_category as cat on cat.id=itemg.id_good_category
                                    where cat.id_parent='.$id.' 
                                    and item.is_active=1 
                                    and cat.is_active=1  '.$where.' '.
                ' having '.$priceQuery.' '.
                $sortby.' LIMIT '.
                $page*$size.', '.$size;



            return DB::select(DB::raw($query));

        }
            else{


                return DB::select(DB::raw('SELECT COUNT(item.id) as count FROM good_item as item
                                    inner join good_item_group as itemg on itemg.id=item.id_good_item_group
                                    inner join good_category as cat on cat.id=itemg.id_good_category
                                    where cat.id_parent='.$id.' 
                                    and item.is_active=1 
                                    and cat.is_active=1  '.$where));
            }
    }

}
/*
 *
 *
 *select  COUNT(good_item_group.id) as count from good_item_group
                                        where id_good_category='.$id.'
                                        and good_item_group.is_active=1
 *
 *
 *
 *
 *
 *
 *
 * select itemG.* from good_item_group as itemG
inner JOIN good_item as item on item.id_good_item_group=itemG.id
inner join good_property_item as itemP on itemP.id_good_item=item.id
inner join good_filter_item as fi on fi.id_good_property_item=itemP.id
where itemG.id_good_category=10 and fi.id_good_filter_select in (1,2,7,5)
 *
 *
 *
 *
 * */









/*
 *
 *
 *
 *
 *
 *
select * from good_item_group
inner join (select itemG.id,itemG.name from good_item_group as itemG
inner JOIN good_item as item on item.id_good_item_group=itemG.id
inner join good_property_item as itemP on itemP.id_good_item=item.id
inner join good_filter_item as fi on fi.id_good_property_item=itemP.id
where itemG.id_good_category=10 and itemG.is_active=1 and fi.id_good_filter_select=1
GROUP by itemG.id)as tabl on tabl.id=good_item_group.id







 public static function  getListItemGroup_Catalog($id,$page=1,$size=1,$where="",$count=false){
        if($count==false){
            $page--;
            return DB::select(DB::raw('select itemG.* from good_item_group as itemG
inner JOIN good_item as item on item.id_good_item_group=itemG.id
inner join good_property_item as itemP on itemP.id_good_item=item.id
inner join good_filter_item as fi on fi.id_good_property_item=itemP.id
                                        where itemG.id_good_category='.$id.'
                                        and itemG.is_active=1 '.$where.'
                                          GROUP by itemG.id LIMIT '.$page*$size.', '.$size));
        }else{

            return DB::select(DB::raw('select count(id) as count  from (select itemG.id from good_item_group as itemG
inner JOIN good_item as item on item.id_good_item_group=itemG.id
inner join good_property_item as itemP on itemP.id_good_item=item.id
inner join good_filter_item as fi on fi.id_good_property_item=itemP.id
where itemG.id_good_category='.$id.'
                                        and itemG.is_active=1 '.$where .' GROUP by itemG.id) as tabl'));
        }

    }














/////////////12.12.2017 12.36
Замена item_group на item
  $page--;
            $sqlRequest='select good_item_group.* from good_item_group ';
            $index=0;
            if($list!=null)
            foreach ($list as $i){

                $filter=str_replace(array("[","]"),array('(',')'),json_encode($i));
                $filter=str_replace('"',' ',$filter);
                $and='';

$index!=0? $and=' and ': $and=' where ';
$sql=$and.' id in (select itemG.id from good_item_group as itemG
inner JOIN good_item as item on item.id_good_item_group=itemG.id
inner join good_property_item as itemP on itemP.id_good_item=item.id
inner join good_filter_item as fi on fi.id_good_property_item=itemP.id
                                        where itemG.id_good_category='.$id.'
                                        and itemG.is_active=1  and fi.id_good_filter_select in '.$filter.'
                              ) ';
$sqlRequest=$sqlRequest.$sql;

$index++;

}

count($list)>0? $and=' and ': $and=' where ';
$sqlRequest=$sqlRequest.' '.$and.'  good_item_group.id in (select itemG.id from good_item_group as itemG)';
echo $sqlRequest.' and good_item_group.id_good_category='.$id.' GROUP by good_item_group.id LIMIT '.$page*$size.', '.$size;
return   DB::select(DB::raw($sqlRequest.' and good_item_group.id_good_category='.$id.' GROUP by good_item_group.id '.$sortby.' LIMIT '.$page*$size.', '.$size));














*/