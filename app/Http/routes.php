<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['namespace'=>'Admin','as'=>'admin::','prefix'=>'admin','middleware'=>'admin'],function (){

    Route::match(['post','get'],'/','AdminController@homepage')->name('home');
    Route::get('/loadxml','AdminController@loadxml')->name('loadxml');
    Route::match(['post','get'],'/load_goods','AdminController@load_goods')->name('load_goods');
    //sRoute::match(['post','g,'AdminController@load_goods')->name('admin_ajax');



    Route::group(['prefix'=>'category'],function (){
        Route::get('/','CategoryController@home')->name('good_category');
        Route::match(['get','post'],'/create','CategoryController@create')->name("good_category_create");
        Route::match(['get','post'],'/edit/{id}','CategoryController@edit')->name("good_category_edit");
        Route::match(['get','post'],'/delete/{id}','CategoryController@delete')->name("good_category_delete");
        /*AJAX*/
        Route::match(['get','post'],'/ajax','CategoryController@ajax')->name('ajax_category');
    });

    Route::group(['prefix'=>'itemgroup'],function () {
        Route::get('/', 'ItemGroupController@home')->name('good_item_group');
        Route::match(['get','post'],'/create','ItemGroupController@create')->name("good_item_group_create");
        Route::match(['get','post'],'/edit/{id}','ItemGroupController@edit')->name("good_item_group_edit");
        Route::match(['get','post'],'/delete/{id}','ItemGroupController@delete')->name("good_item_group_delete");

        Route::get('/getlistitem/{id}','ItemGroupController@getListItem')->name('good_item_group_listItem');
        Route::get('/getobject/{id}','ItemGroupController@getObject')->name('good_item_group_object');


        /*AJAX*/
        Route::match(['get','post'],'/ajax','ItemGroupController@ajax')->name('ajax_item');
    });

    Route::group(['prefix'=>'item'],function () {
        Route::get('/', 'ItemController@home')->name('good_item');
        Route::match(['get','post'],'/create','ItemController@create')->name("good_item_create");
        Route::match(['get','post'],'/edit/{id}','ItemController@edit')->name("good_item_edit");
        Route::match(['get','post'],'/delete/{id}','ItemController@delete')->name("good_item_delete");

        /*AJAX*/
        Route::match(['get','post'],'/ajax','ItemController@ajax')->name('ajax_good_item');

    });

    Route::group(['prefix'=>'properycategory'],function () {
       // Route::get('/', 'PropertyCategoryController@home')->name('good_property_category');
        Route::match(['get','post'],'/create','PropertyCategoryController@create')->name("good_property_category_create");

        Route::match(['get'],'/getlist/{id}','PropertyCategoryController@getList')->name("good_property_category_ajax_list");

        Route::match(['get','post'],'/edit/{id}','PropertyCategoryController@edit')->name("good_property_category_edit");

        Route::match(['get'],'/delete/{id}','PropertyCategoryController@delete')->name("good_property_category_delete");
        // /admin/properycategory/delete/
    });


    Route::group(['prefix'=>'filtercategory'],function () {
        Route::match(['get','post'],'/create','FilterCategoryController@create')->name('good_filter_category_create');
        Route::match(['get','post'],'/edit/{id}','FilterCategoryController@edit')->name('good_filter_category_edit');
        Route::match(['get','post'],'/createbyprop/{id}','FilterCategoryController@createbyprop')->name('good_filter_category_create_by_prop');
        Route::get('/delete/{id}','FilterCategoryController@delete')->name('good_filter_category_delete');



        Route::get('/getselectlist/{id}','FilterCategoryController@getListFilterSelect')->name('good_filter_category_getlistfilterselect');
        Route::get('/deleteselectlistitem/{id}','FilterCategoryController@deleteFilterSelectItem')->name('good_filter_category_deletefilterselectitem');

        Route::get('/addselectlistitem','FilterCategoryController@addFilterSelectItem')->name('good_filter_category_addfilterselectitem');
        Route::get('/saveselectlistlist','FilterCategoryController@saveFilterSelectList')->name('good_filter_category_savefilterselectlist');

    });






   Route::group(['prefix'=>'properyitem'],function () {
       Route::get('/json','PropertyItemController@getJsonData')->name('json');
       // Route::get('/', 'PropertyItemController@home')->name('good_property_item');
      // Route::match(['get','post'],'/create','PropertyItemController@create')->name("good_property_item_create");
       // Route::match(['get'],'/getlist/{id}','PropertyItemController@getList')->name("good_property_item_ajax_list");
        Route::match(['get','post'],'/edit/{id}','PropertyItemController@edit')->name("good_property_item_edit");
        Route::match(['get'],'/delete/{id}','PropertyItemController@delete')->name("good_property_item_delete");
        // /admin/properycategory/delete/
    });



    Route::group(['prefix'=>'provider'],function(){
        Route::get('/','ProviderController@home')->name('good_provider');
        Route::match(['get','post'],'/create','ProviderController@create')->name("good_provider_create");
        Route::match(['get','post'],'/edit/{id}','ProviderController@edit')->name("good_provider_edit");
        Route::match(['get','post'],'/delete/{id}','ProviderController@delete')->name("good_provider_delete");
    });

    Route::group(['prefix'=>'brand'],function(){
        Route::get('/','BrandController@home')->name('good_brand');
        Route::match(['get','post'],'/create','BrandController@create')->name("good_brand_create");
        Route::match(['get','post'],'/edit/{id}','BrandController@edit')->name("good_brand_edit");
        Route::match(['get','post'],'/delete/{id}','BrandController@delete')->name("good_brand_delete");
    });


    Route::group(['prefix'=>'infopage'],function(){
        Route::get('/','InfoPageController@home')->name('info_page');
        Route::match(['get','post'],'/create','InfoPageController@create')->name("info_page_create");
        Route::match(['get','post'],'/edit/{id}','InfoPageController@edit')->name("info_page_edit");
        Route::match(['get','post'],'/delete/{id}','InfoPageController@delete')->name("info_page_delete");
    });

    Route::group(['prefix'=>'slide'],function(){
        Route::get('/','SlideController@home')->name('slide');

        Route::match(['get','post'],'/create','SlideController@create')
            ->name("slide_create");

        Route::match(['get','post'],'/edit/{id}','SlideController@edit')
            ->name("slide_edit");

        Route::match(['get','post'],'/delete/{id}','SlideController@delete')
            ->name("slide_delete");
    });


    Route::group(['prefix'=>'option_delivery'],function(){
        Route::get('/','OptionDeliveryController@home')->name('option_delivery');
        Route::match(['get','post'],'/create','OptionDeliveryController@create')->name("option_delivery_create");

        Route::match(['get','post'],'/edit/{id}','OptionDeliveryController@edit')
            ->name("option_delivery_edit");

        Route::match(['get','post'],'/delete/{id}','OptionDeliveryController@delete')
            ->name("option_delivery_delete");
    });


    Route::group(['prefix'=>'item_comment'],function(){
        Route::get('/','CommentController@home')->name('item_comment');
        Route::match(['get','post'],'/ajax','CommentController@ajax')->name("item_comment_ajax");


    });

    Route::group(['prefix'=>'news'],function(){
        Route::get('/','NewsController@home')->name('news');

        Route::match(['get','post'],'/create','NewsController@create')->name("news_create");

        Route::match(['get','post'],'/edit/{id}','NewsController@edit')
            ->name("news_edit");

        Route::match(['get','post'],'/delete/{id}','NewsController@delete')
            ->name("news_delete");
    });



    Route::group(['prefix'=>'users'],function(){
        Route::get('/','UsersController@home')->name('users');

        Route::match(['get','post'],'/create','UsersController@create')
            ->name("users_create");

        Route::match(['get','post'],'/edit/{id}','UsersController@edit')
            ->name("users_edit");

        Route::match(['get','post'],'/delete/{id}','UsersController@delete')
            ->name("users_delete");
    });


});


