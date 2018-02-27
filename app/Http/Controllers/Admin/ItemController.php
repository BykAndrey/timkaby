<?php

namespace App\Http\Controllers\Admin;
use App\ItemGroup;
use PhpParser\Node\Stmt\Foreach_;
use Validator;
use App\Category;
use Illuminate\Http\Request;
use App\Item;
use App\Http\Requests;
use App\Brand;
use App\Provider;
use Illuminate\Support\Facades\DB;

class ItemController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->addBreadCrumbls('Предложения',route('admin::good_item'));
    }

    public function home(Request $request){
       // $items=Item::admin_getList();

        $page=1;
        if($request->has('page')){
            $page=$request->input('page');
        }

        $page--;
        $size=25;



        $sort="created_at";
        $sortby=['created_at','desc'];
        if($request->has('sortby')){
            $sort=$request->input('sortby');
        }
        switch ($sort){
            case "created-at-desc":
                global $sortby;
                $sortby=['created_at','desc'];
                break;
            case "created-at-asc":
                global $sortby;
                $sortby=['created_at','asc'];
                break;
            case "is-active-desc":
                global $sortby;
                $sortby=['is_active','desc'];
                break;
            case "is-active-asc":
                global $sortby;
                $sortby=['is_active','asc'];
                break;
            case "discount-desc":
                global $sortby;
                $sortby=['discount','desc'];
                break;
            case "discount-asc":
                global $sortby;
                $sortby=['discount','asc'];
                break;

        }

        $items=DB::table('good_item')
            ->join('good_item_group','good_item_group.id','=','good_item.id_good_item_group')
            ->select('good_item.*','good_item_group.name as item_group')
            ->skip($page*$size)
            ->take($size)
            ->orderBy($sortby[0],$sortby[1])
            ->get();

        $count=DB::table('good_item')
            ->join('good_item_group','good_item_group.id','=','good_item.id_good_item_group')
            ->select('good_item.*','good_item_group.name as item_group')->count();



        foreach ($items as $item){
            $item->image=ItemGroup::getImage($item->image,180,null);
        }
        $this->data['items']=$items;
        $this->data['sortby']=$sortby;

        $this->data['current_page']=$page+1;
        $this->data['max_page']=ceil($count/$size);

        $request->session()->save();
        return view('admin.listObjects.item',$this->data);
    }

    public function  create(Request $request){
        $this->addBreadCrumbls('Создание предложения',route('admin::good_item_create'));
        if($request->isMethod('get')){
           /* $cat=Category::admin_getListobject_select('id_parent=0');
            $select_cat=[];
            foreach ($cat as $i){
              //  if($i->id_parent>0)
               // $i->is_active ? $select_cat[$i->id]=$i->name." - Активная": $select_cat[$i->id]=$i->name." - Не активная";
                $ls=Category::admin_getListobject_select('id_parent='.$i->id);
                $li=[];
                foreach ($ls as $l){
                    $li[$l->id]=$l->name;
                }
                $select_cat[$i->name]=$li;
            }*/
           $itemgr=ItemGroup::all();
            $this->data['good_item_group_list']=$itemgr;
            if($request->has('id_good_item_group')){
                $item_group=ItemGroup::where('id',$request->input('id_good_item_group'))->first();
               $this->data['item_group']=$item_group;
            }
            $this->data['brand']=Brand::all();
            $this->data['provider']=Provider::all();

        //    $this->data['item_group']=$select_cat;
            return view('admin.createObjects.item',$this->data);
        }
        if($request->isMethod('post')){

            $para=[
                'name'=>'required|max:90',
                'title'=>'required|max:90',
                'url'=>'required|unique:good_item,url|max:90',
                'articul'=>'',
                'price'=>'required|min:0.01|numeric',
                'discount'=>'required|min:0|max:100|integer'
            ];

            if(!$request->has('id_good_item_group')){


            }else{
                if(strlen($request->input('imageImport'))<3){
                    $para['image']='required|mimes:jpeg,png,jpg,gif|max:2048';
                }
            }
            $val=Validator::make($request->all(),$para);
            if($val->fails()){
                return redirect(route('admin::good_item_create'))
                    ->withErrors($val)
                    ->withInput();
            }

            $new = new Item();
            $new->name=$request->input('name');
            $new->id_good_item_group=$request->input('id_good_item_group');

            $new->title=$request->input('title');
            $new->url=$request->input('url');

          /*  $flag=false;
            if ($request->file('image')){
                $new->image=$this->uploadImage($this->pathImage, $request->file('image'));
                $flag=true;
            }
            if($request->input('imageImport') and $flag==false and strlen($request->input('imageImport'))>3){
                $img=$request->input('imageImport');
                if($img[0]=='/'){
                    $img[0]=' ';
                }
                $new->image=trim($img);
                $flag=true;
            }*/
            $new->image=$request->input('imageImport');




            $new->id_brand=$request->input('id_brand');
            $new->id_provider=$request->input('id_provider');

            $new->articul=$request->input('articul');
            $new->price=$request->input('price');
            $new->description=$request->input('description');

            $new->meta_description=$request->input('meta_description');

            $new->discount=$request->input('discount');

            $new->is_active=$request->input('is_active');
            $new->is_hot=$request->input('is_hot');
            $new->is_new=$request->input('is_new');

            $new->save();
            return redirect(route('admin::good_item_edit',['id'=>$new->id]));
        }
    }



    public function  edit($id,Request $request){
        if($request->isMethod('get')){
           /* $cat=Category::admin_getListobject_select();
            $select_cat=[];
            foreach ($cat as $i){
                  if($i->id_parent>0)
                  $i->is_active ? $select_cat[$i->id]=$i->name." - Активная": $select_cat[$i->id]=$i->name." - Не активная";
                $ls=Category::admin_getListobject_select('id_parent='.$i->id);
                $li=[];
                foreach ($ls as $l){
                    $li[$l->id]=$l->name;
                }
                $select_cat[$i->name]=$li;
            }
            $this->data['category_list']=$select_cat;*/
           $it=Item::where('id',$id)->first();

            $this->addBreadCrumbls('Товар',route('admin::good_item_group_edit',['id'=>$it->id_good_item_group]));
            $this->addBreadCrumbls('Редактирование предложения',route('admin::good_item_edit',['id'=>$it->id]));



           $itCat=ItemGroup::where('id',$it->id_good_item_group)->first()->id_good_category;
            $this->data['good_item_group_list']=ItemGroup::where('id_good_category',$itCat)->get();

            $this->data['brand']=Brand::all();
            $this->data['provider']=Provider::all();



            $item_gr=$it->id_good_item_group;
            $this->data['id_good_item_group']=$item_gr;
            $this->data['model']=Item::where('id',$id)->first();
            return view('admin.editObjects.item',$this->data);
        }



        if($request->isMethod('post')){
            $new =Item::where('id',$id)->first();
            $val=Validator::make($request->all(),[
                'name'=>'required|max:90',
                'title'=>'required|max:90',
                'url'=>'required|unique:good_item,url,'. $new->id.',id|max:90',
                'articul'=>'',
               // 'image'=>'mimes:jpeg,png,jpg,gif|max:2048',
                'price'=>'required|min:0.01|numeric',
                'discount'=>'required|min:0|max:100|integer'


            ]);
            if($val->fails()){
                return redirect(route('admin::good_item_edit',['id'=>$id]))
                    ->withErrors($val)
                    ->withInput();
            }


            if(!$new){
                return "Error";
            }
            $new->name=$request->input('name');
            $new->id_good_item_group=$request->input('id_good_item_group');

            $new->title=$request->input('title');
            $new->url=$request->input('url');
            $flag=false;
           /* if ($request->file('image')){
                $new->image=$this->uploadImage($this->pathImage, $request->file('image'));
                $flag=true;
            }
            if($request->input('imageImport') and $flag==false and strlen($request->input('imageImport'))>3){
                $img=$request->input('imageImport');
                if($img[0]=='/'){
                    $img[0]=' ';
                }
                $new->image=trim($img);
                $flag=true;
            }
*/
$new->image=$request->input('imageImport');



            $new->id_brand=$request->input('id_brand');
            $new->id_provider=$request->input('id_provider');


            $new->articul=$request->input('articul');
            $new->price=$request->input('price');
            $new->description=$request->input('description');

            $new->meta_description=$request->input('meta_description');

            $new->discount=$request->input('discount');

            $new->is_active=$request->input('is_active');
            $new->is_hot=$request->input('is_hot');
            $new->is_new=$request->input('is_new');

            $new->save();
            return redirect(route('admin::good_item_edit',['id'=>$new->id]));
        }
    }


    public function  delete($id,Request $request){
        if($request->isMethod('get')){
            $this->data['route']=route('admin::good_item_delete',['id'=>$id]);
            $this->data['name']=Item::where('id',$id)->first()->name;
            return view('admin.sure',$this->data);
        }
        if($request->isMethod('post')){
            $item=Item::where('id',$id)->first();
            if($item){
                $item->delete();
                return redirect(route('admin::good_item'));
            }
            return 'Error';
        }
    }


    public function ajax(Request $request){
        $action =$request->input('action');
        switch ($action){
            case 'setActive':
                $id=intval($request->input('id'));
                $item=Item::find($id);
                if($item!=null){
                    $item->is_active=!$item->is_active;
                    $item->save();
                    return $item->is_active==true?1:0;
                }
                break;
            case 'setNew':
                $id=intval($request->input('id'));
                $item=Item::find($id);
                if($item!=null){
                    $item->is_new=!$item->is_new;
                    $item->save();
                    return $item->is_new==true?1:0;
                }
                break;
            case 'setDiscount':
                $id=intval($request->input('id'));

                $discount=intval($request->input('discount'));
                $item=Item::find($id);
                if($item!=null and $discount>=0){
                    $item->discount=$discount;
                    $item->save();
                    return 1;
                }
                return 0;
                break;

            case 'setPrice':
                $id=intval($request->input('id'));

                $price=intval($request->input('price'));
                $item=Item::find($id);
                if($item!=null and $price>=0){
                    $item->price=$price;
                    $item->save();
                    return 1;
                }
                return 0;
                break;
        }
    }






}
