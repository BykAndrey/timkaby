<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\AdminClass;


class BaseAdminController extends Controller{
    public $data=[];
    public $pathImage='static/imagesItem';
    public static $pathslideImage='static/slideImage';
    public static  $pathImageNews='static/newsImage';

    public function __construct(){
        $this->data['header_menu']=AdminClass\Register::getTables();
        $this->data['bread_crumbs']=[
            'Главная'=>route('admin::home')
        ];

    }
    protected function addBreadCrumbls($key,$value){
        $bread=$this->data['bread_crumbs'];
        $bread[$key]=$value;
        $this->data['bread_crumbs']=$bread;
    }

    public static function uploadImage($path='static',$file){
            $name=time();
            $type= $file->getClientOriginalExtension();
            $file->move($path.'/',$name.'.'.$type);
            return $name.'.'.$type;

    }

}