/*User routers*/
Route::group(['namespace'=>'Auth','as'=>'user::'],function (){
    Route::match(['post','get'],'/registrarion','AuthController@registrarion')->name("registration");
    Route::match(['post','get'],'/login','AuthController@login')->name('login');
    Route::get('/socialauth/{social}/{action?}','AuthController@social')->name('social');
    Route::get('/vk/{action?}','AuthController@vk');


    Route::group(['middleware'=>'auth'],function (){
        Route::get('/logout','AuthController@logout')->name('logout');
        Route::get('/profile','UserController@profile')->name('profile');
        Route::match(['get','post'],'/profile/changepassword/','UserController@changepassword')
            ->name('changepassword');
        Route::get('/profile/orders','UserController@listOrders')->name('orders');




        Route::get('/profile/allorders','UserController@allListOrders')->name('allorders')->middleware('admin');



        Route::get('/profile/orders/{id}','UserController@itemsorder')->name('myorder');
        Route::post('/profile/orders/save','UserController@orderState')->name('orderState');


        Route::get('/profile/like-good/','UserController@listLikeGood')->name('like-good');

        Route::post('/user_ajax',"UserController@ajax")->name('user_ajax');
    });


});

/*Order routers*/
Route::group(['namespace'=>'Home','as'=>'cart::'],function (){
    Route::get('/cart','CartController@home')->name('home');
    Route::match(['get','post'],'/cart/create-order','CartController@createOrder')->name('create_order');
    Route::get('/cart/thank','CartController@thank')->name('thank');
    Route::get('/cart/cart_add','CartController@add_to_cart')->name('add');


    Route::get('/clearcart','CartController@clear_cart')->name('clearcart');
    Route::get('/cart/ajax','CartController@cart_ajax');
});




/*HOME ROUTES*/
Route::group(['namespace'=>'Home','as'=>'home::'],function (){
    Route::match(['get','post'],'/ajax','HomeAjaxController@action')->name('ajax_action');
    Route::get('/catalog','HomeController@base_catalog')->name('base_catalog');
    Route::get('/catalog/{url}','HomeController@catalog')->name('catalog');
    Route::get('/catalog/{caturl}/{url}','HomeController@card')->name('card');


    /*NEWS */
    Route::get('/news','HomeController@all_news')->name('all_news');
    Route::get('/news/{url}','HomeController@articul')->name('articul');

});


Route::get('/404','Home\HomeController@error404')->name('404');
Route::get('/sitemap','Home\HomeController@sitemap')->name('sitemap');
Route::get('/yml','Home\HomeController@yml')->name('yml');

Route::get('/search','Home\HomeController@search_page')->name('search');
Route::get('/{url}','Home\HomeController@infopage')->name('infopage');
Route::get('/','Home\HomeController@home')->name('home');
