<?php

namespace App\Http\Controllers\Home;
use App\OptionDelivery;
use App\Order_item;
use App\User;
use App\Order;
use App\Item_Order;
use App\ItemGroup;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Item;
use Validator;
use Illuminate\Support\Facades\Auth;
class CartController extends BaseHomeController
{

    public function home(Request $request){
        $this->addBreadCrumbls('Корзина',route('cart::home'));
        $this->data['order_items']=$this->get_list($request);

        return view('home.cart.cart',$this->data);
    }

    public function thank(Request $request){
        return view('home.cart.thank',$this->data);
    }

    ////////////////////////////////////////////////
    public function createOrder(Request $request){
        if($request->isMethod('get')){
            $this->addBreadCrumbls('Корзина',route('cart::home'));
            $this->addBreadCrumbls('Оформление заказа',route('cart::home'));
            $user=Auth::user();
            if($user==null){
                $user=new User();
                $user->name='';
                $user->phone='';
                $user->adress='';
            }

            if(!$request->session()->has('id_option_delivery'))
                return redirect(route('cart::home'));
            $id_option_delivery=intval($request->session()->get('id_option_delivery'));
            //echo $id_option_delivery;
            $this->data['option']=OptionDelivery::find($id_option_delivery);
            $this->data['order_data']=$user;
            // $this->data['order_items']=$this->get_list($request);
            return view('home.cart.create_order',$this->data);
        }
        if($request->isMethod('post')){

            $val=Validator::make($request->all(),
                [
                    'name'=>'required|min:2',
                    'phone'=>'required|min:7'
                ]);
            if($val->fails()){
                return redirect(route('cart::create_order'))
                    ->withInput()
                    ->withErrors($val);
            }


            if(!$request->session()->has('id_option_delivery'))
                //return $request->session()->has('id_option_delivery');
                return redirect(route('cart::home'));

            $option_delivery=OptionDelivery::find($request->session()->get('id_option_delivery'));
            if($option_delivery==null){

                return redirect(route('cart::home'));
            }

            /*echo $request->input('name');
            echo $request->input('phone');
            echo $request->input('adress');*/
            $newOrder=new Order();
            $newOrder->name=$request->input('name');
            $newOrder->phone=$request->input('phone');
            $newOrder->adress=$request->input('adress');
            $newOrder->feature=$request->input('feature');
            $newOrder->total_price=0;
            $newOrder->status=0;
            $newOrder->id_option_delivery=$option_delivery->id;
            $newOrder->delivery_price=$option_delivery->price;
            if(Auth::id()){
                $newOrder->id_user=Auth::id();
            }

            $newOrder->save();


            $GOODS=$this->get_list($request);
            $total_price=0;
            foreach ($GOODS as $item){
                $newOI=new Order_item();
                $newOI->name=$item->name;
                $newOI->price=sprintf('%.2f',$item->price);
                $newOI->url=$item->url;
                $newOI->id_item=$item->id;
                $newOI->id_order=$newOrder->id;
                $newOI->count=$item->count;
                $newOI->save();
                $total_price+=sprintf('%.2f',$newOI->price*$item->count);
            }


            if($total_price>=$option_delivery->border_free){
                $newOrder->delivery_price=0;
            }


            $newOrder->total_price=$total_price;
            $newOrder->save();
            $request->session()->put('order_items',json_encode([]));
           return redirect(route('cart::thank'));
        }
    }



    /////////////////////////////////////////////////////////
    public function  get_session_list_cart(Request $request){
        $list=array();
        if($request->session()->has('order_items')){
            global $list;
            $list=json_decode($request->session()->get('order_items'));
        }else{
            global $list;
            $request->session()->put('order_items',json_encode([]));
            $list=json_decode($request->session()->get('order_items'));
        }
        //$request->session()->put('order_items',json_encode([]));
       //echo json_encode($list);
        //$this->set_session_list_cart($list,$request)
        return $list;
    }


    ////////////////////////////////////
    public function  set_session_list_cart($list,Request $request){
        $request->session()->put('order_items',json_encode($list));
    }



    ///////////////////////////////////////////
    public function get_list(Request $request){
        try{


        //$request->session()->put('order_items',json_encode([]));
        $list=$this->get_session_list_cart($request);
//

        $items_good=array();
        foreach ($list as $i){
            $good=DB::table('good_item')

                ->join('good_item_group','good_item.id_good_item_group','=','good_item_group.id')
                ->join('good_category','good_category.id','=','good_item_group.id_good_category')

                ->select('good_item.id','good_item.name','good_item.image','good_item.url as ur','good_item.price as old_price','good_category.url as caturl')
                ->selectRaw('(good_item.price-(good_item.discount*good_item.price)/100) as price')
                ->selectRaw('CONCAT("/catalog/",good_category.url,"/",good_item.url) as url')
                ->where('good_item.id',$i->id)
                ->where('good_item.is_active',1)
                ->where('good_category.is_active',1)
                ->first();
            $good->image=ItemGroup::getImage($good->image,70,null);
            $good->count=$i->count;
            $items_good[]=$good;


        }

        return $items_good;
        }
        catch(\ErrorException $x){
            $request->session()->put('order_items',json_encode([]));
        }
    }



  /////////////////////////////////////////////////





