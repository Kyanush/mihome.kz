@if(env('APP_TEST') == 0 and !\App\Tools\Helpers::isAdmin())


    <!-- Rating Mail.ru counter -->
    <script type="text/javascript">
        var _tmr = window._tmr || (window._tmr = []);
        _tmr.push({id: "3143940", type: "pageView", start: (new Date()).getTime()});
        (function (d, w, id) {
            if (d.getElementById(id)) return;
            var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
            ts.src = "https://top-fwz1.mail.ru/js/code.js";
            var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
            if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
        })(document, window, "topmailru-code");
    </script><noscript><div>
            <img src="https://top-fwz1.mail.ru/counter?id=3143940;js=na" style="border:0;position:absolute;left:-9999px;" alt="Top.Mail.Ru" />
        </div></noscript>
    <!-- //Rating Mail.ru counter -->





    <!-- ZERO.kz -->
    <span id="_zero_72327" style="display: none;">
          <noscript>
            <a href="http://zero.kz/?s=72327" target="_blank">
              <img src="http://c.zero.kz/z.png?u=72327" width="88" height="31" alt="ZERO.kz" />
            </a>
          </noscript>
    </span>
    <script type="text/javascript"><!--
        var _zero_kz_ = _zero_kz_ || [];
        _zero_kz_.push(["id", 72327]);
        // Цвет кнопки
        _zero_kz_.push(["type", 1]);
        // Проверять url каждые 200 мс, при изменении перегружать код счётчика
        // _zero_kz_.push(["url_watcher", 200]);

        (function () {
            var a = document.getElementsByTagName("script")[0],
                s = document.createElement("script");
            s.type = "text/javascript";
            s.async = true;
            s.src = (document.location.protocol == "https:" ? "https:" : "http:")
                + "//c.zero.kz/z.js";
            a.parentNode.insertBefore(s, a);
        })(); //-->
    </script>
    <!-- End ZERO.kz -->




    <!--LiveInternet counter--><script type="text/javascript">
        document.write('<a href="//www.liveinternet.ru/click" '+
            'target="_blank"><img class="live" src="//counter.yadro.ru/hit?t26.6;r'+
            escape(document.referrer)+((typeof(screen)=='undefined')?'':
                ';s'+screen.width+'*'+screen.height+'*'+(screen.colorDepth?
                screen.colorDepth:screen.pixelDepth))+';u'+escape(document.URL)+
            ';h'+escape(document.title.substring(0,150))+';'+Math.random()+
            '" alt="" title="LiveInternet: показано число посетителей за'+
            ' сегодня" '+
            'border="0" width="88" height="15"><\/a>')
    </script><!--/LiveInternet-->

    <style>
        .live{
            display:none;
        }
    </style>


@endif
