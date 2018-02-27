<?php

namespace App\Http\Controllers\Auth;

use App\Item;
use App\ItemGroup;
use App\Like_Good_Item;
use App\Order;
use App\Order_item;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Controllers\Home\BaseHomeController;


class UserController extends BaseHomeController
{
    public function __construct()
    {
        parent::__construct();

    }

    public function profile(Request $request){
        $this->addBreadCrumbls('Профиль',route('user::profile'));
        $this->data['my_orders']=Order::where('id_user',Auth::id())->get();
        $this->data['user_data']=User::find(Auth::id());
        return view('user.profile',$this->data);
    }




    public function changepassword(Request $request){

        if($request->isMethod('get')){
            if(Auth::check()){
                $user=Auth::user();

                $this->data['old_pass_exist']=false;

                if($user->social=='native' or $user->social_pass_changed==1){
                    $this->data['old_pass_exist']=true;
                }

                return view('user.changepassword',$this->data);
            }

        }
        if($request->isMethod('post')){
            if(Auth::check()) {
                $user = Auth::user();

                $val = Validator::make($request->all(),
                    [
                        'old_password' => 'filled|min:6|max:255',
                        'password' => 'required|min:6|max:255|confirmed',
                    ],
                    [
                        'old_password.min' => 'Минимальная длинна Пароля 6 символов',
                        'old_password.max' => 'Максимальная длинна Пароля 255 символов',
                        'old_password.filled' => 'Поле Пароль обязательно для заполнения',

                        'password.min' => 'Минимальная длинна Пароля 6 символов',
                        'password.max' => 'Максимальная длинна Пароля 255 символов',
                        'password.required' => 'Поле Пароль обязательно для заполнения',
                        'password.confirmed' => 'Пароли не совпадают',

                    ]);


                if($user->social=='native' or $user->social_pass_changed==1){

                    $val->after(function($val) {
                        if(array_key_exists('old_password',$val->getData())) {
                        }
                        $old=$val->getData()['old_password'];
                        if (!Hash::check($old,Auth::user()['password'])) {
                            $val->errors()->add('old_password', 'Неверный Старый пароль!');
                        }
                    });
                }



                if ($val->fails()) {

                    return redirect(route('user::changepassword'))
                        ->withErrors($val)
                        ->withInput();
                }



                $user=User::find(Auth::id());
                $user->password=bcrypt($request->input('password'));
                $user->social_pass_changed=1;
                $user->save();
                return view('user.passChanged',$this->data);
            }
            return 1;
        }
    }


    public function listOrders(Request $request){
        $this->addBreadCrumbls('Профиль',route('user::profile'));
        $this->addBreadCrumbls('Заказы',route('user::orders'));
        $page=1;
        if($request->has('page'))
            $page=intval($request->input('page'));

        $count=count(DB::table('order')
            ->where('id_user',Auth::id())
            ->groupBy('order.id')

            ->get());


        $items=DB::table('order')
            ->join('order_item','order_item.id_order','=','order.id')
            ->select('order.id','order.name','order.created_at','order.status','order.total_price','order.id_user','order.adress','order.feature')
            ->selectRaw('SUM(order_item.count) as count')

            ->where('id_user',Auth::id())
            ->groupBy('order.id')
            ->orderBy('order.created_at','desc');

        $page=$page-1;

        $size=5;
        $allpage=ceil($count/$size);

        $this->data['my_orders']=$items->skip($page*$size)->take($size)->get();

        foreach ($this->data['my_orders'] as $item){

        }


        $this->data['current_page']=$page+1;
        $this->data['max_page']=$allpage;
        $this->data['route']='user::orders';
        return view('user.listOrders',$this->data);
    }







