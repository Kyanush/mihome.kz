
<template>
    <div>

        <header class="main-header">

            <!-- Logo -->
            <router-link :to="{ name: 'main'}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">Shop</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Shop</b> CRM</span>
            </router-link>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <!--
                include('backpack::inc.menu')
                -->

                <div class="navbar-custom-menu pull-left">
                    <ul class="nav navbar-nav">
                        <!-- =================================================== -->
                        <!-- ========== Top menu items (ordered left) ========== -->
                        <!-- =================================================== -->

                        <!-- <li><a href="http://estarter-ecommerce-for-laravel"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

                        <!-- ========== End of top menu left items ========== -->
                    </ul>
                </div>


                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <li @click="whatsappShow">
                            <a>
                                <i class="fa fa-whatsapp" aria-hidden="true"></i>
                            </a>
                        </li>

                        <!-- ========================================================= -->
                        <!-- ========== Top menu right items (ordered left) ========== -->
                        <!-- ========================================================= -->

                        <!-- <li><a href="http://estarter-ecommerce-for-laravel"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

                        <li>
                            <a @click="logout" class="logout">
                                <i class="fa fa-btn fa-sign-out"></i> Выйти
                            </a>
                        </li>

                        <!-- ========== End of top menu right items ========== -->
                    </ul>
                </div>





            </nav>
        </header>

        <!-- =============================================== -->

        <!--include('backpack::inc.sidebar')-->


        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar" style="height: auto;">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="http://www.gravatar.com/avatar/1e22faa0f24a974c9188289c9e2a74e1.jpg?s=80&amp;d=mm&amp;r=g" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{ UserName }}</p>
                        <p class="role-desc">{{ RoleDesc }}</p>
                        <small>
                            <small>
                                <router-link :to="{ name: 'user_edit', params: { user_id: UserId }}">
                                     <span>
                                        <i class="fa fa-user-circle-o"></i> Мой аккаунт
                                    </span>
                                </router-link>
                                <a @click="logout" class="logout">
                                    <i class="fa fa-sign-out"></i>
                                    <span>Выйти</span>
                                </a>
                            </small>
                        </small>
                    </div>
                </div>

                <form action="/admin/products" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" placeholder="Поиск товара...">
                        <span class="input-group-btn">
                            <button type="submit" id="search-btn" class="btn btn-flat">
                              <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>


                <ul class="sidebar-menu tree" style="min-height: 800px;">
                    <li v-for="item in menu"
                        v-if="$can(item.can)"
                        v-bind:class="{ 'active': menu_active(item), 'treeview': item.childs && item.childs.length }">

                        <router-link :to="{ name: item.route_name, query: item.query, params: item.params }">
                            <i :class="item.icon" aria-hidden="true"></i>
                            <span v-html="item.name"></span>
                            <i v-if="item.childs.length" class="fa fa-angle-left pull-right"></i>
                        </router-link>

                        <ul class="treeview-menu" v-if="item.childs.length" v-bind:class="{ 'display-none': !menu_active(item) }">

                            <li v-for="item2 in item.childs"
                                v-if="$can(item2.can)"
                                v-bind:class="{ 'active': menu_active(item2), 'treeview': item2.childs && item2.childs.length }">
                                <router-link :to="{ name: item2.route_name, query: item2.query, params: item2.params   }">
                                    <i :class="item2.icon" aria-hidden="true"></i>
                                    <span v-html="item2.name"></span>
                                    <i v-if="item2.childs && item2.childs.length" class="fa fa-angle-left pull-right"></i>
                                </router-link>

                                <ul class="treeview-menu" v-if="item2.childs && item2.childs.length" v-bind:class="{ 'display-none': !menu_active(item2) }">
                                    <li v-for="item3 in item2.childs"
                                        v-if="$can(item3.can)"
                                        v-bind:class="{ 'active': menu_active(item3), 'treeview': item3.childs && item3.childs.length }">
                                        <router-link :to="{ name: item3.route_name, query: item3.query, params: item3.params   }">
                                            <i :class="item3.icon" aria-hidden="true"></i>
                                            <span v-html="item3.name"></span>
                                        </router-link>
                                    </li>
                                </ul>

                            </li>

                        </ul>
                    </li>
                </ul>

            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <breadcrumbs></breadcrumbs>

            <!-- Main content -->
            <section id="content">

                <router-view></router-view>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                Version 1.0.0
            </div>
            <strong>Copyright © 2018-{{ current_year }} <a target="_blank" href="https://www.instagram.com/zheksenkulov_kuanysh/">Жексенкулов К.Е.</a></strong>
            All rights reserved.
        </footer>

        <div id="whatsapp-popup" style="position: fixed; left: 0px; right: 0px; top: 0px; bottom: 0px; height: 100%; width: 100%; z-index: 999999;display: none;">
            <div @click="whatsappClose" style="position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px; height: 100%; width: 100%; opacity: 0.4; background: black;"></div>
            <div style="position: absolute; bottom: 0px; height: 100%; width: calc(100% - 200px); z-index: 9999999; right: 0px;">
                <whats_app_order/>
            </div>
            <div style="position: absolute; z-index: 9999999; top: 5px; width: 180px;">
                <svg @click="whatsappClose" fill="#77dd00" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg" style="float: right; cursor:pointer;"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>
            </div>
        </div>

        <notifications position="bottom left" group="foo" />

    </div>
