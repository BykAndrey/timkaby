<?php

namespace App\Http\Controllers\Home;
use App\Category;
use App\Http\Controllers\Controller;
use App\InfoPage;
use App\News;
use App\User;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ItemGroup;
use Illuminate\Support\Facades\Mail;

class BaseHomeController extends Controller
{
    public $data=[];
    public function __construct(){

        $this->data['good_category']=Category::getActiveCategoryWithSubCat();
        $this->data['bread_crumbs']=[];

        /* BASE MENU*/

       // $menu=    \App\AdminClass\Register::getMenu();
        $menu=InfoPage::where('is_active',1)->orderBy('weight')->get();

       /* for($i=0; $i<=count($menu)-1;$i++){
            for($j=1; $j<count($menu);$j++){

                if($menu[$i]['weight']>$menu[$j]['weight']){

                    $buf=$menu[$i];
                    $menu[$i]=$menu[$j];
                    $menu[$j]=$buf;
                }
            }
        }
*/
        $this->data['base_menu']=$menu;
        /*END BASE MENU*/



        /*CATEGORIES FOR SEARCHING*/
        $this->data['categories_search']=Category::where('id_parent',0)
            ->where('is_active',1)->get();
        /*END CATEGORIES FOR SEARCHING*/
        $this->addBreadCrumbls('Главная',route('home'));






        /*Get user name if login*/
        $id=Auth::id();

        if($id!=null){
            $user=User::find($id);
            if($user!=null){
                $this->data['user']=$user->email;
            }
            else{
                $this->data['user']=false;
            }
        }else{
            $this->data['user']=false;
        }





        /*Last place*/
        $this->data['last_place']=$this->getLastPlace();

        /*widget news*/

        $this->data['widget_news']=News::where('is_active',1)
            ->where('is_open_admin',null)
            ->orderBy('created_at','DESC')
            ->take(3)
            ->get();




/*

*/

    }



    /*Last place where you were
       */
    public function addLastPlace($id){
        $last_place=array();
        if(!session()->has('last_place')){
            session()->put('last_place',json_encode([]));
        }
        else{
            $last_place=json_decode(session()->get('last_place'),true);
        }

        do {
            $copy=null;

            foreach ($last_place as $key => $i) {
                if ($i == $id) {
                    $copy = $key;
                }
            }

            if ($copy != null) {
                array_splice($last_place, $copy, 1);
            }
        }while($copy!=null);

        $last_place[]=$id;
        session()->put('last_place',json_encode($last_place));
        return $last_place;
    }
    public function getLastPlace(){
        $last_place=[];
        if(!session()->has('last_place')){
            session()->put('last_place',json_encode([]));
        }
        else{
            $last_place=json_decode(session()->get('last_place'),true);
        }
        return $last_place;
    }


    protected function addBreadCrumbls($key,$value){
        $bread=$this->data['bread_crumbs'];
        $bread[$key]=$value;
        $this->data['bread_crumbs']=$bread;
    }


    public static  function search($ar=array()){

        $id_category=$ar['id_category'];
        $wht=$ar['wht'];
        $size=array_key_exists('size',$ar)!=null?$ar['size']:[50,null];
        $order_by=array_key_exists('order_by',$ar)!=null?$ar['order_by']:['good_item.price','desc'];
        $page=$ar['page'];

/*
       $sql='select `good_item`.`name`,
            `good_item`.`discount`,
            `good_item`.`url`,
            `good_item`.`image`,
            `good_item`.`articul`,
            `good_category`.`url` as `caturl`,
            (good_item.price-(good_item.discount*good_item.price)/100) as price
       from `good_item` 
       inner join `good_item_group` on `good_item`.`id_good_item_group` = `good_item_group`.`id` 
       inner join `good_category` on `good_category`.`id` = `good_item_group`.`id_good_category` 
       where (`good_item`.`is_active` = 1 
       and `good_category`.`is_active` = 1 
       ';



        strval($ar['only_discount'])!='true'?:$sql.='and good_item.discount>0';
        $id_category==0?:$sql.='and `good_category`.`id_parent` = '.$id_category;



       $sql.=') 
       and (`good_item`.`name` like "%'.$wht.'%"  or `good_item`.`articul` like "%'.$wht.'%") 
       order by '.$order_by[0].' '.$order_by[1];


//return $sql;
$items=DB::select(DB::raw($sql))->skip($page*10)->take(10)->get();*/
$dis=-1;
        if(strval($ar['only_discount'])=='true') {
            $dis = 0;
        }


        $categ='!=';
        if($id_category!=0){
            $categ='=';
        }
$items=DB::table('good_item')
    ->join('good_item_group','good_item_group.id','=','good_item.id_good_item_group')
    ->join('good_category','good_category.id','=','good_item_group.id_good_category')
    ->select('good_item.name','good_item.discount','good_item.url','good_item.image','good_item.articul','good_category.url as caturl')
    ->selectRaw('(good_item.price-(good_item.discount*good_item.price)/100) as price')
    ->where('good_item.name','like','%'.$wht.'%')
    ->where('good_item.is_active','1')
    ->where('good_item.discount','>',$dis)
    ->where('good_category.id_parent',$categ,$id_category)
    ->orderBy($order_by[0],$order_by[1])
    ->skip($page*16)
    ->take(16)
    ->get();;
/*
if($ar['only_discount']==1){
    $items->where('good_item.discount','>',0);
}
*/


        //$items=$items->get();
        foreach ($items as $item) {
            $item->image=ItemGroup::getImage($item->image,$size[0],$size[1]);
            //$item->name=str_replace($wht,'<b>'.$wht.'</b>',$item->name);
          //  $item->name=$item->name.' '.$item->articul;
            $wht=mb_strtolower($wht);
            $name=mb_strtolower($item->name);
            $pos=stripos($name,$wht);


            if($pos!=null) {
                $subname = substr($item->name, $pos, strlen($wht));
                $item->name = str_replace($subname, '<b>' . $subname . '</b>', $item->name);
            }
        }
        return $items;
    }





}