    public function allListOrders(Request $request){
        $this->addBreadCrumbls('Профиль',route('user::profile'));
        $this->addBreadCrumbls('Все заказы',route('user::orders'));
        $page=1;
        if($request->has('page'))
            $page=intval($request->input('page'));

        $items=DB::table('order')
            ->join('order_item','order_item.id_order','=','order.id')
            ->select('order.id','order.name','order.created_at','order.status','order.total_price','order.id_user','order.adress','order.feature')
            ->selectRaw('SUM(order_item.count) as count')

            ->groupBy('order.id')
            ->orderBy('order.created_at','desc');

        $page=$page-1;

        $size=5;


        $count=count(DB::table('order')->get());
       // echo  $count;
        $allpage=ceil($count/$size);
        $this->data['my_orders']=$items->skip($page*$size)->take($size)->get();

        foreach ($this->data['my_orders'] as $item){

        }

        $this->data['current_page']=$page+1;
        $this->data['max_page']=$allpage;
        $this->data['route']='user::allorders';
        return view('user.listOrders',$this->data);
    }






    public function  itemsorder($id,Request $request){
        $order=Order::find($id);
        if($order){
            $this->addBreadCrumbls('Профиль',route('user::profile'));
            $this->addBreadCrumbls('Заказ номер '.$order->id,route('user::myorder',['id'=>$order->id]));

            $this->data['order']=$order;
            $items=Order_item::where('id_order',$order->id)->get();
            foreach ($items as $item) {
                $Item_real=Item::where('id',$item->id_item)->first();
                if($Item_real!=null)
                $item->image=ItemGroup::getImage($Item_real->image,120,null);
            }
            $this->data['items']=$items;
            return view ('user.order',$this->data);
        }else{
            return redirect(route('404'));
        }
    }




    public function orderState(Request $request){
        if($request->isMethod('post')){
            $id=intval($request->input('id'));
            $state=$request->input('status');

            $order=Order::find($id);
            if($order!=null){
                $order->status=$state;
                $order->save();
                return redirect(route('user::myorder',['id'=>$id]));
            }else{
               // return redirect(route('404'));
                return 1;
            }

        }
        return 2;
        //return redirect(route('404'));
    }


    /*LIKE GOODS*/
    public function listLikeGood(Request $request){
        $this->addBreadCrumbls('Профиль',route('user::profile'));
        $this->addBreadCrumbls('Понравившиеся товары',route('user::like-good'));
        $size=5;
        $page=1;


        if(!$request->has('page')){
            global $page;
            $page=1;
        }else{
            global $page;
            $page=intval($request->input('page'));
        }


        $count=DB::table('like_good')->where('id_user','=',Auth::id())->count();
        $allpage=ceil($count/$size);



        if($allpage<$page and $allpage!=0){
            return redirect(route('404'));
        }


        $page--;
        $items=DB::table('like_good')
            ->join('good_item','good_item.id','=','like_good.id_good_item')
            ->join('good_item_group','good_item_group.id','=','good_item.id_good_item_group')
            ->join('good_category','good_category.id','=','good_item_group.id_good_category')
            ->select('good_item.id','good_item.name','good_item.image','good_item.rating','good_item.discount')
            ->selectRaw('(good_item.price-(good_item.price*good_item.discount)/100) as price')
            ->selectRaw('CONCAT("/catalog/",good_category.url,"/",good_item.url) as url')
            ->where('id_user','=',Auth::id())
            ->skip($page*$size)
            ->take($size)
            ->get();

        foreach ($items as $item) {
            $item->image = ItemGroup::getImage($item->image, 180, null);
        }

        $this->data['listLikeGoods']=$items;


        $this->data['current_page']=$page+1;
        $this->data['max_page']=$allpage;
        $this->data['paginate_route']='user::like-good';


        return view('user.like_good',$this->data);
    }

    public function ajax(Request $request){
        $action=$request->input('action');

        $user=User::find(Auth::id());


        if($action!=null and $user!=null and $request->isMethod('post')){
            switch ($action){
                case 'save_adress':
                    $user->adress=$request->input('adress');
                    $user->save();
                    return 1;
                    break;
                case 'save_feature':
                    $user->feature=$request->input('feature');
                    $user->save();
                    return 1;
                    break;
                case 'save_phone':
                    $phone=preg_replace('((\s+)|(\()|(\))|(-))','',$request->input('phone'));
                    $phone=str_replace(" ",'',$phone);
                    $user->phone=$phone.'';
                    $user->save();
                    return 1;
                    break;

            }
        }

    }
}