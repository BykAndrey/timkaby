<?php

namespace App\Http\Controllers\Home;

use App\Category;
use App\Comment;
use App\FilterCategory;
use App\InfoPage;
use App\ItemGroup;
use App\ItemGroupImage;
use App\News;
use App\PropertyCategory;
use App\Slide;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Item;
use App\FilterSelect;
use Illuminate\Support\Facades\Mail;
use File;
use App\AdminClass\Tag;
use Cache;


class HomeController extends BaseHomeController
{
    public function home(Request $request){



        $good_item=Item::where('is_active',1)->get();
        $this->data['good_item']=$good_item;
        $this->data['slides']=Slide::all();
        $listBlock=[];

        $cat=Category::where('id_parent',0)->get();

        foreach ($cat as $item)
        {

            $block=[];
            $block['name']=$item->name;
            $block['url']=$item->url;
            $tabs=[];
            $items=Category::getItemsParentCategory($item->id,' order by updated_at desc limit 4');
            if(count($items)>0) {
                $tab = [
                    'name' => 'Новинки',
                    'id' => 'new',
                    'items' => $items
                ];

                $tabs[] = $tab;
            }


            $items=Category::getItemsParentCategory($item->id,'and item.discount !=0  order by updated_at desc limit 4');
            if(count($items)>0){
                $tab=[
                    'name'=>'Скидки',
                    'id'=>'discount',
                    'items'=>  $items
                ];
                $tabs[]=$tab;

            }



            if(count($tabs)>0){
                $block['tabs']=$tabs;

                $listBlock[]=$block;
            }

        }

        //return json_encode($listBlock);

            $this->data['list_block']=$listBlock;
        //return  count($this->data['widget_news']);

        $data=array('text_main_page'=>'');



        $data=json_decode(File::get(public_path('static/home.json')),true);


        $this->data['text_main_page']=isset($data['text_main_page'])?$data['text_main_page']:'';
        $this->data['title_main_page']=isset($data['title'])?$data['title']:'';
        $this->data['seo_description_main_page']=isset($data['title'])?$data['seo_description']:'';





        return view('home.home',$this->data);
    }

    public function base_catalog(Request $request){
        $page=1;
        $size=20;
        $sorting=1;
        if($request->has('page')){
            $page=intval($request->input('page'));
        }


        $page--;
        $is_new="-1";
        if($request->has('is_new')){
            if(intval($request->input('is_new'))==1){
                global $is_new;
                $is_new="0";
            }
        }


        if($request->has('size')){
            $size=intval($request->input('size'));
        }

        if($request->has('sorting')){
            $sorting=intval($request->input('sorting'));
        }
        $ORDER_BY=array();
        switch ($sorting){
            case 1:
                global $ORDER_BY;

                $ORDER_BY=['price','DESC'];
                break;
            case 2: global $ORDER_BY;
                $ORDER_BY=['price','ASC'];
                break;
            case 3: global $ORDER_BY;
                $ORDER_BY=['good_item.rating','DESC'];
                break;
            case 4: global $ORDER_BY;
                $ORDER_BY=['good_item.rating','ASC'];
                break;
        }



        $this->data['list_goods']=DB::table('good_item')
            ->join('good_item_group','good_item.id_good_item_group','=','good_item_group.id')
            ->join('good_category','good_category.id','=','good_item_group.id_good_category')
            ->select('good_item.image',
                'good_item.rating',
                'good_item.url',
                'good_item.name',
                'good_category.url as caturl',
                'good_item.discount',
                'good_item.id',
                'good_item.rating',
                'good_item.price as old_price')
            ->selectRaw('(good_item.price-(good_item.discount*good_item.price)/100) as price')
            ->where('good_item.is_active',1)
            ->where('good_category.is_active',1)
            ->where('good_item.is_new','>',$is_new)
            ->orderBy($ORDER_BY[0],$ORDER_BY[1])
            ->skip($size*$page)
            ->take($size)
            ->get();


        $count=DB::table('good_item')
            ->join('good_item_group','good_item.id_good_item_group','=','good_item_group.id')
            ->join('good_category','good_category.id','=','good_item_group.id_good_category')

            ->where('good_item.is_active',1)
            ->where('good_category.is_active',1)
            ->count();

        $this->data['count_pages']=ceil($count/$size);
        $this->data['current_page']=$page+1;
        $this->data['max_price']=1;
        $this->data['min_price']=1;
        $this->data['good_size']=$size;
        $this->data['good_sorting']=$sorting;
        $this->data['is_new']=$is_new;
        $this->data['count_goods']=$count;

        if(count($this->data['list_goods'])<=0){
            abort(404);
        }

        /**/
        $this->data['title']='Каталог - Timka.by';
        $this->data['name']='Каталог';
        $this->data['description']='Каталог - Timka.by';



        if($is_new=="0"){
            $this->data['title']='Новинки - Timka.by';
            $this->data['name']='Новинки';
            $this->data['description']='Новики товаров - Timka.by';
            $this->addBreadCrumbls("Новинки",route('home::base_catalog',['is_new'=>1]));
        }else{
            $this->addBreadCrumbls("Каталог",route('home::base_catalog'));
        }



        return view('home.base_catalog',$this->data);
    }



