<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\InfoPage;
use App\Http\Requests;
use Validator;
class InfoPageController extends BaseAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->addBreadCrumbls('Информационные страницы',route('admin::info_page'));
    }
    public function home(Request $request){
        // $items=Item::admin_getList();

        $page=1;
        if($request->has('page')){
            $page=$request->input('page');
        }

        $page--;
        $size=10;




        $this->data['items']=InfoPage::orderBy('updated_at','DESC')
            ->skip($page*$size)
            ->take($size)
            ->get();

        $count=InfoPage::all()->count();

        $this->data['current_page']=$page+1;
        $this->data['max_page']=ceil($count/$size);


        return view('admin.listObjects.info_page',$this->data);
    }
    public function create(Request $request){
        if($request->isMethod('get')){
            return view('admin.createObjects.info_page',$this->data);
        }
        if($request->isMethod('post')){
            $valid=Validator::make($request->all(),
                [
                    'title'=>'required|max:90|min:3',
                    'name'=>'required|max:90|min:3',
                    'url'=>'required|max:90|min:3',
                    'content'=>'required',
                    'meta_description'=>'required',
                ]);
                if($valid->fails()){
                    return redirect(route('admin::info_page_create'))
                        ->withErrors($valid)
                        ->withInput();
                }

            $info_page=new InfoPage();
            $info_page->title=$request->input('title');
            $info_page->name=$request->input('name');
            $info_page->url=$request->input('url');
            $info_page->content=$request->input('content');
            $info_page->meta_description=$request->input('meta_description');
            $info_page->is_active=$request->input('is_active');
            $info_page->weight=$request->input('weight');
            $info_page->save();
            return redirect(route('admin::info_page_edit',['id'=>$info_page->id]));
        }

    }




    public  function  edit($id, Request $request){
        if($request->isMethod('get')){
            $page=InfoPage::find($id);
            if($page!=null) {
                $this->data['model'] = $page;
                return view('admin.editObjects.info_page', $this->data);
            }
            return 'Error';
        }
        if($request->isMethod('post')){
            $valid=Validator::make($request->all(),
                [
                    'title'=>'required|max:90|min:3',
                    'name'=>'required|max:90|min:3',
                    'url'=>'required|max:90|min:3',
                    'content'=>'required',
                    'meta_description'=>'required',
                ]);
            if($valid->fails()){
                return redirect(route('admin::info_page_create'))
                    ->withErrors($valid)
                    ->withInput();
            }

            $page=InfoPage::find($id);
            if($page!=null) {



                $page->title=$request->input('title');
                $page->name=$request->input('name');
                $page->url=$request->input('url');
                $page->content=$request->input('content');
                $page->meta_description=$request->input('meta_description');
                $page->is_active=$request->input('is_active');
                $page->weight=$request->input('weight');
                $page->save();


                return redirect(route('admin::info_page_edit',['id'=>$page->id]));
            }

        }
    }


    public function  delete($id,Request $request){
        if($request->isMethod('get')){
            $this->data['route']=route('admin::info_page_delete',['id'=>$id]);
            $this->data['name']=InfoPage::where('id',$id)->first()->name;
            return view('admin.sure',$this->data);
        }
        if($request->isMethod('post')){
            $item=InfoPage::where('id',$id)->first();
            if($item){
                $item->delete();
                return redirect(route('admin::info_page'));
            }
            return 'Error';
        }
    }

}
