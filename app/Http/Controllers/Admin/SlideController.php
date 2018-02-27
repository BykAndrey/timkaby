<?php

namespace App\Http\Controllers\Admin;

use App\Slide;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;

class SlideController extends AdminController
{
    public function home(Request $request)
    {
        $page=1;
        if($request->has('page')){
            $page=$request->input('page');
        }

        $page--;
        $size=10;

        $this->data['slides']=Slide::skip($page*$size)
            ->take($size)
            ->get();

        $count=Slide::all()->count();

        $this->data['current_page']=$page+1;
        $this->data['max_page']=ceil($count/$size);


        return view('admin.listObjects.slide',$this->data);
    }
    public function create(Request $request){
        if($request->isMethod('get')){
            return view('admin.createObjects.slide',$this->data);
        }
        if($request->isMethod('post')){
            $valid=Validator::make($request->all(),[
                'name'=>'required|min:1',
                'url'=>'required|min:1|max:100',
                'price'=>'required|min:0.01|numeric',
                'image'=>'required|image|max:2048',
                'description'=>'required|min:1'
            ]);
            if($valid->fails()){
                return redirect(route('admin::slide_create'))
                    ->withInput()
                    ->withErrors($valid);
            }

            $new =new Slide();
            $new->name=$request->input('name');
            $new->url=$request->input('url');
            $new->description=$request->input('description');
            $new->price=$request->input('price');
            $new->discount=$request->input('discount');


            if ($request->file('image')){
                $new->image=$this->uploadImage(BaseAdminController::$pathslideImage, $request->file('image'));

            }
            $new->save();

            return redirect(route('admin::slide_edit',['id'=>$new->id]));

        }
    }
    public function edit($id,Request $request){
        if($request->isMethod('get')){
            $this->data['model']=Slide::find($id);
        }
        if($request->isMethod('post')){
            $slide=Slide::find($id);
            if($slide!=null){
                $slide->name=$request->input('name');
                $slide->url=$request->input('url');
                $slide->price=$request->input('price');

                $slide->discount=$request->input('discount');


                $slide->description=$request->input('description');

                if ($request->file('image')){
                    $slide->image=$this->uploadImage(BaseAdminController::$pathslideImage, $request->file('image'));

                }
                $slide->save();
                return redirect(route('admin::slide_edit',['id'=>$id]));

            }
        }
        return view('admin.editObjects.slide',$this->data);
    }
    public function delete($id,Request $request){
        if($request->isMethod('get')){
            $this->data['route']=route('admin::slide_delete',['id'=>$id]);
            $this->data['name']=Slide::where('id',$id)->first()->name;
            return view('admin.sure',$this->data);
        }
        if($request->isMethod('post')){
            $item=Slide::where('id',$id)->first();
            if($item){
                $item->delete();
                return redirect(route('admin::slide'));
            }
            return 'Error';
        }



        return view('admin.listObjects.slide',$this->data);
    }
}
