<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Http\Middleware\Admin;
use App\ItemGroup;
use App\ItemGroupImage;
use App\PropertyItem;
use App\Provider;
use Validator;
use App\Category;
use App\Item;
use Illuminate\Http\Request;

class ItemGroupController extends BaseAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->addBreadCrumbls('Товары',route('admin::good_item_group'));
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
        $provider=0;
        if($request->has('provider')){
            global  $provider;
            $provider=$request->input('provider');

        }
        $brand=0;
        if($request->has('brand')){
            global  $brand;
            $brand=$request->input('brand');

        }
        $category=0;
        if($request->has('category')){
            global  $category;
            $category=$request->input('category');

        }

        $size=25;
        $count=count(ItemGroup::admin_getList(array('provider'=>$provider,'brand'=>$brand,'category'=>$category)));
        $this->data['count_pages']=ceil($count/$size);



        $list=ItemGroup::admin_getList(array('from'=>$size*$page,'to'=>$size,'provider'=>$provider,'brand'=>$brand,'category'=>$category));


        $this->data['brand']=$brand;
        $this->data['brands']=Brand::all();

        $this->data['provider']=$provider;
        $this->data['providers']=Provider::all();



        $cat=Category::admin_getListobject_select('id_parent=0');
        $select_cat=[];
        foreach ($cat as $i){
            $ls=Category::admin_getListobject_select('id_parent='.$i->id);
            $li=[];
            foreach ($ls as $l){
                $li[$l->id]=$l->name;
            }
            $select_cat[$i->name]=$li;
        }



        $this->data['category']=$category;
        $this->data['categories']=$select_cat;

        $this->data['list_item_group']=$list;
        $this->data['page']=$page+1;
        $this->data['sortby']=$sortby;
        $this->data['sortMethod']=$sortMethod;
        $request->session()->save();
        return view('admin.listObjects.item_group',$this->data);
    }

    public function  delete($id,Request $request){
        if($request->isMethod('get')){
            $this->addBreadCrumbls('Удаление товара',route('admin::good_item_group_delete',['id'=>$id]));
            $this->data['route']=route('admin::good_item_group_delete',['id'=>$id]);
            $this->data['name']=ItemGroup::where('id',$id)->first()->name;
            return view('admin.sure',$this->data);
        }
        if($request->isMethod('post')){
            ItemGroup::where('id',$id)->first()->delete();
            return redirect(route('admin::good_item_group'));
        }
    }

    public function  create(Request $request){
        if($request->isMethod('get')){

            $this->addBreadCrumbls('Создание товара',route('admin::good_item_group_create'));


            $cat=Category::admin_getListobject_select('id_parent=0');
            $select_cat=[];
            foreach ($cat as $i){
                /*  if($i->id_parent>0)
                  $i->is_active ? $select_cat[$i->id]=$i->name." - Активная": $select_cat[$i->id]=$i->name." - Не активная";*/
                $ls=Category::admin_getListobject_select('id_parent='.$i->id);
                $li=[];
                foreach ($ls as $l){
                    $li[$l->id]=$l->name;
                }
                $select_cat[$i->name]=$li;
            }
            $this->data['brand']=Brand::all();
            $this->data['provider']=Provider::all();
            $this->data['category_list']=$select_cat;
            return view('admin.createObjects.item_group',$this->data);
        }
        if($request->isMethod('post')){
            $val=Validator::make($request->all(),[
                'name'=>'required|max:90',
                'title'=>'required|max:90',
                'url'=>'required|unique:good_item_group,url|max:90',
                'articul'=>'',
                //'image'=>'required|mimes:jpeg,png,jpg,gif|max:2048',
                'price'=>'required|min:0.01|numeric',
                'discount'=>'min:0|max:100|integer'


            ]);
            if($val->fails()){
                return redirect(route('admin::good_item_group_create'))
                    ->withErrors($val)
                    ->withInput();
            }

            $new = new ItemGroup();
            $new->name=$request->input('name');
            $new->id_good_category=$request->input('id_good_category');

            $new->title=$request->input('title');
            $new->url=$request->input('url');

            $new->image=$request->input('ajaxImageField');//$this->uploadImage($this->pathImage, $request->file('image'));



            $new->id_brand=$request->input('id_brand');
            $new->id_provider=$request->input('id_provider');

            $new->articul=$request->input('articul');
            $new->price=$request->input('price');
            $new->description=$request->input('description');

            $new->meta_description=$request->input('meta_description');

            $new->discount=intval($request->input('discount'));

            $new->is_active=$request->input('is_active');
            $new->is_hot=$request->input('is_hot');
            $new->is_new=$request->input('is_new');

            $new->save();
            if($request->input('autoOffer'))
            {

                $val=Validator::make($request->all(),[
                    'name'=>'required|max:90',
                    'title'=>'required|max:90',
                    'url'=>'required|unique:good_item,url|max:90',
                    'articul'=>'',
                    'price'=>'required|min:0.01|numeric',
                    'discount'=>'min:0|max:100|integer'


                ]);
                if($val->fails()){
                    return redirect(route('admin::good_item_create'))
                        ->withErrors($val)
                        ->withInput()
                        ->with('id_good_item_group',$new->id);
                }

                $offer=new Item();
                $offer->name=$request->input('name');
                $offer->id_good_item_group=$new->id;

                $offer->title=$request->input('title');
                $offer->url=$request->input('url');

                $offer->image=$new->image;



                $offer->id_brand=   $new->id_brand;
                $offer->id_provider=$new->id_provider;

                $offer->articul=$request->input('articul');
                $offer->price=$request->input('price');
                $offer->description=$request->input('description');

                $offer->meta_description=$request->input('meta_description');

                $offer->discount=intval($request->input('discount'));

                $offer->is_active=$request->input('is_active');
                $offer->is_hot=$request->input('is_hot');
                $offer->is_new=$request->input('is_new');

                $offer->save();
            }

            return redirect(route('admin::good_item_group_edit',['id'=>$new->id]));
        }
    }


    public function  edit($id,Request $request){
        $this->addBreadCrumbls('Редактирование товара',route('admin::good_item_group_edit',['id'=>$id]));
        if($request->isMethod('get')){
            $cat=Category::admin_getListobject_select('id_parent=0');
            $select_cat=[];
            foreach ($cat as $i){
                /*  if($i->id_parent>0)
                  $i->is_active ? $select_cat[$i->id]=$i->name." - Активная": $select_cat[$i->id]=$i->name." - Не активная";*/
                $ls=Category::admin_getListobject_select('id_parent='.$i->id);
                $li=[];
                foreach ($ls as $l){
                    $li[$l->id]=$l->name;
                }
                $select_cat[$i->name]=$li;
            }
            $this->data['brand']=Brand::all();
            $this->data['provider']=Provider::all();

            $this->data['category_list']=$select_cat;
            $this->data['model']=ItemGroup::where('id',$id)->first();
            return view('admin.editObjects.item_group',$this->data);
        }



        if($request->isMethod('post')){

            $new =ItemGroup::where('id',$id)->first();
            if($new){
            $val=Validator::make($request->all(),[
                'name'=>'required|max:90',
                'title'=>'required|max:90',
                'url'=>'required|unique:good_item_group,url,'.$new->id.',id|max:90',
                'articul'=>'',
                //'image'=>'mimes:jpeg,png,jpg,gif|max:2048',
                'price'=>'required|min:0.01|numeric',
                'discount'=>'min:0|max:100|integer'


            ]);
            if($val->fails()){
                return redirect(route('admin::good_item_group_edit',['id'=>$new->id]))
                    ->withErrors($val)
                    ->withInput();
            }


            $new->name=$request->input('name');

            if($new->id_good_category!=$request->input('id_good_category')){
                $items=Item::where('id_good_item_group',$new->id)->get();
                foreach ($items as $i){
                    $props=PropertyItem::where('id_good_item',$i->id)->get();
                    foreach ($props as $j){
                        $j->delete();
                    }
                }
            }
            $new->id_good_category=$request->input('id_good_category');

            $new->title=$request->input('title');
            $new->url=$request->input('url');
            /*if ($request->file('image')){
                $new->image=$this->uploadImage($this->pathImage, $request->file('image'));
            }*/
                $new->image=$request->input('ajaxImageField');


                $new->id_brand=$request->input('id_brand');
                $new->id_provider=$request->input('id_provider');


            $new->articul=$request->input('articul');
            $new->price=$request->input('price');
            $new->description=$request->input('description');

            $new->meta_description=$request->input('meta_description');

            $new->discount=intval($request->input('discount'));

            $new->is_active=$request->input('is_active');
            $new->is_hot=$request->input('is_hot');
            $new->is_new=$request->input('is_new');

            $new->save();

            return redirect(route('admin::good_item_group_edit',['id'=>$new->id]));

            }
        }
    }

    public function getObject($id,Request $request){
       //return ['name'=>'name'];
        return ItemGroup::where('id',$id)->first();
    }

        public function getListItem($id,Request $request){
            $list=Item::where('id_good_item_group',$id)->get();
            foreach ($list as $item) {
                $item->image=ItemGroup::getImage($item->image,180,null);
            }
            return $list;
        }





    public function ajax(Request $request){

        if ($request->has('action')){
            $action = $request->input('action');

            switch ($action){
                #case 'sort':
                #    $name=$request->input('what');
                #    return DB::table('good_category')
                #        ->where('name','like','%'.$name.'%')
                 #       ->get();
                #    break;
                case 'addImage':


                    $id_gr=$request->input('id_item_group');
                    $itemgr=ItemGroup::find($id_gr);
                    if($itemgr!=null){
                        $img=new ItemGroupImage();
                        if ($request->file('image')){
                           $img->image=$this->uploadImage($this->pathImage, $request->file('image'));
                           $img->name=$request->input('name');
                           $img->id_good_item_group=$id_gr;
                           $img->save();
                           return 1;
                        }


                        return 0;
                    }
                    return 0;
                    break;
                case 'listImage':
                    $id_gr=$request->input('id_item_group');
                    $itemgr=ItemGroup::find($id_gr);
                    if($itemgr!=null){

                        $items=ItemGroupImage::where('id_good_item_group',$id_gr)->get();
                        foreach ($items as $item) {
                            $item->image=ItemGroup::getImage($item->image,180,null);
                        }

                        return $items;
                    }

                    break;
                case 'deleteImage':
                    $id=$request->input('id_image');
                    $img=ItemGroupImage::find($id);
                    if($img!=null){
                      $img->delete();
                      return 1;
                    }
                    break;
                case 'saveImage':
                    $id=$request->input('id_image');
                    $img=ItemGroupImage::find($id);
                    if($img!=null){
                        $img->name=$request->input('name');
                        $img->save();
                        return 1;
                    }
                    break;
                case 'get_dollar_rate':
                    $id=$request->input('id_provider');
                    $prov=Provider::find($id);
                    if($prov!=null){
                        return $prov->dollar_rate;
                    }
                    break;
                case "setNewPrice":
                    $id=intval($request->input('id'));
                    $newPrice=intval($request->input('price'));
                    $item=ItemGroup::find($id);
                    if($item and $newPrice>=0){

                        $item->price=$newPrice;
                        $item->save();
                        $offers=Item::where('id_good_item_group',$item->id)->get();

                        foreach ($offers as $of){
                            $of->price=$newPrice;
                            $of->save();
                        }
                        return 1;
                    }

                    return 0;

                    break;



                case "setNewDiscount":
                    $id=intval($request->input('id'));
                    $newPrice=intval($request->input('discount'));
                    $item=ItemGroup::find($id);
                    if($item and $newPrice>=0){

                        $item->discount=$newPrice;
                        $item->save();
                        $offers=Item::where('id_good_item_group',$item->id)->get();

                        foreach ($offers as $of){
                            $of->discount=$newPrice;
                            $of->save();
                        }
                        return 1;
                    }

                    return 0;

                    break;

                case "uploadImage":
                    return $this->uploadImage($this->pathImage, $request->file('image'));
                    break;
                }
            }
        }
    }
