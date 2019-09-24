import Vue    from 'vue';
import Router from 'vue-router';


import main   from  '../components/Main.vue';
import categories_list    from  '../components/categories/List.vue';
import categories_reorder from  '../components/categories/Reorder.vue';
import categories_save    from  '../components/categories/Save.vue';

import attributes_list    from  '../components/attributes/List.vue';
import attributes_save    from  '../components/attributes/Save.vue';

import attributes_sets_list    from  '../components/attributes-sets/List.vue';
import attributes_sets_save    from  '../components/attributes-sets/Save.vue';

import products_list    from  '../components/products/List.vue';
import products_save    from  '../components/products/Save.vue';


import import_export  from '../components/import-export/Import-export.vue';


import reviews    from  '../components/reviews/reviews.vue';
import questions_answers    from  '../components/questions-answers/QuestionsAnswers.vue';


import users_list from  '../components/users/List.vue';
import users_save from  '../components/users/Save.vue';

import carriers_list from  '../components/carriers/List.vue';
import carriers_save from  '../components/carriers/Save.vue';

import payments_list from  '../components/payments/List.vue';
import payments_save from  '../components/payments/Save.vue';

import order_statuses_list from  '../components/order-statuses/List.vue';
import order_statuses_save from  '../components/order-statuses/Save.vue';

import specific_prices_list from  '../components/specific-prices/List.vue';

import callbacks_list   from  '../components/callbacks/List.vue';
import callbacks_detail from  '../components/callbacks/Save.vue';

import orders_list     from  '../components/orders/List.vue';
import orders_detail   from  '../components/orders/Detail.vue';

import sliders_list from  '../components/sliders/List.vue';
import sliders_save from  '../components/sliders/Save.vue';

import cities_list from  '../components/cities/List.vue';
import cities_save from  '../components/cities/Save.vue';

import banners_list from  '../components/banners/List.vue';
import banners_save from  '../components/banners/Save.vue';

import news_list from  '../components/news/List.vue';
import news_save from  '../components/news/Save.vue';


import layout from  '../components/Layout.vue';
import checkout from  '../components/checkout/Checkout.vue';
import HistoryBack from  '../components/plugins/HistoryBack.vue';

Vue.component('layout',       layout);
Vue.component('checkout',     checkout);
Vue.component('history_back', HistoryBack);

Vue.use(Router);


