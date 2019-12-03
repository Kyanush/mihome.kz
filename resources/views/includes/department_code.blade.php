<meta name='wmail-verification' content='085488c39c4c1d74afb87133253844db' />
<meta name="yandex-verification" content="5e80dd0c70552c4f" />
<meta name="google-site-verification" content="f3dNhkvnXjKE8QfdogVG5JNiaRsqq4z-cYEMDYodTjg" />
<meta name="msvalidate.01" content="FA2FCEE563AF49653FFF42334E7092CC" />

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title')</title>
<meta name="description" content="@yield('description')">
<meta name="keywords"    content="@yield('keywords')">

<meta property="og:locale"       content="ru_KZ" />
<meta property="og:type"         content="website">
<meta property="og:url"          content="{{ url()->current() }}"/>
<meta property="og:site_name"    content="{{ env('APP_NAME') }}" />
<meta property="og:title"        content="@yield('title')"/>
<meta property="og:description"  content="@yield('description')"/>
<meta property="og:image"        content="@yield('og_image')"/>
<meta property="og:image:width"  content="80">
<meta property="og:image:height" content="80">

<script src="{{ asset('/site/js/jquery.min.js') }}"></script>

<!-- Vue js -->
<script src="https://cdn.jsdelivr.net/npm/vue"></script>

<!-- axios -->
<script type="text/javascript" src="/site/js/axios.min.js"></script>
<script src="/global/config-axios.js"></script>
<!-- axios -->