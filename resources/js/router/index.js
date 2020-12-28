import Vue    from 'vue';
import Router from 'vue-router';


import main   from  '../components/Main.vue';
import categories_list    from  '../components/categories/List.vue';
import categories_reorder from  '../components/categories/Reorder.vue';
import categories_save    from  '../components/categories/Save.vue';

import attributes_list    from  '../components/attributes/List.vue';
import attributes_save    from  '../components/attributes/Save.vue';

import products_list    from  '../components/products/List.vue';
import products_save    from  '../components/products/Save.vue';
import product_stock    from  '../components/products/StockList.vue';

import import_export   from '../components/import-export/Import-export.vue';


import reviews    from  '../components/reviews/reviews.vue';


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

import sliders_list from  '../components/sliders/List.vue';
import sliders_save from  '../components/sliders/Save.vue';

import cities_list from  '../components/cities/List.vue';
import cities_save from  '../components/cities/Save.vue';

import banners_list from  '../components/banners/List.vue';
import banners_save from  '../components/banners/Save.vue';

import news_list from  '../components/news/List.vue';
import news_save from  '../components/news/Save.vue';

import settings from  '../components/plugins/Settings.vue';

import layout from  '../components/Layout.vue';
import checkout from  '../components/checkout/Checkout.vue';
import HistoryBack from  '../components/plugins/HistoryBack.vue';

import permissions       from '../components/permissions/permissions';
import telefon_sena      from '../components/telefon_sena';

import accessIsDenied    from '../components/AccessIsDenied';
import not_found         from '../components/404';

Vue.component('layout',       layout);
Vue.component('checkout',     checkout);
Vue.component('history_back', HistoryBack);
Vue.component('telefon_sena', telefon_sena);

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
                roles: ['main']
            },

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
                ],
                roles: ['categories']
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
                ],
                roles: ['categories']
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
                ],
                roles: ['categories_reorder']
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
                ],
                roles: ['categories']
            }
        },







        //Характеристики
        {
            path: '/attributes',
            name: 'attributes',
            component: attributes_list,
            meta: {
                title: 'Характеристики',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ],
                roles: ['attributes']
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
                    { title: 'Характеристики', link: '/attributes' },
                ],
                roles: ['attributes']
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
                    { title: 'Характеристики', link: '/attributes' },
                ],
                roles: ['attributes']
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
                ],
                roles: ['products']
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
                ],
                roles: ['products']
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
                ],
                roles: ['products']
            }
        },
        {
            path: '/product-stock',
            name: 'product_stock',
            component: product_stock,
            meta: {
                title: 'Количество на складе',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' }
                ],
                roles: ['product_stock']
            }
        },
        {
            path: '/import-export',
            component: import_export,
            name: 'import_export',
            meta: {
                title: 'Импорт/Экспорт',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Товары',           link: '/products' },
                ],
                roles: ['import_export']
            }
        },



        //Отзывы
        {
            path: '/reviews',
            name: 'reviews',
            component: reviews,
            meta: {
                title: 'Отзывы',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                    { title: 'Товары', link: '/products' },
                ],
                roles: ['reviews']
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
                ],
                roles: ['users']
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
                ],
                roles: ['users']
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
                ],
                roles: ['users']
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
                ],
                roles: ['carriers']
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
                ],
                roles: ['carriers']
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
                ],
                roles: ['carriers']
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
                ],
                roles: ['sliders']
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
                ],
                roles: ['sliders']
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
                ],
                roles: ['sliders']
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
                ],
                roles: ['order_statuses']
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
                ],
                roles: ['order_statuses']
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
                ],
                roles: ['order_statuses']
            }
        },


        //Скидки
        {
            path: '/specific-prices',
            name: 'specific_prices',
            component: specific_prices_list,
            meta: {
                title: 'Скидки',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' },
                ],
                roles: ['specific_prices']
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
                ],
                roles: ['callbacks']
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
                ],
                roles: ['callbacks']
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
                ],
                roles: ['orders']
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
                ],
                roles: ['payments']
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
                ],
                roles: ['payments']
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
                ],
                roles: ['payments']
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
                ],
                roles: ['cities']
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
                ],
                roles: ['cities']
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
                ],
                roles: ['cities']
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
                ],
                roles: ['banners']
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
                ],
                roles: ['banners']
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
                ],
                roles: ['banners']
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
                ],
                roles: ['news']
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
                ],
                roles: ['news']
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
                ],
                roles: ['news']
            }
        },



        {
            path: '/settings',
            name: 'settings',
            component: settings,
            meta: {
                title: 'Настройки',
                breadcrumb: [
                    { title: 'Главная страница', link: '/main' }
                ],
                roles: ['settings']
            }
        },


        /******************************************************/
        {
            path: '/permissions',
            name: 'permissions',
            component: permissions,
            meta: {
                title: 'Права доступа',
                breadcrumb: [
                    { title: 'Главная страница', name: 'main' }
                ],
                roles: ['permissions']
            }
        },

        {
            path: '/access-is-denied',
            name: 'accessIsDenied',
            component: accessIsDenied,
            meta: {
                title: 'Доступ запрещен 403',
                breadcrumb: [
                    { title: 'Доступ запрещен 403', name: 'accessIsDenied' },
                ],
                roles: ['*']
            }
        },

        {
            path: '*',
            component: not_found,
            name: 'not_found',
            meta: {
                title: 'Ошибка: 404 - Страница не найдена',
                breadcrumb: [
                    { title: 'Главная страница',    name: 'main' },
                ],
                roles: ['*']
            }
        }


]
});