    public function catalog($url,Request $request){

        $cat=Category::where('url',$url)->first();
        $good_item=[];
       // echo json_ec($cat);
        if($cat!=null){


            if($cat->id_parent==0){

                $good_item=Category::getItemsParentCategory($cat->id);

            }else{

                $id_parent=intval($cat->id_parent);

                $catS=Category::where('id',$id_parent)->first();

                //echo json_encode($this->data['bread_crumbs']);
                $good_item = ItemGroup::where('id_good_category', $cat->id)->where('is_active', 1)->get();
                $this->addBreadCrumbls($catS->name, route('home::catalog', ['url' => $catS->url]));
            }
            $length=count($good_item);
            $page=1;
            if(!$request->has('page')){
                $page=1;
            }else{
                $page=$request->input('page');
            }


            $this->data['page']=$page;
            $this->data['Cat']=$cat;
            $this->data['subcat']=Category::where('id_parent',$cat->id)->where('is_active',1)->get();
            //$this->data['good_item']=ItemGroup::getListItemGroup_Catalog($cat->id,$page,15);





            $this->addBreadCrumbls($cat->name,route('home::catalog',['url'=>$cat->url]));
         /*   if(!$request->ajax()) {

                return view('home.catalog', $this->data);
            }*/
           // if($request->ajax()){
                $FilterSelectID=null;
                if($request->input('filterSelectID')!=''){
                    $FilterSelectID=$request->input('filterSelectID');
                }





                $page=1;

                if($request->has('page')){
                    $page=$request->input('page');
                }

                $size=20;

                if($request->has('size')){
                    $size=$request->input('size');
                }
                $sortby=1;
                if( $request->has('sortby')){
                    $sortby=$request->input('sortby');
                }
                $rangePrice=[0.01,5000.00];
                $min_price=$request->input('min_price')==null?0:$request->input('min_price');
                $max_price=$request->input('max_price')==null?null:$request->input('max_price');;
                if( $request->has('rangePrice')){
                    $rangePrice=$request->input('rangePrice');
                }
                $ORDER_BY='ORDER BY';
                switch ($sortby){
                    case 1:
                        $ORDER_BY.=' price DESC';
                        break;
                    case 2:
                        $ORDER_BY.=' price ASC';
                        break;
                    case 3:
                        $ORDER_BY.=' rating DESC';
                        break;
                    case 4:
                        $ORDER_BY.=' rating ASC';
                        break;
                }



                $count1=0;
                $a=0;
                $property=[];
                $filters=[];
                $where='and item.price between '.$rangePrice[0].' and '.$rangePrice[1];
                if($cat->id_parent==0){
                    global  $count1;

                    $count1=ItemGroup::getListItemGroup_Catalog_id_base(
                        array(
                            'id'=>$cat->id,
                            'page'=>$page,
                            'size'=>$size,
                            'where'=>$where,
                            'count'=>true,
                            'sortby'=>$ORDER_BY,
                           // 'price'=>$rangePrice,
                            'min_price'=>$min_price,
                            'max_price'=>$max_price
                        ))[0]->count;


                    $list=ItemGroup::getListItemGroup_Catalog_id_base(
                        array(
                            'id'=>$cat->id,
                            'page'=>$page,
                            'size'=>$size,
                            'where'=>$where,
                            'count'=>false,
                            'sortby'=>$ORDER_BY,
                            //'price'=>$rangePrice,
                            'min_price'=>$min_price,
                            'max_price'=>$max_price
                        )
                    );

                }else{


                    /*
                     * Пример $where
                     * так применяются фильтры
                     *
                     *  and fi.id_good_filter_select in (1,2,7,5)
                     * */
                    $where='';
                    global  $count1;

                    $count1=ItemGroup::getListItemGroup_Catalog(array(
                        'id'=>$cat->id,
                        'page'=>$page,
                        'size'=>$page,
                        'fi'=>$FilterSelectID,
                        'count'=>true,
                        'price'=>$rangePrice,
                        'sortby'=>"ORDER BY price ASC",
                        'min_price'=>$min_price,
                        'max_price'=>$max_price
                    ));


                    $list=ItemGroup::getListItemGroup_Catalog(array(
                        'id'=>$cat->id,
                        'page'=>$page,
                        'size'=>$size,
                        'fi'=>$FilterSelectID,
                        'count'=>false,
                        'price'=>$rangePrice,
                        'sortby'=>$ORDER_BY,
                        'min_price'=>$min_price,
                        'max_price'=>$max_price
                    ));


                    $property=PropertyCategory::where('id_good_category',$cat->id)->get();

                    foreach ($property as $item){
                        $f=FilterCategory::where('id_good_property_category',$item->id)->first();
                        if($f!=null){
                            $f->selects=FilterSelect::where('id_good_filter_category',$f->id)->get();
                            $filters[]=$f;
                        }
                    }

                }
                $max_price=0;
                if($cat->id_parent!=0){
                   $ob =DB::table('good_item')
                        ->join('good_item_group','good_item.id_good_item_group','=','good_item_group.id')
                        ->join('good_category','good_category.id','=','good_item_group.id_good_category')
                        ->selectRaw('(good_item.price-(good_item.discount*good_item.price)/100) as price')
                        ->where('good_category.id',$cat->id)
                       ->where('good_item.is_active',1)
                        ->orderBy('good_item.price','DESC')
                        ->first();
                    $max_price=$ob!=null?$ob->price:0;



                    $min=DB::table('good_item')
                        ->join('good_item_group','good_item.id_good_item_group','=','good_item_group.id')
                        ->join('good_category','good_category.id','=','good_item_group.id_good_category')
                        ->selectRaw('(good_item.price-(good_item.discount*good_item.price)/100) as price')
                        ->where('good_category.id',$cat->id)
                        ->where('good_item.is_active',1)
                        ->orderBy('good_item.price','ASC')
                        ->first();

                    $this->data['min_price']=$min!=null?$min->price:0;
                }else{
                    $ob=DB::table('good_item')
                        ->join('good_item_group','good_item.id_good_item_group','=','good_item_group.id')
                        ->join('good_category','good_category.id','=','good_item_group.id_good_category')
                        ->selectRaw('(good_item.price-(good_item.discount*good_item.price)/100) as price')
                        ->where('good_category.id_parent',$cat->id)
                        ->where('good_item.is_active',1)
                        ->orderBy('good_item.price','DESC')
                        ->first();

                    $max_price=$ob!=null?$ob->price:0;




                    $min=DB::table('good_item')
                        ->join('good_item_group','good_item.id_good_item_group','=','good_item_group.id')
                        ->join('good_category','good_category.id','=','good_item_group.id_good_category')
                        ->selectRaw('(good_item.price-(good_item.discount*good_item.price)/100) as price')
                        ->where('good_category.id_parent',$cat->id)
                        ->where('good_item.is_active',1)
                        ->orderBy('good_item.price','ASC')
                        ->first();
                    $this->data['min_price']=$min!=null?$min->price:0;
                }

                $count_pages=ceil($count1/$size);
                if($count_pages<1){
                    $count_pages=1;
                }

                $a=$list;
               // echo $count_pages;
                //echo $page;
                $this->data['list_goods']=$list;
                $this->data['count_pages']=$count_pages;
                $this->data['current_page']=$page;
                $this->data['max_price']=$max_price;
                $this->data['count_goods']=$count1;
            //    $this->data['count_goods']=;
          //      $this->data['min_price']=;
                /*Изменение пути картинки и подгонка размера с помощью  intervention */








                if($request->ajax()){
                    $image_size=$request->input('image_size');

                    foreach ($list as $item) {
                        $item->image=ItemGroup::getImage($item->image,$image_size[0],$image_size[1]);
                        $item->price=sprintf('%.2f',$item->price);
                    }
                    return [
                        'goods'=>$list,
                        'count_pages'=>$count_pages,
                        'current_page'=>$page,
                        'property'=>$property,
                        'filters'=>$filters,
                        'filterSelectId'=>$FilterSelectID,
                        'max_price'=>$max_price
                    ];
                }




                return view('home.catalog',$this->data);
       //     }
        }
        return abort(404);
    }

