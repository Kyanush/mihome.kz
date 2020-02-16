<!DOCTYPE html>
<html lang="ru" class="js" prefix="og: https://ogp.me/ns#">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&amp;subset=cyrillic" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/mobile/css/style.min.css">

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="/site/css/font-awesome.min.css">

    @include('includes.department_code')

    @yield('add_in_head')
    @include('schemas.organization')
    @include('schemas.search')
    @yield('schemas_breadcrumb')
    @yield('schemas_product')

</head>


<body>

    <input type="hidden"
           id="user_info"
               <?php
                  $user = Auth::user();
               ?>
               value="{{ json_encode([ 'name'      => ($user->name  ?? ''),
                                       'email'     => ($user->email ?? ''),
                                       'phone'     => ($user->phone ?? ''),
                                       'addresses' => ($user->addresses ?? [])
                                    ]) }}"
    />


<span id="app">
    <div id="page" class="layout">
        <header class="header">
            <div class="header__inner">
            </div>
        </header>

        <div class="layout">
            <div class="wrapper">
                @yield('content')
            </div>
            @include('mobile.includes.nav')
        </div>
    </div>

    <div style="z-index: 10;">
        <div>
            <component v-bind:is="componentDialog" v-if="componentDialog"></component>
        </div>
    </div>
</span>

@if(strpos($_SERVER['REQUEST_URI'], '/product/') === false or true)
    <div id="back-call">
        <img src="/mobile/images/call.png">
    </div>
@endif

<!-- Slick -->
<link type="text/css" rel="stylesheet" href="{{ asset('/site/css/slick.min.css') }}"/>
<link type="text/css" rel="stylesheet" href="{{ asset('/site/css/slick-theme.min.css') }}"/>
<script src="{{ asset('/site/js/slick.min.js') }}"></script>

<!-- commentbook -->
<script src="/commentbook/script.js" data-jv-id="d5ShOZJS9K" async></script>
<!-- commentbook -->


<!-- swiper -->
<link rel="stylesheet" href="/mobile/swiper/swiper.min.css">
<script src="/mobile/swiper/swiper.js"></script>
<!-- swiper -->


<!---- sweetalert2  ----->
<script src="/site/sweetalert2/sweetalert2.all.min.js"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<link rel="stylesheet" type="text/css" href="/site/sweetalert2/sweetalert2.min.css">
<!---- sweetalert2  ----->


<!-- Mask --->
<script type="text/javascript" src="/site/js/jquery.maskedinput.min.js"></script>
<!-- Mask --->


<script src="/site/js/jquery.lazyload.min.js"></script>
<script src="/global/script.js"></script>

<script type="text/javascript" src="/mobile/js/script.js"></script>



@yield('add_in_end')
@include('includes.analytics_body')
@include('includes.analytics')


</body>
</html>
