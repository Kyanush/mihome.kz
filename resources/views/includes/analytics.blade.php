@php
    $show = true;
    if(Auth::check())
        if(Auth::user()->hasRole('admin'))
            $show = false;
@endphp

@if(env('APP_TEST') == 0 and $show)


    @if(mb_strtolower(env('APP_NO_URL')) == mb_strtolower('Magazin-Xiaomi.kz'))
        <meta name="google-site-verification" content="r9lss0nyPxaZTv-HoycreeMANnN5YfnrQKfYiVVzEbE" />
        <meta name="yandex-verification" content="b2c606d78f1afe58" />
        <meta name='wmail-verification' content='fe80eaaef919e3c50ba26b8c567cf748' />

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-146075811-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-146075811-1');
        </script>

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(54983707, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true
            });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/54983707" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
    @endif



    @if(mb_strtolower(env('APP_NO_URL')) == mb_strtolower('MiHome.kz'))
        <meta name='wmail-verification' content='afd3265a6543de7b2d413b848d62a272' />
        <meta name="yandex-verification" content="5e80dd0c70552c4f" />
        <meta name="google-site-verification" content="f3dNhkvnXjKE8QfdogVG5JNiaRsqq4z-cYEMDYodTjg" />

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-145899417-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-145899417-1');
        </script>

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(54945262, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true
            });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/54945262" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
    @endif



@endif