    public function card($caturl,$url){

        $cat=Category::where('url',$caturl)->where('is_active',1)->first();


        if($cat!=null and $cat->is_active==1){

            $baseCat=Category::where('id',$cat->id_parent)->where('is_active',1)->first();
           if($baseCat!=null){
                $this->addBreadCrumbls($baseCat->name, route('home::catalog', ['url' => $baseCat->url]));
                $this->addBreadCrumbls($cat->name, route('home::catalog', ['url' => $cat->url]));
                $item = DB::table('good_item')
                    ->join('good_brand', 'good_brand.id', '=', 'good_item.id_brand')
                    ->join('good_provider', 'good_provider.id', '=', 'good_item.id_provider')
                    ->select('good_item.*', 'good_brand.name as brand', 'good_provider.name as provider')
                    ->where('good_item.url', $url)
                    ->where('good_item.is_active', 1)
                    ->first();

                // Item::where('url',$url)->first();
            }else{
               abort(404);
            }
            if($item!=null and $item->is_active==1){
                $this->data['good_item']=$item;
                $item_id=$item->id;
                $this->addBreadCrumbls($item->name,route('home::card',['caturl'=>$caturl,'url'=>$item->url]));
                $this->data['item_group_images']=ItemGroupImage::where('id_good_item_group',$item->id_good_item_group)->get();
                /*Похожие товары*/

                $items=DB::table('good_item')
                                            ->join('good_item_group','good_item.id_good_item_group','=','good_item_group.id')
                                            ->join('good_category','good_category.id','=','good_item_group.id_good_category')
                                            ->select('good_item.image',
                                                'good_item.rating',
                                                'good_item.url',
                                                'good_item.name',
                                                'good_category.url as caturl',
                                                'good_item.price as old_price')
                                            ->where('good_item.id','!=',$item->id)
                                            ->where('good_item.is_active',1)
                                            ->where('good_item.id_good_item_group',$item->id_good_item_group)
                                            ->orderBy('good_item.updated_at','desc')
                                            ->get();


                /* Товары одной категории*/
                $this->data['good_same_category']=DB::table('good_item')
                                                    ->join('good_item_group','good_item.id_good_item_group','=','good_item_group.id')
                                                    ->join('good_category','good_category.id','=','good_item_group.id_good_category')
                                                    ->where('good_category.id','=',$cat->id)
                    ->where('good_item.is_active',1)
                    ->select('good_item.id',
                        'good_item.rating',
                        'good_item.name',
                        'good_item.discount',
                        'good_item.url',
                        'good_item.image',
                        'good_category.url as caturl',
                        'good_item.price as old_price')
                    ->selectRaw('(good_item.price-(good_item.discount*good_item.price)/100) as price')
                    ->orderBy('good_item.updated_at','desc')
                    ->limit(4)
                    ->get();

                foreach ($items as $item1) {

                    $item1->image=ItemGroup::getImage($item1->image,180,null);
                }

                $this->data['group_goods']=$items;
               /* $this->data['group_goods']=Item::where('id_good_item_group',$item->id_good_item_group)
                                            ->where('id','!=',$item->id)
                                            ->limit(4)
                                            ->get();

*/
                $allowToComment=false;
               if(Auth::id()!=null)
                    $allowToComment=Comment::where('id_good_item',$item->id)->where('id_user',Auth::id())->first()==null?true:false;


               $this->data['allowToComment']=$allowToComment;




                $page=0;
                $size=5;
                $allCountComments=DB::table('item_comment')
                    ->join('users','users.id','=','item_comment.id_user')
                    ->select('item_comment.comment','item_comment.rating','users.name as user','item_comment.created_at')
                    ->where('item_comment.id_good_item',$item->id)
                    ->where('item_comment.is_active',1)

                    ->count();
               $firstPageComments=DB::table('item_comment')
                   ->join('users','users.id','=','item_comment.id_user')
                   ->select('item_comment.comment','item_comment.rating','users.name as user','item_comment.created_at')
                   ->where('item_comment.id_good_item',$item->id)
                   ->where('item_comment.is_active',1)
                   ->orderBy('item_comment.created_at','desc')
                   ->skip($page*$size)
                   ->take($size)
                   ->get();

                $this->data['comments']=$firstPageComments;
                $this->data['count_comments']=$allCountComments;
                $this->data['PageComment']=ceil($allCountComments/$size);




                //session()->put('last_place',json_encode([]));
                /*Последние посещения*/
               $last_place=DB::table('good_item')
                   ->join('good_item_group','good_item.id_good_item_group','=','good_item_group.id')
                   ->join('good_category','good_category.id','=','good_item_group.id_good_category')

                   ->where('good_item.is_active',1)
                   ->whereIn('good_item.id',(array_values($this->getLastPlace())))
                   ->select('good_item.id',
                       'good_item.rating',
                       'good_item.name',
                       'good_item.discount',
                       'good_item.url',
                       'good_item.image',
                       'good_category.url as caturl',
                       'good_item.price as old_price')
                   ->selectRaw('(good_item.price-(good_item.discount*good_item.price)/100) as price')
                   ->get();

               $arr=[];

                if(count($this->getLastPlace())>0)
                foreach ($this->getLastPlace() as $i){
                  //  echo $i.'<br>';
                        foreach ($last_place as $item){
                            if($item->id==$i){
                                $arr[]=$item;
                            }
                        }
                }
            /*    echo count($last_place).'<br>';
                echo count($arr).'<br>';
                echo count(array_values($this->getLastPlace())).'<br>';*/


                $this->data['last_place']=array_slice(array_reverse($arr),0,4);

        //return        json_decode(json_encode(array_values($this->getLastPlace())));
                $this->addLastPlace($item_id);
                return view('home.card',$this->data);
            }
        }
       // return redirect(route('404'));
        abort(404);
    }




