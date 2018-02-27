<?php
namespace App\Http\Controllers\Admin;

use Validator;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\News;
class NewsController extends AdminController
{
    public $valid=[
        'name'=>'required|min:10|max:255',
        'title'=>'required|min:10|max:255',
        'url'=>'required|min:10|max:255|unique:news',
        'content'=>'required',
        'meta_description'=>'required',
        'image'=>'mimes:jpeg,png,jpg,gif|max:2048'
    ];
    public function __construct()
    {
        parent::__construct();
        $this->addBreadCrumbls('Новости',route('admin::news'));
    }

    public function home(Request $request){
        // $items=Item::admin_getList();

        $page=1;
        if($request->has('page')){
            $page=$request->input('page');
        }

        $page--;
        $size=10;




        $this->data['news']=News::orderBy('created_at','DESC')->skip($page*$size)
            ->take($size)
            ->get();




        $count=News::all()->count();

        $this->data['current_page']=$page+1;
        $this->data['max_page']=ceil($count/$size);
        return view('admin.listObjects.news',$this->data);
    }
    public function create(Request $request){
        if($request->isMethod('get')){
            $this->addBreadCrumbls('Создание Новости',route('admin::news_create'));
            return view('admin.createObjects.news',$this->data);
        }
        if($request->isMethod('post')){
            $val=Validator::make($request->all(),$this->valid);
            if($val->fails()){
                return redirect(route('admin::news_create'))
                    ->withInput()
                    ->withErrors($val);
            }


            $news=new News();


            $news->name=$request->input('name');
            $news->title=$request->input('title');
            $news->url=$request->input('url');
            $news->content=$request->input('content');
            $news->meta_description=$request->input('meta_description');
            $news->is_active=$request->input('is_active');
            $news->is_open_admin=$request->input('is_open_admin');



            if($request->file('image')){
                $news->image=$this->uploadImage(BaseAdminController::$pathImageNews,$request->file('image'));
            }

            $news->save();


            return redirect(route('admin::news_edit',['id'=>$news->id]));

        }
    }
    public function  edit($id,Request $request){
        if($request->isMethod('get')){

            $news=News::where('id',intval($id))->first();
            $this->addBreadCrumbls('Редактирование Новости',route('admin::news_edit',['id'=>$id]));
            if($news!=null){
                $this->data['model']=$news;
                return view('admin.editObjects.news',$this->data);
            }

        }
        if($request->isMethod('post')){
            $this->valid['url']='required|min:10|max:255|unique:news,url,'.$id.',id';
            $val=Validator::make($request->all(),$this->valid);
            if($val->fails()){
                return redirect(route('admin::news_edit',['id'=>$id]))
                    ->withInput()
                    ->withErrors($val);
            }


            $news=News::where('id',intval($id))->first();

            if($news!=null){
                $news->name=$request->input('name');
                $news->title=$request->input('title');
                $news->url=$request->input('url');
                $news->content=$request->input('content');
                $news->meta_description=$request->input('meta_description');
                $news->is_active=$request->input('is_active');
                $news->is_open_admin=$request->input('is_open_admin');
                #echo $request->input('is_active');
                #echo $news->is_active;

                if($request->file('image')){
                    $news->image=$this->uploadImage(BaseAdminController::$pathImageNews,$request->file('image'));
                }


                $news->save();


                return redirect(route('admin::news_edit',['id'=>$news->id]));
            }


        }
    }
    public function  delete($id,Request $request){
        if($request->isMethod('get')){
            $this->data['route']=route('admin::news_delete',['id'=>$id]);
            $this->data['name']=Category::where('id',$id)->first()->name;
            return view('admin.sure',$this->data);
        }
        if($request->isMethod('post')){
            $item=Category::where('id',$id)->first();
            if($item){
                $item->delete();
                return redirect(route('admin::news'));
            }
            return 'Error';
        }
    }

}