    public function add_to_cart(Request $request){
        $flag=0;
        if($request->session()->has('order_items')){
            global $flag;
            $flag=1;
        }else{
            $request->session()->put('order_items',json_encode([]));
        }



        $list=json_decode($request->session()->get('order_items'));
        //echo json_encode($list);
        $id=intval($request->input('id'));

        $item=Item::where('id',$id)->first();

        if($item!=null){
            $flag=false;
            foreach ($list as $i){


                if($i->id==$id){
                    $i->count++;
                    $flag=true;
                }
            }
            if($flag==false){
                $list[]=array('id'=>$item->id,'url'=>$item->url,'count'=>1);
            }



        }
        $request->session()->put('order_items',json_encode($list));

        if($request->ajax()){
            return 1;

       }
        else{
            return redirect(route('cart::home'));
        }
    }





    ////////////////////////////////////////////////////////////////////////





        public function remove_from_cart(){

        }



        public function clear_cart(Request $request){
            $request->session()->put('order_items',json_encode([]));


            if($request->ajax()){
                return true;

            }else
            {
                return redirect(route('cart::home'));
            }
        }
////////////////////////////////////////////////////////////////


        public function cart_ajax(Request $request){
            if($request->ajax()){
                $action=$request->input('action');
                switch ($action){
                    case 'getlist':
                        return $this->get_list($request);
                        break;
                    case 'set_option_delivery':
                        $id=$request->input('id');
                        if(OptionDelivery::find($id)){
                            $request->session()->put('id_option_delivery',$id);
                            return 1;
                            return redirect(route('cart::create_order'));
                        }
                        return 0;
                        break;




                    case 'options_delivery':
                       /* return [
                            [
                                'id'=>1,
                                'name'=>'Курьер',
                                'price'=>4
                            ],
                            [
                                'id'=>2,
                                'name'=>'Самовывоз',
                                'price'=>0
                            ]
                        ];*/
                       return OptionDelivery::all();
                        break;
                    case 'inc_item':
                        if($request->has('id')){
                            $this->add_to_cart($request);
                            return 1;
                        }else{
                            return 0;
                        }
                        break;




                    case 'dec_item':
                        $list=$this->get_session_list_cart($request);
                        $id=intval($request->input('id'));

                        foreach ($list as $item){
                            if($item->id==$id){
                                $item->count--;
                            }
                        }
                        $this->set_session_list_cart($list,$request);
                        //$request->session()->put()

                        return 1;
                        break;





                    case 'remove_item':
                        $list=$this->get_session_list_cart($request);
                        $id=intval($request->input('id'));

                        foreach ($list as $key=>$item){
                            //echo $item->id;
                            if($id== $item->id){

                                array_splice($list,$key,1);
                                break;
                            }
                        }
                        $this->set_session_list_cart($list,$request);
                        return 1;
                        break;





                    case 'get_cart_data':
                        $list=$this->get_list($request);
                        $good_price=0;
                        $count=0;
                        foreach ($list as $item){
                            $good_price+=sprintf('%.2f',$item->price)*$item->count;
                            $count+=$item->count;
                        }
                       return [
                           'good_price'=>$good_price,
                           'count'=>$count
                       ];
                        break;
                    case "quick_order":
                        $id_item=intval($request->input('id_item'));
                        $item=Item::where('is_active',1)->where('id',$id_item)->first();
                        $id_delivery=intval($request->input('delivery'));
                        if($item!=null){

                           // $user_date=$request->input('user');



                            $newOrder=new Order();
                            //echo $request->input('user');
                            $newOrder->name=$request->input('user_name');
                            $newOrder->phone=$request->input('user_phone');
                            $newOrder->adress=$request->input('user_adress');
                            $newOrder->feature=$request->input('user_feature');
                            $newOrder->total_price=0;
                            $newOrder->status=0;
                            $newOrder->id_option_delivery=$id_delivery;
                           // echo $id_delivery;
                            $newOrder->delivery_price=OptionDelivery::find($id_delivery)->price;
                            if(Auth::id()){
                                $newOrder->id_user=Auth::id();
                            }

                            $newOrder->save();

                            $total_price=0;

                                $newOI=new Order_item();
                                $newOI->name=$item->name;
                                $newOI->price=sprintf('%.2f',($item['price']-($item['discount']*$item['price'])/100));
                                $newOI->url=$item->url;
                                $newOI->id_item=$item->id;
                                $newOI->id_order=$newOrder->id;
                                $newOI->count=1;
                                $newOI->save();
                                $total_price+=sprintf('%.2f',$newOI->price*$newOI->count);



                            if($total_price>=OptionDelivery::find($id_delivery)->border_free){
                                $newOrder->delivery_price=0;
                            }


                            $newOrder->total_price=$total_price;
                            $newOrder->save();

                            return 1;
                        }
                        break;
                    case 'getOptionDelivery':

                            return OptionDelivery::all();

                        break;
                }
            }
            else{
                $action=$request->input('action');
                switch ($action){

                    case 'set_option_delivery':
                        $id=$request->input('id');
                        if(OptionDelivery::find($id)){
                            $request->session()->put('id_option_delivery',$id);
                            //return 1;
                            return redirect(route('cart::create_order'));
                        }
                        return abort(404);
                        break;
                }
                return '';
            }
        }
}