    public  function infopage($url, Request $request){
        //ini_set('memory_limit','-1');
        $page=InfoPage::where('url',$url)->first();
        if($page!=null){
            $this->addBreadCrumbls($page->name,route('infopage',['url'=>$page->url]));
            $this->data['page']=$page;

            return view('home.infopage',$this->data);
        }
        abort(404);
    }

    public function search_page(Request $request){
        $this->addBreadCrumbls('Поиск','');
        $this->data['id_category']=$request->input('id_category');
        $this->data['what_search']=$request->input('what_search');
        return view('home.search_result',$this->data);
    }


    /*NEWS*/
    public function all_news(Request $request){

        $this->addBreadCrumbls('Новости',route('home::all_news'));
        $id_user=Auth::id();
        $user=User::find($id_user);
        $page=1;
        if($request->has('page')){


            if(!is_int(intval($request->input('page')))){
               abort(404);
            }
            $page=intval($request->input('page'));
        }
        $page--;
        $size=3;
        $max_page=0;

        if($user!=null and $user->id_role==0){

            $this->data['news']=News::where('is_active',1)
                ->orderBy('created_at','DESC')
                ->skip($page*$size)
                ->take($size)
                ->get();

            $count=News::where('is_active',1)
                ->orderBy('created_at','DESC')
                ->count();

            $max_page=ceil($count/$size);
            $this->data['max_page']=$max_page;
            $this->data['current_page']=$page+1;

        }else{

            $this->data['news']=News::where('is_active',1)
                ->where('is_open_admin',null)
                ->orderBy('created_at','DESC')
                ->skip($page*$size)
                ->take($size)
                ->get();

            $count=News::where('is_active',1)
                ->where('is_open_admin',null)
                ->orderBy('created_at','DESC')
                ->count();


            $max_page=ceil($count/$size);

            $this->data['max_page']=$max_page;
            $this->data['current_page']=$page+1;
        }

        if($page+1>$max_page and $max_page>0){
            abort(404);
        }

        #echo count($this->data['news']);

        return view('home.news.news',$this->data);
    }

