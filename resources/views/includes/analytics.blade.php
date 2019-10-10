@if(env('APP_TEST') == 0 and !\App\Tools\Helpers::isAdmin())

        <meta name='wmail-verification' content='085488c39c4c1d74afb87133253844db' />
        <meta name="yandex-verification" content="5e80dd0c70552c4f" />
        <meta name="google-site-verification" content="f3dNhkvnXjKE8QfdogVG5JNiaRsqq4z-cYEMDYodTjg" />
        <meta name="msvalidate.01" content="FA2FCEE563AF49653FFF42334E7092CC" />

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
                accurateTrackBounce:true,
                webvisor:true,
                ecommerce:"dataLayer"
            });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/54945262" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

@endif
