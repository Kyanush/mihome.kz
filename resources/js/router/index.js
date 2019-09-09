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
            name: 'Статистика',
            component: main
        },







        //Категория
        {
            path: '/categories',
            name: 'Категории',
            component: categories_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/categories/create',
            name: 'Создать категорию',
            component: categories_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Категории', link: '/categories' },
                ]
            }
        },
        {
            path: '/categories/reorder',
            name: 'Переупорядочить категории',
            component: categories_reorder,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Категории', link: '/categories' },
                ]
            }
        },
        {
            path: '/categories/edit/:id',
            name: 'Редактировать категорию',
            component: categories_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Категории', link: '/categories' },
                ]
            }
        },







        //Атрибуты
        {
            path: '/attributes',
            name: 'Атрибуты',
            component: attributes_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/attributes/create',
            name: 'Создать атрибут',
            component: attributes_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Атрибуты', link: '/attributes' },
                ]
            }
        },
        {
            path: '/attributes/edit/:id',
            name: 'Редактировать атрибут',
            component: attributes_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Атрибуты', link: '/attributes' },
                ]
            }
        },







        //Attribute Sets
        {
            path: '/attributes-sets',
            name: 'Наборы атрибутов',
            component: attributes_sets_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/attributes-sets/create',
            name: 'Добавить набор атрибутов',
            component: attributes_sets_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Наборы атрибутов', link: '/attributes-sets' },
                ]
            }
        },
        {
            path: '/attributes-sets/edit/:id',
            name: 'Редактировать набор атрибутов',
            component: attributes_sets_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Наборы атрибутов', link: '/attributes-sets' },
                ]
            }

        },







        //Товары
        {
            path: '/products',
            name: 'Товары',
            component: products_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/product/create',
            name: 'Добавить товар',
            component: products_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Товары', link: '/products' },
                ]
            }
        },
        {
            path: '/products/edit/:id',
            name: 'Редактировать товар',
            component: products_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Товары', link: '/products' },
                ]
            }
        },



        //Отзывы
        {
            path: '/reviews',
            name: 'Отзывы',
            component: reviews,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Товары', link: '/products' },
                ]
            }
        },

        //Вопросы-ответы
        {
            path: '/questions-answers',
            name: 'Вопросы-ответы',
            component: questions_answers,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Товары', link: '/products' },
                ]
            }
        },


        /**********************************************************************************************************************/
        {
            path: '/users',
            name: 'Клиенты и пользователи',
            component: users_list,
            meta: {
                roles: ['admin'],
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/users/create',
            name: 'Создать',
            component: users_save,
            meta: {
                roles: ['admin'],
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Клиенты и пользователи', link: '/users' },
                ]
            }
        },
        {
            path: '/users/edit/:id',
            name: 'Редактировать',
            component: users_save,
            meta: {
                roles: ['admin'],
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Клиенты и пользователи', link: '/users' },
                ]
            }
        },




        //Курьер
        {
            path: '/carriers',
            name: 'Курьеры',
            component: carriers_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/carriers/create',
            name: 'Создать курьер',
            component: carriers_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Курьеры', link: '/carriers' },
                ]
            }
        },
        {
            path: '/carriers/edit/:id',
            name: 'Редактировать курьер',
            component: carriers_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Курьеры', link: '/carriers' },
                ]
            }
        },

        //Слайдеры
        {
            path: '/sliders',
            name: 'Слайдеры',
            component: sliders_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/sliders/create',
            name: 'Создать слайдер',
            component: sliders_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Слайдеры', link: '/sliders' },
                ]
            }
        },
        {
            path: '/sliders/edit/:id',
            name: 'Редактировать слайдер',
            component: sliders_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Слайдеры', link: '/sliders' },
                ]
            }
        },


        //статус
        {
            path: '/order-statuses',
            name: 'Статусы заказов',
            component: order_statuses_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/order-statuses/create',
            name: 'Создать статус заказа',
            component: order_statuses_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Статусы заказов', link: '/order-statuses' },
                ]
            }
        },
        {
            path: '/order-statuses/edit/:id',
            name: 'Редактировать статус заказа',
            component: order_statuses_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Статусы заказов', link: '/order-statuses' },
                ]
            }
        },


        //Скидки
        {
            path: '/specific-prices',
            name: 'Скидки',
            component: specific_prices_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },


        //Обратный звонок
        {
            path: '/callbacks',
            name: 'Обратный звонок',
            component: callbacks_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/callbacks/edit/:id',
            name: 'Редактировать слайдер',
            component: callbacks_detail,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Обратный звонок', link: '/callbacks' },
                ]
            }
        },



        //заказы
        {
            path: '/orders',
            name: 'Заказы',
            component: orders_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/orders/:id',
            name: 'Заказ',
            component: orders_detail,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Заказы', link: '/orders' },
                ]
            }
        },
        {
            path: '/orders/create',
            name: 'Создать заказ',
            component: orders_detail,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Создать заказ', link: '/orders' },
                ]
            }
        },





        //Курьер
        {
            path: '/payments',
            name: 'Тип оплаты',
            component: payments_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/payments/create',
            name: 'Создать курьер',
            component: payments_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Тип оплаты', link: '/payments' },
                ]
            }
        },
        {
            path: '/payments/edit/:id',
            name: 'Редактировать курьер',
            component: payments_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Тип оплаты', link: '/payments' },
                ]
            }
        },




        //Город
        {
            path: '/cities',
            name: 'Тип оплаты',
            component: cities_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/cities/create',
            name: 'Создать город',
            component: cities_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Тип оплаты', link: '/cities' },
                ]
            }
        },
        {
            path: '/cities/edit/:id',
            name: 'Редактировать город',
            component: cities_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Тип оплаты', link: '/cities' },
                ]
            }
        },




        //Баннеры
        {
            path: '/banners',
            name: 'Баннеры',
            component: banners_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/banners/create',
            name: 'Создать город',
            component: banners_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Баннеры', link: '/banners' },
                ]
            }
        },
        {
            path: '/banners/edit/:id',
            name: 'Редактировать город',
            component: banners_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Баннеры', link: '/banners' },
                ]
            }
        },



        //Новостей
        {
            path: '/news',
            name: 'Новости',
            component: news_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/news/create',
            name: 'Создать',
            component: news_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Новости', link: '/news' },
                ]
            }
        },
        {
            path: '/news/edit/:id',
            name: 'Редактировать',
            component: news_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Новости', link: '/news' },
                ]
            }
        },






]
});