    public function articul($url,Request $request){
        $this->addBreadCrumbls('Новости',route('home::all_news'));
        $id_user=Auth::id();
        $user=User::find($id_user);
        $art=null;


        if($user!=null and $user->id_role==0){

            $art=News::where('url',$url)->first();
        }else{
            $art=News::where('url',$url)->where('is_active',1)->where('is_open_admin',null)->first();
        }

        if($art==null){
            abort(404);
        }



        $this->addBreadCrumbls($art->name,route('home::articul',['url'=>$art->url]));
        $this->data['articul']=$art;
        return view('home.news.articul',$this->data);
    }
    /*END NEWS*/











    public function error404(){
        abort(404);
    }







    public function sitemap(){
        $urlset=new Tag('urlset');

            $urlset->addAttr('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');
            $urlset->addAttr('xmlns:image','http://www.google.com/schemas/sitemap-image/1.1');

        /*BASE*/
        $url=new Tag('url');
            $loc=new Tag('loc','http://timka.by/');
            $url->addTaginTag($loc);

            $changefreq=new Tag('changefreq','daily');
            $url->addTaginTag($changefreq);


            $priority=new Tag('priority','1');
            $url->addTaginTag($priority);


            $urlset->addTaginTag($url);




        /*NEWS*/

        $url=new Tag('url');
            $loc=new Tag('loc','http://timka.by/news');
            $url->addTaginTag($loc);

            $changefreq=new Tag('changefreq','daily');
            $url->addTaginTag($changefreq);


            $priority=new Tag('priority','1');
            $url->addTaginTag($priority);


            $urlset->addTaginTag($url);

       $news=News::where('is_active',1)->get();

        foreach ($news as $item){
            $url=new Tag('url');
                $loc=new Tag('loc','http://timka.by/news/'.$item->url);
                $url->addTaginTag($loc);

                $changefreq=new Tag('changefreq','daily');
                $url->addTaginTag($changefreq);


                $priority=new Tag('priority','1');
                $url->addTaginTag($priority);


                $urlset->addTaginTag($url);
        }



        //Категории

       $cat=Category::where('is_active',1)->get();


        foreach ($cat as $item){
            $url=new Tag('url');
            $loc=new Tag('loc','http://timka.by/catalog/'.$item->url);
            $url->addTaginTag($loc);

            $changefreq=new Tag('changefreq','daily');
            $url->addTaginTag($changefreq);


            $priority=new Tag('priority','1');
            $url->addTaginTag($priority);


            $urlset->addTaginTag($url);
        }

        $goods= DB::table('good_item')
            ->join('good_item_group','good_item_group.id','=','good_item.id_good_item_group')
            ->join('good_category','good_category.id','=','good_item_group.id_good_category')
            ->select('good_item.name','good_item.image','good_item.url as gurl','good_category.url as curl')
            ->where('good_item.is_active',1)
            ->where('good_category.is_active',1)
            ->get();

        foreach ($goods as $item){
            $url=new Tag('url');
            $loc=new Tag('loc','http://timka.by/catalog/'.$item->curl.'/'.$item->gurl);
            $url->addTaginTag($loc);

            $changefreq=new Tag('changefreq','daily');
            $url->addTaginTag($changefreq);


            $priority=new Tag('priority','1');
            $url->addTaginTag($priority);

                $image=new Tag('image:image');
                $image->addTaginTag(new Tag('image:loc','http://timka.by/static/imagesItem/'.$item->image));
                $image->addTaginTag(new Tag('image:title',$item->name));
                $url->addTaginTag($image);

            $urlset->addTaginTag($url);
        }


        return response('<?xml version="1.0" encoding="UTF-8"?>'.$urlset->printTag())->header('Content-Type', 'text/xml');
    }





