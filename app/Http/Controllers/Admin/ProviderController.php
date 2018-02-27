<?php

namespace App\Http\Controllers\Admin;

use App\Provider;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;

class ProviderController extends AdminController
{
    public function home(Request $request){

        $page=1;
        if($request->has('page')){
            $page=$request->input('page');
        }

        $page--;
        $size=10;


        $this->data['good_provider']=Provider::skip($page*$size)->take($size)->get();
        $count=Provider::all()->count();



        $this->data['current_page']=$page+1;
        $this->data['max_page']=ceil($count/$size);


        return view('admin.listObjects.provider',$this->data);
    }
    public  function create(Request $request){
        if($request->isMethod('get')){
            return view('admin.createObjects.provider',$this->data);
        }
        if($request->isMethod('post')){
            $val=Validator::make($request->all(),[
                'name'=>'required|min:3|max:90',
                'dollar_rate'=>'required|min:0.0001|numeric'
            ]);
            if($val->fails()){
                return redirect(route('admin::good_provider_create'))
                    ->withErrors($val)
                    ->withInput();
            }
            $new=new Provider();
            $new->name=$request->input('name');
            $new->dollar_rate=$request->input('dollar_rate');
            $new->save();
            return redirect(route('admin::good_provider_edit',['id'=>$new->id]));
        }
    }
    public  function  edit($id,Request $request){
        if($request->isMethod('get')){
            $this->data['model']=Provider::where('id',$id)->first();
            return view('admin.editObjects.provider',$this->data);
        }
        if($request->isMethod('post')){
            $val=Validator::make($request->all(),[
                'name'=>'required|min:3|max:90',
                'dollar_rate'=>'required|min:0.0001|numeric'
            ]);
            if($val->fails()){
                return redirect(route('admin::good_provider_create'))
                    ->withErrors($val)
                    ->withInput();
            }
           $new=Provider::where('id',$id)->first();
            $new->name=$request->input('name');
            $new->dollar_rate=$request->input('dollar_rate');
            $new->save();
            return redirect(route('admin::good_provider_edit',['id'=>$new->id]));
        }
    }
    public function  delete($id,Request $request){
        if($request->isMethod('get')){
            $this->data['route']=route('admin::good_provider_delete',['id'=>$id]);
            $this->data['name']=Provider::where('id',$id)->first()->name;
            return view('admin.sure',$this->data);
        }
        if($request->isMethod('post')){
            $item=Provider::where('id',$id)->first();
            if($item){
                $item->delete();
                return redirect(route('admin::good_provider'));
            }
            return 'Error';
        }
    }
}
