<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 11/16/17
 * Time: 6:19 AM
 */
namespace  App\AdminClass;

class Register
{
        public static function getTables(){
            return [
                [
                    'place'=>1,
                    'class'=>'Category',
                    'templateName'=>'Категории',
                    'route'=>route('admin::good_category')
                ],
                [
                    'place'=>1,
                    'class'=>'ItemGroup',
                    'templateName'=>'Товар',
                    'route'=>route('admin::good_item_group')
                ],
                [
                    'place'=>1,
                    'class'=>'Item',
                    'templateName'=>'Предложение',
                    'route'=>route('admin::good_item')
                ],
                [
                    'place'=>1,
                    'class'=>'Provider',
                    'templateName'=>'Поставщик',
                    'route'=>route('admin::good_provider')
                ],
                [
                    'place'=>1,
                    'class'=>'Brand',
                    'templateName'=>'Бренды',
                    'route'=>route('admin::good_brand')
                ],
                [
                    'place'=>2,
                    'class'=>'InfoPage',
                    'templateName'=>'Информационные страницы',
                    'route'=>route('admin::info_page')
                ],
                [
                    'place'=>2,
                    'class'=>'Slide',
                    'templateName'=>'Слайды',
                    'route'=>route('admin::slide')
                ],
                [
                    'place'=>2,
                    'class'=>'OptionDelivery',
                    'templateName'=>'Способы доставки',
                    'route'=>route('admin::option_delivery')
                ],

                [
                    'place'=>3,
                    'class'=>'Comment',
                    'templateName'=>'Комментарии',
                    'route'=>route('admin::item_comment')
                ],
                [
                    'place'=>2,
                    'class'=>'News',
                    'templateName'=>'Новости',
                    'route'=>route('admin::news')
                ],
                [
                    'place'=>3,
                    'class'=>'Users',
                    'templateName'=>'Пользователи',
                    'route'=>route('admin::users')
                ]

            ];

        }
        public static  function getMenu(){
            return [
                [
                    'weight'=>1,
                    'name'=>'Контакты',
                    'url'=>route('infopage',['url'=>'kontakty'])
                ],
                [
                    'weight'=>3,
                    'name'=>'О магазине',
                    'url'=>route('infopage',['url'=>'o-magazine'])
                ]
                ,
                [
                    'weight'=>2,
                    'name'=>'Гарантии и возврат',
                    'url'=>route('infopage',['url'=>'garantii-i-vozvrat'])
                ],
                [
                    'weight'=>2,
                    'name'=>'Новости',
                    'url'=>route('home::all_news')
                ]
            ];
        }
}