    //YML
    public function yml(Request $request){
        $yml=new Tag('yml-catalog');
        $yml->addAttr('date',date('Y-m-d G:i'));

        $shop=new Tag('shop');
            $shop->addTaginTag(new Tag('name','timka.by'));
            $shop->addTaginTag(new Tag('company','ИП Савченко Мария Сергеевна'));
            $shop->addTaginTag(new Tag('url','http://timka.by'));
            $shop->addTaginTag(new Tag('version','0.1'));
            $shop->addTaginTag(new Tag('agency','Andrey Byk'));
            $shop->addTaginTag(new Tag('email','andreybyk9606@gmail.com'));

        $cur=new Tag('currencies');
            $cur1=new Tag('currency');
            $cur1->addAttr('id','BYN');
            $cur1->addAttr('rate','1');

            $cur->addTaginTag($cur1);
        $shop->addTaginTag($cur);

        $categories=Category::where('is_active',1)->get();

        $cats=new Tag('categories');

        foreach ($categories as $item){
            $cat=new Tag('category',$item->name);


                $cat->addAttr('id',$item->id);
                if($item->id_parent!=0){
                    $cat->addAttr('parentId',$item->id_parent);
                }

            $cats->addTaginTag($cat);
        }
        $shop->addTaginTag($cats);


        $goods= DB::table('good_item')
            ->join('good_item_group','good_item_group.id','=','good_item.id_good_item_group')
            ->join('good_category','good_category.id','=','good_item_group.id_good_category')
            ->select('good_item.name',
                'good_item.image',
                'good_item.url as gurl',
                'good_category.url as curl',
                'good_category.id as id_cat',
                'good_item.id as id',
                'good_item.price as price',
                'good_item.articul',
                'good_item.description')
            ->where('good_item.is_active',1)
            ->where('good_category.is_active',1)
            ->get();

        $offers=new Tag('offers');

        foreach ($goods as $good) {
            $offer=new Tag('offer');
                $offer->addAttr('id',$good->id);
                $offer->addAttr('available','true');

                $url=new Tag('url','http://timka.by/catalog/'.$good->curl.'/'.$good->gurl);
                $offer->addTaginTag($url);

            $offer->addTaginTag(new Tag('price',$good->price));
            $offer->addTaginTag(new Tag('currencyId','BYN'));
            $offer->addTaginTag(new Tag('categoryId',$good->id_cat));

            $offer->addTaginTag(new Tag('picture','http://timka.by/static/imagesItem/'.$good->image));


            $offer->addTaginTag(new Tag('delivery','true'));
            $offer->addTaginTag(new Tag('name',$good->name));

            $offer->addTaginTag(new Tag('vendorCode',$good->articul));


            $desc=new Tag('description',htmlspecialchars($good->description));
           // $desc->date=;
            $offer->addTaginTag($desc);



            $offers->addTaginTag($offer);
        }
        $shop->addTaginTag($offers);



        $yml->addTaginTag($shop);
        return response('<?xml version="1.0" encoding="UTF-8"?>'.$yml->printTag())->header('Content-Type', 'text/xml');

    }
}
