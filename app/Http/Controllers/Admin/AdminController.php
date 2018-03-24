<?php

namespace App\Http\Controllers\Admin;

use App\AdminClass\Register;
use App\Category;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Item;
use App\PropertyItem;
use App\Http\Requests;

use Illuminate\Support\Facades\Input;
use App\ItemGroup;
use App\PropertyCategory;
use App\FilterSelect;
use App\FilterItem;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\Facades\Image;
use Symfony\Component\HttpKernel\Client;


use File;

class AdminController extends BaseAdminController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function homepage(Request $request){
        if($request->isMethod('get')){
            $list=DB::table('good_category')->get();
            $data=array('text_main_page'=>'');



            $data=json_decode(File::get(public_path('static/home.json')),true);


            $this->data['text_main_page']=isset($data['text_main_page'])?$data['text_main_page']:'';
            $this->data['seo_description']=isset($data['seo_description'])?$data['seo_description']:'';
            $this->data['main_title']=isset($data['title'])?$data['title']:'';

            return view('admin/home',$this->data);
        }

       if($request->isMethod('post')){
            $maintext=$request->input('text_main_page');
            $main_seo_desc=$request->input('seo_description');
            $main_title=$request->input('title');

            $data=array('text_main_page'=>$maintext,'title'=>$main_title,'seo_description'=>$main_seo_desc);

           File::put(public_path('static/home.json'),json_encode($data));
           return redirect(route('admin::home'));
       }
    }





    public function loadxml(Request $request){

       /* $client=new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://sorvanec.by/test2.php');
        $ar=\GuzzleHttp\json_decode($res->getBody(),true);
        File::put(public_path('static/category.json'),json_encode($ar,True));
*/
        $ar=json_decode(File::get(public_path('static/category.json')));

        $count=0;
        for($i=0; $i<count($ar)-1;$i++){



                if($ar[$i][4]==0) {


                    if(Category::where('name',trim($ar[$i][2]))->first()==null){
                        //echo $ar[$i][2].'<br>';
                        //global $ar;
                        $count++;
                        $category = new Category();
                        $category->name = $ar[$i][2];
                        $category->title = $ar[$i][2];
                        $category->url = $this->url_slug($ar[$i][2], array('transliterate' => true));
                        $category->is_active=1;
                        $category->save();
                        for($j=0; $j<count($ar)-1;$j++){
                            if($ar[$j][4]==$ar[$i][3]){
                               // global $ar;
                                $ar[$j][4]==$category->id;
                               // echo '<<<----'.$ar[$j][4].'----->';
                            }
                        }

                       $ar[$i][3]=$category->id;


                    }else{

                        $ar[$i][3]=Category::where('name',trim($ar[$i][2]))->first()->id;
                        for($j=0; $j<count($ar)-1;$j++){
                            if($ar[$j][1]==$ar[$i][0]){
                                // global $ar;
                              //  echo '<<<----'.$ar[$j][4].'------';
                                $ar[$j][4]=$ar[$i][3];
                                // echo ''.$ar[$j][4].'-----><br>';
                            }
                        }
                       // echo $ar[$i][3].'<br>';
                       // echo '<<<----'.json_encode($ar[$i]).'----->';
                    }


                }

        }


        for($j=0; $j<count($ar)-1;$j++){
            $id_parent=null;
            foreach ($ar as $item){
                if($ar[$j][1]==$item[0] and $item[1]==0){
                    global $id_parent;
                    $id_parent=$item[3];
                }
            }
            if ($id_parent!=null)
                if($id_parent==$ar[$j][4]) {

                    if(Category::where('name',trim($ar[$j][2]))->first()==null)
                    {
                        //  echo '=>'.$ar[$j][2].'<br>';
                        $count++;
                        $child = new Category();
                        $child->id_parent = $id_parent;
                        $child->name = $ar[$j][2];
                        $child->title = $ar[$j][2];
                        $child->url = $this->url_slug($ar[$j][2], array('transliterate' => true));
                        $child->is_active=1;
                        $child->save();
                        $ar[$j][3]=$child->id;
                        $ar[$j][4]=$id_parent;
                    }else{

                        $ar[$j][3]=Category::where('name',trim($ar[$j][2]))->first()->id;
                        //  echo '=>'.$ar[$j][3].'<br>';
                    }
                }
        }













        //Storage::put('static/category.json', json_encode($ar,true));
        //$ar[0][5]="10";
       // return json_encode($ar);
        File::put(public_path('static/category.json'),json_encode($ar,true));
        return json_decode(json_encode($ar,true),true);
    }


    public function load_goods(Request $request){
        if($request->isMethod('post')){


            //return $request->input('name').'   '.$request->input('id_good_category');

            $name=trim($request->input('name'));
            echo $name;
            $uri='https://sorvanec.by/test3.php?name='.$name;
            echo  $uri;
            $client=new \GuzzleHttp\Client();
            $res = $client->request('GET', 'https://sorvanec.by/test3.php?name='.$name);
            $goods=\GuzzleHttp\json_decode($res->getBody(),true);


          /*

            File::put(public_path('static/goods.json'),json_encode($goods,True));
            $goods=json_decode(File::get(public_path('static/goods.json')));

          */
            echo count($goods);
            foreach ($goods as $g){
                                $igr=new ItemGroup();

                                $igr->id_good_category=intval($request->input('id_good_category'));

                                $igr->name=$g[1];

                                $igr->title=$g[1];

                                $igr->url=$this->url_slug($g[1], array('transliterate' => true));

                                $igr->articul=$g[2];

                                $igr->id_brand=1;

                                $igr->id_provider=1;

                                $igr->price=$g[5];

                                $igr->description=$g[6];

                                $igr->is_active=1;

                                $igr->discount=0;
                                $url = "https://sorvanec.by/images/baby_shop/goods/".$g[7];
                                $name=time();
                                $type=explode('.',$g[7])[1];
                                //$filename = basename($url);
                                if(!file_exists('static/imagesItem/'.$name.'.'.$type)){
                                }else{
                                    sleep(1);
                                    $name=time();
                                }
                                $igr->image=$name.'.'.$type;
                                $igr->save();

                                if(Image::make($url)->save(public_path('static/imagesItem/' . $name.'.'.$type))){
                                    echo  '<br> Image loaded';
                                    echo '<br>'.$igr->image;
                                }
                                $url="";
                                $name="";
                                $type="";


                    //////////////////////////////////////////
                                $i=new Item();

                                $i->id_good_item_group=$igr->id;

                                $i->name=$g[1];

                                $i->title=$g[1];

                                $i->url=$this->url_slug($g[1], array('transliterate' => true));

                                $i->articul=$g[2]==''?$g[1]:$g[2];

                                $i->id_brand=1;

                                $i->id_provider=2;

                                $i->price=$g[5];

                                $i->description=$g[6];

                                $i->meta_description='';

                                $i->is_active=0;
                                $i->is_hot=0;
                                $i->is_new=1;

                                $i->discount=0;


                                $i->image=$igr->image;
                                $i->save();
                                $i=null;
                                $igr=null;





            }

            $items=Item::all();
            foreach ($items as $item) {
                $item->meta_description='';
                $item->save();

            }

       //     File::put(public_path('static/goods.json'),json_encode($goods,true));
        }
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


            $this->data['category_list']=$select_cat;


            return view('admin.import_sorvanec',$this->data);
        }

    }














