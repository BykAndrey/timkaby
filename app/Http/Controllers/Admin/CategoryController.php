<?php

namespace App\Http\Controllers\Admin;

use App\ItemGroup;
use Validator;
use App\Category;
use App\PropertyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class CategoryController extends BaseAdminController
{
    public function __construct()
    {   parent::__construct();
        $bread=$this->data['bread_crumbs'];
        $bread['Категории']=route('admin::good_category');
        $this->data['bread_crumbs']=$bread;
    }


    public function home(Request $request){
        $page=0;
        if($request->has('page')){
            $page=$request->input('page')-1;

        }
        $sortby='name';
        if($request->has('sortby')){
            global  $sortby;
            $sortby=$request->input('sortby');

        }
        $sortMethod='asc';
        if($request->has('sortMethod')){
            global  $sortMethod;
            $sortMethod=$request->input('sortMethod');

        }


        $size=25;
        $this->data['count_pages']=ceil(Category::all()->count()/$size);
        ///НЕ работает
        /// $this->data['category']=DB::table('good_category')->paginate(15);

        ///$this->data['category']=Category::admin_getListobject($from=$page*$size,$to=$size);

        $this->data['category']=Category::admin_getListobject([
            'from'=>$page*$size,
            'to'=>$size,
            'sortby'=>$sortby,
            'sortMethod'=>$sortMethod
        ]);
        foreach ( $this->data['category'] as $item){
            $item->count_items=ItemGroup::where('id_good_category',$item->id)->count();
        }
        $this->data['page']=$page+1;
        $this->data['sortby']=$sortby;
        $this->data['sortMethod']=$sortMethod;
        return view('admin.listObjects.category',$this->data);
    }


    public function create(Request $request){

        if($request->isMethod('get')){
            $cat=Category::admin_getListobject_select();
            $select_cat=[0=>'Базовая категория'];
            foreach ($cat as $i){
                if($i->id_parent==0)
                $i->is_active ? $select_cat[$i->id]=$i->name." - Активная": $select_cat[$i->id]=$i->name." - Не активная";
            }
            $this->data['category_list']=$select_cat;


  /*          $bread=$this->data['bread_crumbs'];
            $bread['Создание новой категории']=route('admin::good_category_create');
            $this->data['bread_crumbs']=$bread;
*/
            $this->addBreadCrumbls('Создание новой категории',route('admin::good_category_create'));

            return view('admin.createObjects.category',$this->data);
        }
        if($request->isMethod('post')){
            $val=Validator::make($request->all(),
                [
                    'name'=>'required|min:5|max:90',
                    'title'=>'required|min:5|max:90',
                    'url'=>'required|min:5|max:100',
                    'description'=>'',
                    'meta_description'=>''
                ]
            );
            if($val->fails()){
                return redirect(route('admin::good_category_create'))
                    ->withErrors($val)
                    ->withInput();
            }

            $new=new Category();
            $new->id_parent=$request->input('id_parent');
            $new->name=$request->input('name');
            $new->title=$request->input('title');
            $new->url=$request->input('url');
            if ($request->file('image')){
                $new->image=$this->uploadImage($this->pathImage, $request->file('image'));

            }
            $new->description=$request->input('description');
            $new->meta_description=$request->input('meta_description');
            $new->is_active=$request->input('is_active');
            $new->save();
            return redirect(route('admin::good_category_edit',['id'=>$new->id]));
        }

    }





    public function  edit($id,Request $request){
        if($request->isMethod('get')){
            $cat=Category::admin_getListobject_select('id !='.$id);
            $select_cat=[0=>'Базовая категория'];
            foreach ($cat as $i){
                if($i->id_parent==0)
                $i->is_active ? $select_cat[$i->id]=$i->name." - Активная": $select_cat[$i->id]=$i->name." - Не активная";
            }
            $this->data['category_list']=$select_cat;
            $model=Category::where('id',$id)->first();
            $this->data['model']=$model;
            $this->data['property']=PropertyCategory::get_category_property($model->id);


            $this->addBreadCrumbls('Редактирование категории '.$model->name,route('admin::good_category_edit',['id'=>$model->id]));


            return view('admin.editObjects.category',$this->data);
        }
        if($request->isMethod('post')){
            $val=Validator::make($request->all(),
                [
                    'name'=>'required|min:5|max:90',
                    'title'=>'required|min:5|max:90',
                    'url'=>'required|min:5|max:100',
                    'description'=>'',
                    'meta_description'=>''
                ]
            );
            if($val->fails()){
                return redirect(route('admin::good_category_edit',['id'=>$id]))
                    ->withErrors($val)
                    ->withInput();
            }

            $new=Category::where('id',$id)->first();
            $new->id_parent=$request->input('id_parent');
            $new->name=$request->input('name');
            $new->title=$request->input('title');
            $new->url=$request->input('url');
            if ($request->file('image')){
                $new->image=$this->uploadImage($this->pathImage, $request->file('image'));

            }

            $new->description=$request->input('description');
            $new->meta_description=$request->input('meta_description');
            $new->is_active=$request->input('is_active');
            $new->save();
           return redirect(route('admin::good_category_edit',['id'=>$new->id]));
        }
        return 'ERROR';
    }




    public function  delete($id,Request $request){
        if($request->isMethod('get')){
            $this->data['route']=route('admin::good_category_delete',['id'=>$id]);
            $this->data['name']=Category::where('id',$id)->first()->name;
            return view('admin.sure',$this->data);
        }
        if($request->isMethod('post')){
            $item=Category::where('id',$id)->first();
            if($item){
                $item->delete();
                return redirect(route('admin::good_category'));
            }
            return 'Error';
        }
    }


    public function ajax(Request $request){
        if ($request->has('action')){
            $action = $request->input('action');

            switch ($action){
                case 'search':
                    $name=$request->input('what');
                    return DB::table('good_category')
                        ->where('name','like','%'.$name.'%')
                        ->get();

                    break;
            }
        }

    }

}