</template>


<script>
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';
    import  breadcrumbs   from './plugins/Breadcrumbs.vue';
    import whats_app_order from './whats_app/order_whats_app';

    export default {
        components:{
            breadcrumbs, whats_app_order
        },
        data() {
            return {


                current_year: 2019,
                menu: [

                    {
                        can: [
                            'products', 'product_create', 'product_edit',
                            'product_stock', 'reviews', 'specific_prices'
                        ],
                        name: 'Товары',
                        route_name: '',
                        icon: 'fa fa-shopping-basket',
                        menu_active: [
                            'products', 'product_create', 'product_edit',
                            'product_stock', 'reviews', 'specific_prices'
                        ],
                        childs: [
                            {
                                can: ['products'],
                                name: 'Товары',
                                route_name: 'products',
                                icon: 'fa fa-shopping-basket',
                                menu_active: ['products', 'product_create', 'product_edit']
                            },
                            {
                                can: ['product_stock'],
                                name: 'Количество на складе',
                                route_name: 'product_stock',
                                icon: 'fa fa-database',
                                menu_active: ['product_stock']
                            },
                            {
                                can: ['reviews'],
                                name: 'Отзывы',
                                route_name: 'reviews',
                                icon: 'fa fa-comment',
                                menu_active: ['reviews']
                            },
                            {
                                can: ['specific_prices'],
                                name: 'Скидки',
                                route_name: 'specific_prices',
                                icon: 'fa fa-money',
                                menu_active: ['specific_prices']
                            }
                        ]
                    },
                    {
                        can: ['orders'],
                        name: 'Заказы',
                        route_name: 'orders',
                        icon: 'fa fa-cart-arrow-down',
                        menu_active: ['orders'],
                        childs: []
                    },
                    {
                        can: ['callbacks', 'callback'],
                        name: 'Обратный звонок',
                        route_name: 'callbacks',
                        icon: 'fa fa-phone',
                        menu_active: ['callbacks', 'callback'],
                        childs: []
                    },
                    {
                        can: ['main'],
                        name: 'Статистика',
                        route_name: 'main',
                        icon: 'fa fa-area-chart',
                        menu_active: ['main'],
                        childs: []
                    },
                    {
                        can: ['news', 'news_create', 'news_edit'],
                        name: 'Новости',
                        route_name: 'news',
                        icon: 'fa fa-newspaper-o',
                        menu_active: ['news', 'news_create', 'news_edit'],
                        childs: []
                    },
                    {
                        can: ['sliders', 'slider_create', 'slider_edit'],
                        name: 'Слайдеры',
                        route_name: 'sliders',
                        icon: 'fa fa-sliders',
                        menu_active: ['sliders', 'slider_create', 'slider_edit'],
                        childs: []
                    },
                    {
                        can: ['import_export'],
                        name: 'Импорт/Экспорт',
                        route_name: 'import_export',
                        icon: 'fa fa-download',
                        menu_active: ['import_export'],
                        childs: []
                    },
                    {
                        can: ['users', 'user_create', 'user_edit'],
                        name: 'Клиенты и пользователи',
                        route_name: 'users',
                        icon: 'fa fa-users',
                        menu_active: ['users', 'user_create', 'user_edit'],
                        childs: []
                    },
                    {
                        can: [
                            'categories',     'category_create',     'category_edit',
                            'carriers',       'courier_create',      'courier_edit',
                            'order_statuses', 'order_status_create', 'order_statuses_save',
                            'payments',       'payment_create',      'payment_edit',
                            'cities',         'city_create',         'city_edit',
                            'attributes',     'attribute_create',    'attribute_edit'
                        ],
                        name: 'Справочники',
                        route_name: '',
                        icon: 'fa fa-book',
                        menu_active: [
                                      'categories',     'category_create',     'category_edit',
                                      'carriers',       'courier_create',      'courier_edit',
                                      'order_statuses', 'order_status_create', 'order_statuses_save',
                                      'payments',       'payment_create',      'payment_edit',
                                      'cities',         'city_create',         'city_edit',
                                      'attributes',     'attribute_create',    'attribute_edit'
                        ],
                        childs: [
                            {
                                can: ['categories'],
                                name: 'Категории',
                                route_name: 'categories',
                                icon: 'fa fa-bars',
                                menu_active: ['categories', 'category_create', 'category_edit']
                            },
                            {
                                can: ['carriers'],
                                name: 'Курьеры',
                                route_name: 'carriers',
                                icon: 'fa fa-truck',
                                menu_active: ['carriers', 'courier_create', 'courier_edit']
                            },
                            {
                                can: ['order_statuses'],
                                name: 'Статусы заказов',
                                route_name: 'order_statuses',
                                icon: 'fa fa-hourglass-start',
                                menu_active: ['order_statuses', 'order_status_create', 'order_statuses_save']
                            },
                            {
                                can: ['payments'],
                                name: 'Тип оплаты',
                                route_name: 'payments',
                                icon: 'fa fa-paypal',
                                menu_active: ['payments', 'payment_create', 'payment_edit']
                            },
                            {
                                can: ['cities'],
                                name: 'Город',
                                route_name: 'cities',
                                icon: 'fa fa-home',
                                menu_active: ['cities', 'city_create', 'city_edit']
                            },
                            {
                                can: ['attributes'],
                                name: 'Характеристики',
                                route_name: 'attributes',
                                icon: 'fa fa-tag',
                                menu_active: ['attributes', 'attribute_create', 'attribute_edit']
                            },
                        ]
                    },
                    {
                        can: ['settings'],
                        name: 'Настройки',
                        route_name: 'settings',
                        icon: 'fa fa-cogs',
                        menu_active: ['settings'],
                        childs: []
                    },
                    {
                        can: ['permissions'],
                        name: 'Права',
                        route_name: 'permissions',
                        icon: 'fa fa-cogs',
                        menu_active: ['permissions'],
                        childs: []
                    },

                ]
            }
        },
        props: ['user'],
        created(){


            this.SetUser(this.user);
        },
        methods:{
            menu_active(item){
                var current_route_name = this.$router.currentRoute.name;
                return item.menu_active.indexOf(current_route_name) >= 0 ? true : false;
            },
            ...mapActions(['SetUser']),
            logout(){
                axios.post('/logout').then((res)=>{
                    window.location.href = "/";
                });
            },
            whatsappShow(){
                $('#whatsapp-popup').css('display', 'block');
            },
            whatsappClose(){
                $('#whatsapp-popup').css('display', 'none');
            }
        },
        computed:{
            ...mapGetters([
                'UserName', 'RoleDesc', 'RoleName', 'UserId'
            ])
        }

    }
</script>

<style scoped>
    #content{
        width: 100%;
        display: flex;
    }
    .role-desc{
        font-size: 10px;
    }
    .logout{
        cursor: pointer;
    }
</style>
