<?php

namespace App\Http\Controllers\Admin;

use App\OptionDelivery;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;

class OptionDeliveryController  extends BaseAdminController
{   public $rules=[
    'name'=>'required|max:45|min:1',
    'price'=>'numeric|min:0.00',
    'text_price'=>''
];
    public function __construct()
    {
        parent::__construct();
        $this->addBreadCrumbls('Товары',route('admin::good_item_group'));
    }
    public function home(Request $request){


        $page=1;
        if($request->has('page')){
            $page=$request->input('page');
        }

        $page--;
        $size=10;

        $this->data['items']=OptionDelivery::skip($page*$size)
            ->take($size)
            ->get();





        $count=OptionDelivery::all()->count();

        $this->data['current_page']=$page+1;
        $this->data['max_page']=ceil($count/$size);

        return view('admin.listObjects.option_delivery',$this->data);
    }
    public  function create(Request $request){
        if($request->isMethod('get')){
            return view('admin.createObjects.option_delivery',
                $this->data);
        }
        if($request->isMethod('post')){
            $valid=Validator::make($request->all(),$this->rules );
            if($valid->fails()){
                return redirect(route('admin::option_delivery_create'))
                    ->withInput()
                    ->withErrors($valid);
            }

            $new=new OptionDelivery();

            $new->name=$request->input('name');
            $new->price=$request->input('price');
            $new->text_price=$request->input('text_price');
            $new->border_free= intval($request->input('border_free'));
            $new->save();

            return redirect(route('admin::option_delivery_edit',['id'=>$new->id]));

        }
    }

    public function edit($id,Request $request){
        if($request->isMethod('get')){
            $this->data['model']=OptionDelivery::find($id);

            return view('admin.editObjects.option_delivery',$this->data);
        }
        if($request->isMethod('post')){
            $valid=Validator::make($request->all(),$this->rules );
            if($valid->fails()){
                return redirect(route('admin::option_delivery_create'))
                    ->withInput()
                    ->withErrors($valid);
            }

            $new=OptionDelivery::find($id);
            if($new!=null){
                $new->name=$request->input('name');
                $new->price=$request->input('price');
                $new->text_price=$request->input('text_price');
                $new->border_free = intval($request->input('border_free'));
                $new->save();
                return redirect(route('admin::option_delivery_edit',['id'=>$new->id]));
            }

            return 'error';

        }
    }
    public function  delete($id,Request $request){
        if($request->isMethod('get')){
            $this->addBreadCrumbls('Удаление товара',route('admin::option_delivery_delete',['id'=>$id]));
            $this->data['route']=route('admin::option_delivery_delete',['id'=>$id]);
            $this->data['name']=OptionDelivery::where('id',$id)->first()->name;
            return view('admin.sure',$this->data);
        }
        if($request->isMethod('post')){
            OptionDelivery::where('id',$id)->first()->delete();
            return redirect(route('admin::option_delivery'));
        }
    }
}
