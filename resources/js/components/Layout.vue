<template>
    <div>

        <header class="main-header">

            <!-- Logo -->
            <router-link :to="{ path: '/main'}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">SHOP</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">SHOP</span>
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
                                <router-link :to="{ path: '/users/edit/' + UserId}">
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
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">

                    <!-- ================================================ -->
                    <!-- ==== Recommended place for admin menu items ==== -->
                    <!-- ================================================ -->

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                            <span>Товары</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu" style="display: none;">
                                <li v-bind:class="{'active' : menu_active('/products/')}">
                                    <router-link :to="{ path: '/products'}">
                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                        <span>Товары</span>
                                    </router-link>
                                </li>
                                <li v-bind:class="{'active' : menu_active('/reviews/')}">
                                    <router-link :to="{ path: '/reviews'}">
                                        <i class="fa fa-comment" aria-hidden="true"></i>
                                        <span>Отзывы</span>
                                    </router-link>
                                </li>
                                <li v-bind:class="{'active' : menu_active('/questions-answers/')}">
                                    <router-link :to="{ path: '/questions-answers'}">
                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                        <span>Вопросы-ответы</span>
                                    </router-link>
                                </li>
                                <li v-bind:class="{'active' : menu_active('/specific-prices/')}">
                                    <router-link :to="{ path: '/specific-prices'}">
                                        <i class="fa fa-money"></i>
                                        <span>Скидки</span>
                                    </router-link>
                                </li>

                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-tag"></i>
                            <span>Атрибуты</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu" style="display: none;">
                            <li v-bind:class="{'active' : menu_active('/attributes/')}">
                                <router-link :to="{ path: '/attributes'}">
                                    <i class="fa fa-tag"></i>
                                    <span>Атрибуты</span>
                                </router-link>
                            </li>
                            <li v-bind:class="{'active' : menu_active('/attributes-sets/')}">
                                <router-link :to="{ path: '/attributes-sets'}">
                                    <i class="fa fa-tags"></i>
                                    <span>Наборы атрибутов</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li v-bind:class="{'active' : menu_active('/orders/')}">
                        <router-link :to="{ path: '/orders'}">
                            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                            <span>Заказы </span>
                            <span class="pull-right-container" v-if="new_orders_count > 0">
                                  <small class="label pull-right bg-red">
                                      {{ new_orders_count }}
                                  </small>
                            </span>
                        </router-link>
                    </li>

                    <li v-bind:class="{'active' : menu_active('/users/')}">
                        <router-link :to="{ path: '/users'}">
                            <i class="fa fa-users"></i>
                            <span>Клиенты и пользователи</span>
                        </router-link>
                    </li>

                    <li v-bind:class="{'active' : menu_active('/sliders/')}">
                        <router-link :to="{ path: '/sliders'}">
                            <i class="fa fa-sliders" aria-hidden="true"></i>
                            <span>Слайдеры</span>
                        </router-link>
                    </li>

                    <li v-bind:class="{'active' : menu_active('/callbacks/')}">
                        <router-link :to="{ path: '/callbacks'}">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <span>Обратный звонок</span>
                            <span class="pull-right-container" v-if="new_callbacks_count > 0">
                                  <small class="label pull-right bg-red">
                                      {{ new_callbacks_count }}
                                  </small>
                            </span>
                        </router-link>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-book" aria-hidden="true"></i>
                            <span>Справочники</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu" style="display: none;">
                            <li v-bind:class="{'active' : menu_active('/categories/')}">
                                <router-link :to="{ path: '/categories'}">
                                    <i class="fa fa-bars"></i>
                                    <span>Категории</span>
                                </router-link>
                            </li>
                            <li v-bind:class="{'active' : menu_active('/carriers/')}">
                                <router-link :to="{ path: '/carriers'}">
                                    <i class="fa fa-truck"></i>
                                    <span>Курьеры</span>
                                </router-link>
                            </li>
                            <li v-bind:class="{'active' : menu_active('/order-statuses/')}">
                                <router-link :to="{ path: '/order-statuses'}">
                                    <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                                    <span>Статусы заказов</span>
                                </router-link>
                            </li>
                            <li v-bind:class="{'active' : menu_active('/payments/')}">
                                <router-link :to="{ path: '/payments'}">
                                    <i class="fa fa-paypal" aria-hidden="true"></i>
                                    <span>Тип оплаты</span>
                                </router-link>
                            </li>
                            <li v-bind:class="{'active' : menu_active('/cities/')}">
                                <router-link :to="{ path: '/cities'}">
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                    <span>Город</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li v-bind:class="{'active' : menu_active('/main/')}">
                        <router-link :to="{ path: '/main'}">
                            <i class="fa fa-area-chart" aria-hidden="true"></i>
                            <span>Статистика</span>
                        </router-link>
                    </li>

                    <li v-bind:class="{'active' : menu_active('/banners/')}">
                        <router-link :to="{ path: '/banners'}">
                            <i class="fa fa-clipboard" aria-hidden="true"></i>
                            <span>Баннеры</span>
                        </router-link>
                    </li>

                    <li v-bind:class="{'active' : menu_active('/news/')}">
                        <router-link :to="{ path: '/news'}">
                            <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                            <span>Новости</span>
                        </router-link>
                    </li>

<!--

                    <li><a href="http://estarter-ecommerce-for-laravel/admin/notification-templates"><i class="fa fa-list"></i> <span>Notification Templates</span></a></li>

                    <li class="treeview">
                        <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="http://estarter-ecommerce-for-laravel/admin/users"><i class="fa fa-user"></i> <span>Users</span></a></li>
                            <li><a href="http://estarter-ecommerce-for-laravel/admin/role"><i class="fa fa-group"></i> <span>Roles</span></a></li>
                            <li><a href="http://estarter-ecommerce-for-laravel/admin/permission"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
                        </ul>
                    </li>
-->



                    <!-- ======================================= -->

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
    </div>
</template>


<script>
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';
    import  breadcrumbs   from './plugins/Breadcrumbs.vue';

    export default {
        components:{
            breadcrumbs
        },
        data() {
            return {
                new_orders_count: 0,
                new_callbacks_count: 0,
                current_year: 2019
            }
        },
        props: ['user'],
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('/admin/new-orders-count').then((res) => {
                this.new_orders_count = res.data;
            });
            axios.get('/admin/new-callbacks-count').then((res) => {
                this.new_callbacks_count = res.data;
            });

            this.SetUser(this.user);
        },
        methods:{
            menu_active(url){
                var current_url = this.$router.currentRoute.path + '/';
                return current_url.indexOf(url) >= 0 ? true : false;
            },
            ...mapActions(['SetUser']),
            logout(){
                axios.post('/logout').then((res)=>{
                    window.location.href = "/";
                });
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
