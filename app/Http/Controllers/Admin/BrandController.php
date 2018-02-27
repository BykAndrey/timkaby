<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Brand;
use Validator;
class BrandController extends AdminController
{
    public function home(Request $request){
        $page=1;
        if($request->has('page')){
            $page=$request->input('page');
        }

        $page--;
        $size=10;





        $this->data['good_brand']=Brand::orderBy('updated_at','DESC')->skip($page*$size)
            ->take($size)

            ->get();;

        $count=Brand::all()->count();


        $this->data['current_page']=$page+1;
        $this->data['max_page']=ceil($count/$size);

        return view('admin.listObjects.brand',$this->data);
    }
    public  function create(Request $request){
        if($request->isMethod('get')){
            return view('admin.createObjects.brand',$this->data);
        }
        if($request->isMethod('post')){
            $val=Validator::make($request->all(),[
                'name'=>'required|min:3|max:90'
            ]);
            if($val->fails()){
                return redirect(route('admin::good_brand_create'))
                    ->withErrors($val)
                    ->withInput();
            }
            $new=new Brand();
            $new->name=$request->input('name');
            $new->save();
            return redirect(route('admin::good_brand_edit',['id'=>$new->id]));
        }
    }
    public  function  edit($id,Request $request){
        if($request->isMethod('get')){
            $this->data['model']=Brand::where('id',$id)->first();
            return view('admin.editObjects.brand',$this->data);
        }
        if($request->isMethod('post')){
            $val=Validator::make($request->all(),[
                'name'=>'required|min:3|max:90'
            ]);
            if($val->fails()){
                return redirect(route('admin::good_brand_create'))
                    ->withErrors($val)
                    ->withInput();
            }
            $new=Brand::where('id',$id)->first();
            $new->name=$request->input('name');
            $new->save();
            return redirect(route('admin::good_brand_edit',['id'=>$new->id]));
        }
    }
    public function  delete($id,Request $request){
        if($request->isMethod('get')){
            $this->data['route']=route('admin::good_brand_delete',['id'=>$id]);
            $this->data['name']=Brand::where('id',$id)->first()->name;
            return view('admin.sure',$this->data);
        }
        if($request->isMethod('post')){
            $item=Brand::where('id',$id)->first();
            if($item){
                $item->delete();
                return redirect(route('admin::good_brand'));
            }
            return 'Error';
        }
    }
}
