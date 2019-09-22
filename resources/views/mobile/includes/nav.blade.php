<nav class="kaspi-menu ">
    <div class="kaspi-menu__inner">


        <div class="kaspi-menu__header">
            <div class="mount-kaspi-menu-auth">
                <div class="kaspi-menu__signin">

                    @auth
                        <i class="kaspi-menu__signin-icon icon icon_close"></i>
                        <a href="/logout">Выйти</a>
                        &nbsp;|&nbsp;
                        <a href="{{ route('my_account') }}">{{ Auth::user()->name }}</a>
                    @else
                        <i class="kaspi-menu__signin-icon icon icon_user"></i>
                        <a href="/login">Вход</a>
                        &nbsp;|&nbsp;
                        <a href="/register">Регистрация</a>
                    @endauth

                </div>
            </div>
            <!--
            <a href="#" class="kaspi-menu__region">
                <i class="kaspi-menu__region-icon"></i> Алматы
            </a>-->
        </div>

        <ul class="kaspi-menu__items">

            <?
               $menu = [
                   [
                       'title' => 'Главная',
                       'link'  => route('index')
                   ],
                   [
                       'title' => 'Мои заказы',
                       'link'  => route('order_history')
                   ],
                   [
                       'title' => 'Корзина',
                       'link'  => route('checkout'),
                   ],
                   [
                       'title' => 'Мои закладки',
                       'link'  => route('wishlist'),
                   ],
                   [
                       'title' => 'Сравнение товаров',
                       'link'  => route('compare_products'),
                   ],
                   [
                       'title' => 'Гарантия',
                       'link'  => route('guaranty')
                   ],
                   [
                       'title' => 'Доставка, оплата',
                       'link'  => route('delivery_payment')
                   ],
                   [
                       'title' => 'Контакты',
                       'link'  => route('contact')
                   ],
                   [
                       'title' => 'О нас',
                       'link' => route('about')
                   ]
               ];

               if(Auth::check())
               {
                   $menu[] = [
                       'title' => 'Личный кабинет',
                       'link' => route('my_account'),
                   ];
                   $menu[] = [
                       'title' => 'Изменить пароль',
                       'link' => route('change_password'),
                   ];
               }
            ?>

            @foreach($menu as $item)
                <li class="kaspi-menu__item @if(strpos(url()->current(), $item['link']) !== false and $item['link'] != env('APP_URL')) _active @endif">
                    <a class="kaspi-menu__itemLink" href="{{ $item['link'] }}">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach





            <!--
            <li class="kaspi-menu__item kaspi-menu__item-apps">
                <div class="kaspi-menu__apps">
                    <div class="kaspi-menu__apps-header">Мобильное приложение</div>
                    <a href="https://itunes.apple.com/app/id1195076505" data-app="iOS" target="_blank" class="kaspi-menu__apps-link">
                        <img class="kaspi-menu__apps-img" src="/medias/sys_master/images/images/h14/h76/9075485605918/appstore-2x.png" alt="appstore">
                    </a>
                    <a href="https://play.google.com/store/apps/details?id=kz.kaspi.mobile" data-app="Android" target="_blank" class="kaspi-menu__apps-link g-hide">
                        <img class="kaspi-menu__apps-img" src="/medias/sys_master/images/images/he2/h37/9075485573150/googleplay-2x.png" alt="google play">
                    </a>
                </div>
            </li>--->

        </ul>
    </div>
</nav>