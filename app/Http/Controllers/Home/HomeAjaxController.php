<?php

namespace App\Http\Controllers\Home;
use App\Category;
use App\Comment;
use App\FilterCategory;
use App\FilterSelect;
use App\Http\Controllers\Controller;
use App\Item;
use App\ItemGroup;
use App\Like_Good_Item;
use App\PropertyCategory;
use App\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Mockery\Matcher\Type;

class HomeAjaxController extends BaseHomeController
{
    /*
     * action=''
     * parametrs
     *
     * */
    /**
     * @param Request $request
     * @return array
     */
    public function action(Request $request){

        $action='';
        if($request->has('action')){
            $action=$request->input('action');
        }
        if($request->ajax())
        switch ($action){
            case 'getListItemGroup_Catalog':
                $FilterSelectID=null;
                if($request->input('filterSelectID')!=''){
                    $FilterSelectID=$request->input('filterSelectID');
                }



                $catUrl=$request->input('url');

                $page=1;

                if($request->has('page')){
                    $page=$request->input('page');
                }

                $size=2;

                if($request->has('size')){
                    $size=$request->input('size');
                }
                $sortby=1;
                if( $request->has('sortby')){
                    $sortby=$request->input('sortby');
                }
                $rangePrice=[0.01,5000.00];
                if( $request->has('rangePrice')){
                    $rangePrice=$request->input('rangePrice');
                }
                $ORDER_BY='ORDER BY';
                switch ($sortby){
                    case 1:
                        $ORDER_BY.=' price DESC';
                        break;
                    case 2:
                        $ORDER_BY.=' price ASC';
                        break;

                }

                $cat=Category::where('url',$catUrl)->first();

                $count1=0;
                $a=0;
                $property=[];
                $filters=[];
                $where='and item.price between '.$rangePrice[0].' and '.$rangePrice[1];
                if($cat->id_parent==0){
                    global  $count1;
                    /*$count1=ItemGroup::getListItemGroup_Catalog_id_base(
                        $id=$cat->id,
                        $page=$page ,
                        $size=$size,
                        $where=" ",
                        $count=true)[0]->count;*/
                    $count1=ItemGroup::getListItemGroup_Catalog_id_base(
                        array(
                            'id'=>$cat->id,
                            'page'=>$page,
                            'size'=>$size,
                            'where'=>$where,
                            'count'=>true,
                            'sortby'=>$ORDER_BY,
                            'price'=>$rangePrice,
                        ))[0]->count;

                //    $list=ItemGroup::getListItemGroup_Catalog_id_base($id=$cat->id,$page=$page ,$size=$size);
                    $list=ItemGroup::getListItemGroup_Catalog_id_base(
                        array(
                            'id'=>$cat->id,
                            'page'=>$page,
                            'size'=>$size,
                            'where'=>$where,
                            'count'=>false,
                            'sortby'=>$ORDER_BY,
                            'price'=>$rangePrice,
                        )
                    );

                }else{


                    /*
                     * Пример $where
                     * так применяются фильтры
                     *
                     *  and fi.id_good_filter_select in (1,2,7,5)
                     * */
                    $where='';
                    global  $count1;
                   /* $count1=ItemGroup::getListItemGroup_Catalog(
                        $id=$cat->id,
                        $page,
                        $page,
                        $fi=$FilterSelectID,
                        $count=true);*/
                    $count1=ItemGroup::getListItemGroup_Catalog(array(
                        'id'=>$cat->id,
                        'page'=>$page,
                        'size'=>$page,
                        'fi'=>$FilterSelectID,
                        'count'=>true,
                        'price'=>$rangePrice,
                        'sortby'=>"ORDER BY price ASC"
                    ));
                    /*$list=ItemGroup::getListItemGroup_Catalog(
                        $cat->id,
                        $page,
                        $size,
                        $fi=$FilterSelectID,
                        $count=false,
                        $sortby=$ORDER_BY);*/

                    $list=ItemGroup::getListItemGroup_Catalog(array(
                        'id'=>$cat->id,
                        'page'=>$page,
                        'size'=>$size,
                        'fi'=>$FilterSelectID,
                        'count'=>false,
                        'price'=>$rangePrice,
                        'sortby'=>$ORDER_BY
                    ));


                    $property=PropertyCategory::where('id_good_category',$cat->id)->get();

                        foreach ($property as $item){
                            $f=FilterCategory::where('id_good_property_category',$item->id)->first();
                            if($f!=null){
                                $f->selects=FilterSelect::where('id_good_filter_category',$f->id)->get();
                                $filters[]=$f;
                            }
                        }

                }


                $count_pages=ceil($count1/$size);
                if($count_pages<1){
                    $count_pages=1;
                }


                /*Изменение пути картинки и подгонка размера с помощью  intervention */

                $image_size=$request->input('image_size');

                foreach ($list as $item) {
                    $item->image=ItemGroup::getImage($item->image,$image_size[0],$image_size[1]);
                }






                if($request->ajax()){
                    return [
                        'goods'=>$list,
                        'count_pages'=>$count_pages,
                        'current_page'=>$page,
                        'property'=>$property,
                        'filters'=>$filters,
                        'filterSelectId'=>$FilterSelectID
                    ];
                }else{
                    return view('home.catalog',$this->data);
                }

                break;



            case 'search':
                    $id_category=$request->input('id_category');
                    $wht=$request->input('what_search');
                    $page=1;
                    if($request->has('page')){
                        $page=$request->input('page');
                    }

                    $page--;



                    $ORDER_BY=['good_item.price','desc'];
                    if($request->has('sortby')){
                        global $ORDER_BY;
                        switch ($request->input('sortby')){
                            case 1:
                                global $ORDER_BY;
                                $ORDER_BY=['good_item.price','desc'];
                                break;
                            case 2:
                                global $ORDER_BY;
                                $ORDER_BY=['good_item.price','asc'];
                                break;
                        }
                    }
                $only_discount=false;
                    $dis=-1;
                if($request->has('only_discount')){
                    $only_discount=$request->input('only_discount');
                    $dis=0;
                }


                       // echo $only_discount;
                    if($request->has('size')){
                       // return BaseHomeController::search($id_category,$wht,$request->input('size'));

                        return ['goods'=>BaseHomeController::search([
                            'id_category'=>$id_category,
                            'wht'=>$wht,
                            'size'=>$request->input('size'),
                            'order_by'=>$ORDER_BY,
                            'only_discount'=>$only_discount,
                            'page'=>$page
                        ]),
                            'max_page'=>ceil(Item::where('name','like','%'.$wht.'%')
                                    ->where('is_active','1')
                                    ->where('discount','>',$dis)->count()/16),
                            'current_page'=>$page+1];
                    }else{
                        return ['goods'=>BaseHomeController::search([
                            'id_category'=>$id_category,
                            'wht'=>$wht,
                            'size'=>[50,null],
                            'order_by'=>$ORDER_BY,
                            'only_discount'=>$only_discount,
                            'page'=>$page
                        ]),
                            'max_page'=>ceil(Item::where('name','like','%'.$wht.'%')
                                    ->where('is_active','1')
                                    ->where('discount','>',$dis)->count()/16),
                            'current_page'=>$page+1
                        ];
                    }

                break;
            case 'addToFavorite':
                $id=intval($request->input('id'));
                $id_user=Auth::id();
                $user=User::find($id_user);
                $item=Item::find($id);

                if($item!=null and $user!=null){
                    $same=Like_Good_Item::where('id_good_item',$item->id)
                        ->where('id_user',$user->id)
                        ->count();

                    if($same==0){
                        $likegood=new Like_Good_Item();
                        $likegood->id_good_item=$item->id;
                        $likegood->id_user=$user->id;
                        $likegood->save();
                        return 1;
                    }else{
                        return 0;

                    }
                }

                return -1;
                break;




            case 'removeFromFavorite':
                $id=intval($request->input('id'));
                $id_user=Auth::id();
                $user=User::find($id_user);
                $item=Item::find($id);

                if($item!=null and $user!=null){
                    $same=Like_Good_Item::where('id_good_item',$item->id)
                        ->where('id_user',$user->id)
                        ->first();

                    if($same!=null){
                        $same->delete();
                        return redirect(route('user::like-good'));
                    }
                    return redirect(route('user::like-good'));
                }

                return redirect(route('user::like-good'));

                break;




            case 'addcomment':
                $id_item=intval($request->input('id_item'));
                $rating=intval($request->input('rating'));
                $comment=htmlspecialchars($request->input('comment'));

                $id_user=Auth::id();

                if($id_user!=null and $id_item!=null and $rating!=null){
                    if(Comment::where('id_good_item',$id_item)->where('id_user',$id_user)->first()==null){
                        $new=new Comment();
                        $new->id_user=$id_user;
                        $new->id_good_item=$id_item;
                        $new->rating=$rating;
                        $new->comment=$comment;
                        $new->is_active=0;
                        $new->is_new=1;
                        $new->save();
                        return 1;
                    }

                }

                return 0;
                break;
            case 'getcomments':
                $id_item=intval($request->input('id_item'));
                $item=Item::find($id_item);
                if($item!=null){
                    $page=intval($request->input('page'));
                    if($page==null or $page<0)
                        $page=1;
                    $page-=1;
                    $size=5;
                    $comments=DB::table('item_comment')
                        ->join('users','users.id','=','item_comment.id_user')
                        ->select('item_comment.comment','item_comment.rating','users.name as user','item_comment.created_at')
                        ->where('item_comment.id_good_item',$item->id)
                        ->where('item_comment.is_active',1)
                        ->orderBy('item_comment.created_at','desc')
                        ->skip($page*$size)
                        ->take($size)
                        ->get();
                    return $comments;
                }

                break;
            case 'getAuthUser':

                $id =Auth::id();
                if($id!=null){
                    $user=User::select('name','phone','adress','feature')->find($id);
                    if($user!=null){
                        return $user;
                    }

                }
                return new User();
                break;
        }
    }
}
