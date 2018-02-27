<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserRole;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;

class UsersController extends AdminController
{
    public function home(Request $request){

        $page=1;
        if($request->has('page')){
            $page=$request->input('page');
        }

        $page--;
        $size=50;



        $this->data['users']=User::orderBy('id_role','asc')->skip($page*$size)
            ->take($size)

            ->get();;
        $count=User::all()->count();


        $this->data['current_page']=$page+1;
        $this->data['max_page']=ceil($count/$size);


        return view('admin.listObjects.users',$this->data);
    }
    public function create(Request $request){
        if($request->isMethod('get')){
            $this->data['roles']=UserRole::all();
            return view('admin.createObjects.users',$this->data);
        }
        if($request->isMethod('post')){
            $val=Validator::make($request->all(),[
                'name'=>'required|max:255|min:3',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6|max:255',
                'phone'=>'',

            ]);

            if($val->fails()){
                return redirect(route('admin::users_create'))
                    ->withInput()
                    ->withErrors($val);
            }

            $user=new User();
            $user->name=$request->input('name');
            $user->email=$request->input('email');
            $user->password=bcrypt($request->input('password'));
            $user->phone=$request->input('phone');
            $user->adress=$request->input('adress');
            $user->feature=$request->input('feature');
            $user->id_role=$request->input('id_role');
            $user->is_active=$request->input('is_active');
            $user->save();


            return redirect(route('admin::users_edit',['id'=>$user->id]));
        }

    }
    public function edit($id,Request $request){
        if($request->isMethod('get')){
            $this->data['roles']=UserRole::all();
            $this->data['model']=User::find($id);
            return view('admin.createObjects.users',$this->data);
        }
        if($request->isMethod('post')){

            $user=User::find($id);

            $val=Validator::make($request->all(),[
                'name'=>'required|max:255|min:3',
                'email'=>'required|email|unique:users,email,'.$user->id.',id',
                'password'=>'min:6|max:255',
                'phone'=>'',

            ]);

            if($val->fails()){
                return redirect(route('admin::users_create'))
                    ->withInput()
                    ->withErrors($val);
            }


            $user->name=$request->input('name');
            $user->email=$request->input('email');

            if(strlen($request->input('password'))>5)
                $user->password=bcrypt($request->input('password'));

            $user->phone=$request->input('phone');
            $user->adress=$request->input('adress');
            $user->feature=$request->input('feature');
            $user->id_role=$request->input('id_role');
            $user->is_active=$request->input('is_active');
            $user->save();
            return redirect(route('admin::users_edit',['id'=>$user->id]));


        }

    }
}