export default new Router({
    mode: 'history',
    base: '/admin',
    routes: [

        {
            path: '/main',
            name: 'main',
            component: main,
            meta: {
                title: 'Статистика',
            }
        },


        //Категория
        {
            path: '/categories',
            name: 'categories',
            component: categories_list,
            meta: {
                title: 'Категории',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/category',
            name: 'category_create',
            component: categories_save,
            meta: {
                title: 'Создать категорию',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Категории', link: '/categories' },
                ]
            }
        },
        {
            path: '/categories/reorder',
            name: 'categories_reorder',
            component: categories_reorder,
            meta: {
                title: 'Переупорядочить категории',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Категории', link: '/categories' },
                ]
            }
        },
        {
            path: '/category/:category_id',
            name: 'category_edit',
            component: categories_save,
            meta: {
                title: 'Редактировать категорию',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Категории', link: '/categories' },
                ]
            }
        },







        //Атрибуты
        {
            path: '/attributes',
            name: 'attributes',
            component: attributes_list,
            meta: {
                title: 'Атрибуты',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/attribute',
            name: 'attribute_create',
            component: attributes_save,
            meta: {
                title: 'Создать атрибут',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Атрибуты', link: '/attributes' },
                ]
            }
        },
        {
            path: '/attribute/:attribute_id',
            name: 'attribute_edit',
            component: attributes_save,
            meta: {
                title: 'Редактировать атрибут',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Атрибуты', link: '/attributes' },
                ]
            }
        },







        //Attribute Sets
        {
            path: '/attributes-sets',
            name: 'attributes_sets',
            component: attributes_sets_list,
            meta: {
                title: 'Наборы атрибутов',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/attribute-set',
            name: 'attribute_set_create',
            component: attributes_sets_save,
            meta: {
                title: 'Добавить набор атрибутов',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Наборы атрибутов', link: '/attributes-sets' },
                ]
            }
        },
        {
            path: '/attribute-set/:attribute_set_id',
            name: 'attribute_set_edit',
            component: attributes_sets_save,
            meta: {
                title: 'Редактировать набор атрибутов',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Наборы атрибутов', link: '/attributes-sets' },
                ]
            }

        },







        //Товары
        {
            path: '/products',
            name: 'products',
            component: products_list,
            meta: {
                title: 'Товары',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/product',
            name: 'product_create',
            component: products_save,
            meta: {
                title: 'Добавить товар',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Товары',           link: '/products' },
                ]
            }
        },
        {
            path: '/product/:product_id',
            name: 'product_edit',
            component: products_save,
            meta: {
                title: 'Редактировать товар',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Товары',           link: '/products' },
                ]
            }
        },
        {
            path: '/import-export',
            component: import_export,
            meta: {
                title: 'Импорт/Экспорт',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Товары',           link: '/products' },
                ]
            }
        },




        //Отзывы
        {
            path: '/reviews',
            component: reviews,
            meta: {
                title: 'Отзывы',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Товары', link: '/products' },
                ]
            }
        },

        //Вопросы-ответы
        {
            path: '/questions-answers',
            component: questions_answers,
            meta: {
                title: 'Вопросы-ответы',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Товары', link: '/products' },
                ]
            }
        },


        /**********************************************************************************************************************/
        {
            path: '/users',
            name: 'users',
            component: users_list,
            meta: {
                title: 'Клиенты и пользователи',
                roles: ['admin'],
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/user',
            name: 'user_create',
            component: users_save,
            meta: {
                title: 'Создать',
                roles: ['admin'],
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Клиенты и пользователи', link: '/users' },
                ]
            }
        },
        {
            path: '/user/:user_id',
            name: 'user_edit',
            component: users_save,
            meta: {
                title: 'Редактировать',
                roles: ['admin'],
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Клиенты и пользователи', link: '/users' },
                ]
            }
        },




        //Курьер
        {
            path: '/carriers',
            name: 'carriers',
            component: carriers_list,
            meta: {
                title: 'Курьеры',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/courier',
            name: 'courier_create',
            component: carriers_save,
            meta: {
                title: 'Создать курьер',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Курьеры', link: '/carriers' },
                ]
            }
        },
        {
            path: '/courier/:courier_id',
            name: 'courier_edit',
            component: carriers_save,
            meta: {
                title: 'Редактировать курьер',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Курьеры', link: '/carriers' },
                ]
            }
        },




        //Слайдеры
        {
            path: '/sliders',
            name: 'sliders',
            component: sliders_list,
            meta: {
                title: 'Слайдеры',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/slider',
            name: 'slider_create',
            component: sliders_save,
            meta: {
                title: 'Создать слайдер',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Слайдеры', link: '/sliders' },
                ]
            }
        },
        {
            path: '/slider/:slider_id',
            name: 'slider_edit',
            component: sliders_save,
            meta: {
                title: 'Редактировать слайдер',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Слайдеры', link: '/sliders' },
                ]
            }
        },


        //статус
        {
            path: '/order-statuses',
            name: 'order_statuses',
            component: order_statuses_list,
            meta: {
                title: 'Статусы заказов',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/order-status',
            name: 'order_status_create',
            component: order_statuses_save,
            meta: {
                title: 'Создать статус заказа',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Статусы заказов', link: '/order-statuses' },
                ]
            }
        },
        {
            path: '/order-status/:order_status_id',
            name: 'order_status_edit',
            component: order_statuses_save,
            meta: {
                title: 'Редактировать статус заказа',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Статусы заказов', link: '/order-statuses' },
                ]
            }
        },


        //Скидки
        {
            path: '/specific-prices',
            component: specific_prices_list,
            meta: {
                title: 'Скидки',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },


        //Обратный звонок
        {
            path: '/callbacks',
            name: 'callbacks',
            component: callbacks_list,
            meta: {
                title: 'Обратный звонок',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/callback/:callback_id',
            name: 'callback',
            component: callbacks_detail,
            meta: {
                title: 'Редактировать слайдер',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Обратный звонок', link: '/callbacks' },
                ]
            }
        },



        //заказы
        {
            path: '/orders',
            name: 'orders',
            component: orders_list,
            meta: {
                title: 'Заказы',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/order/:order_id',
            name: 'order_edit',
            component: orders_detail,
            meta: {
                title: 'Заказ',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Заказы', link: '/orders' },
                ]
            }
        },
        {
            path: '/order',
            name: 'order_create',
            component: orders_detail,
            meta: {
                title: 'Создать заказ',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Создать заказ', link: '/orders' },
                ]
            }
        },





        //Курьер
        {
            path: '/payments',
            name: 'payments',
            component: payments_list,
            meta: {
                title: 'Тип оплаты',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/payment',
            name: 'payment_create',
            component: payments_save,
            meta: {
                title: 'Создать курьер',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Тип оплаты', link: '/payments' },
                ]
            }
        },
        {
            path: '/payment/:payment_id',
            name: 'payment_edit',
            component: payments_save,
            meta: {
                title: 'Редактировать курьер',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Тип оплаты', link: '/payments' },
                ]
            }
        },




        //Город
        {
            path: '/cities',
            name: 'cities',
            component: cities_list,
            meta: {
                title: 'Тип оплаты',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/city',
            name: 'city_create',
            component: cities_save,
            meta: {
                title: 'Создать город',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Тип оплаты', link: '/cities' },
                ]
            }
        },
        {
            path: '/city/:city_id',
            name: 'city_edit',
            component: cities_save,
            meta: {
                title: 'Редактировать город',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Тип оплаты', link: '/cities' },
                ]
            }
        },




        //Баннеры
        {
            path: '/banners',
            name: 'banners',
            component: banners_list,
            meta: {
                title: 'Баннеры',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/banner',
            name: 'banner_create',
            component: banners_save,
            meta: {
                title: 'Создать город',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Баннеры', link: '/banners' },
                ]
            }
        },
        {
            path: '/banner/:banner_id',
            name: 'banner_edit',
            component: banners_save,
            meta: {
                title: 'Редактировать город',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Баннеры', link: '/banners' },
                ]
            }
        },



        //Новостей
        {
            path: '/news',
            name: 'news',
            component: news_list,
            meta: {
                title: 'Новости',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/news-create',
            name: 'news_create',
            component: news_save,
            meta: {
                title: 'Создать',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Новости', link: '/news' },
                ]
            }
        },
        {
            path: '/news/:news_id',
            name: 'news_edit',
            component: news_save,
            meta: {
                title: 'Редактировать',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Новости', link: '/news' },
                ]
            }
        },






]
});