/*
$url = "https://sorvanec.by/cache/3161064bb13c4fdfc75aabba440ab68f_w400.jpg";

$filename = basename($url);

Image::make($url)->save(public_path('static/' . 'img.jpg'));*/


    function url_slug($str, $options = array()) {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => false,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }

    }

























    /*
     *
     *
     *
     * $client=new \GuzzleHttp\Client();
            $res = $client->request('GET', 'https://sorvanec.by/test3.php&name='.$request->input('name'));
            $goods=\GuzzleHttp\json_decode($res->getBody(),true);
            File::put(public_path('static/goods.json'),json_encode($goods,True));

            $goods=json_decode(File::get(public_path('static/goods.json')));

            $category=json_decode(File::get(public_path('static/category.json')));

            foreach ($goods as $g){

                foreach ($category as $c){
                    if($g[3]==$c[0]){
                        // echo $g[1].'--'.$c[1].'<br>';
                        //echo  $c[3];
                        if(Category::where('id',$c[3])->first()!=null){

                            if(!isset($g[8]) or ItemGroup::where('id',$g[8])->first()==null){

                                $igr=new ItemGroup();

                                $igr->id_good_category=intval($c[3]);

                                $igr->name=$g[1];

                                $igr->title=$g[1];

                                $igr->url=$this->url_slug($g[1], array('transliterate' => true));

                                $igr->articul=$g[2];

                                $igr->id_brand=1;

                                $igr->id_provider=2;

                                $igr->price=$g[5];

                                $igr->description=$g[6];

                                $igr->is_active=1;

                                $igr->discount=0;


                                $url = "https://sorvanec.by/images/baby_shop/goods/".$g[7];
                                $name=time();
                                $type=explode('.',$g[7])[1];
                                //$filename = basename($url);

                                Image::make($url)->save(public_path('static/imagesItem/' . $name.'.'.$type));

                                $igr->image=$name.'.'.$type;
                                $igr->save();

                                $g[8]=$igr->id;
                            }


                        }


                    }
                }
            }
            File::put(public_path('static/goods.json'),json_encode($goods,true));


    */