<div style="background:#f0f0f0;padding:30px 0;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#272727;">
    <div style="width:680px;background:#fff;margin:0 auto;">
        <div style="background:#333333;height:55px;line-height:55px;overflow:hidden;">
            <div style="margin-left:30px;float:left;"></div>

            <div style="float:right;margin-right:30px;">
                <a href="{{ env('APP_URL') }}/catalog/smartfony" style="display:inline-block;margin:0 0 0 9px;color:#fe8c2c;font-size:12px;" class="daria-goto-anchor" target="_blank" rel="noopener noreferrer">
                    <span style="border-right:1px solid #484848;padding-right:9px;">
                       Каталог товаров
                    </span>
                </a>
                <a href="{{ route('my_account') }}" style="display:inline-block;margin:0 9px;color:#fff;font-size:12px;" class="daria-goto-anchor" target="_blank" rel="noopener noreferrer">
                    Личный кабинет
                </a>
            </div>
        </div>

        <div style="padding:30px;">
            <div style="margin-bottom:60px;">
                <a href="{{ route('index') }}" class="daria-goto-anchor" target="_blank" rel="noopener noreferrer">
                    <img width="150" src="{{ config('shop.logo') }}">
                </a>
                <div style="float:right;padding-top:10px;padding-right:5px;color:#cbcbcb;">
                    {{ env('APP_NAME') }}
                </div>
            </div>

            <div style="font-size:22px;font-weight:bold;color:#272727;border-bottom:1px dashed #e6e6e6;padding-bottom:5px;margin-bottom:10px;">{{ $subject ?? env('APP_NAME') }}</div>


            @yield('content')




        </div>

        <div style="padding:30px;padding-top:22px;">
            <div style="color:#333333;font-weight:bold;margin-bottom:13px;">Дополнительные ссылки:</div>

            <div style="overflow:hidden;">
                <div style="width:200px;float:left;">
                    <div style="margin-top:5px;">
                        <a href="{{ env('APP_URL') }}/catalog/smartfony" style="color:#fe7a0b;"  class="daria-goto-anchor" target="_blank" rel="noopener noreferrer">
                            Каталог товаров
                        </a>
                    </div>
                    <div style="margin-top:5px;">
                        <a href="{{ route('contact') }}" style="color:#fe7a0b;"  class="daria-goto-anchor" target="_blank" rel="noopener noreferrer">
                            Контакты
                        </a>
                    </div>
                </div>
                <div style="width:200px;float:left;">
                    <div style="margin-top:5px;">
                        <a href="{{ route('guaranty') }}" style="color:#fe7a0b;"  class="daria-goto-anchor" target="_blank" rel="noopener noreferrer">
                            Гарантия
                        </a>
                    </div>
                    <div style="margin-top:5px;">
                        <a href="{{ route('delivery_payment') }}/" style="color:#fe7a0b;"  class="daria-goto-anchor" target="_blank" rel="noopener noreferrer">
                            Доставка, оплата
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div style="background:#f2f2f2;height:44px;line-height:44px;padding-left:30px;font-weight:bold;">Социальные сети:</div>

        <div style="padding:20px 30px;overflow:hidden;">
            <div style="float:left;font-size:12px;width:360px;">Следите за нашими группами в социальных сетях, участвуйте в розыгрышах и акциях!</div>

            <div style="float:right;margin-right:50px;overflow:hidden;">
                <div style="float:left;margin-right:5px;">
                    <a href="{{ config('shop.social_network.instagram') }}"  title="Мы в Instagram" class="daria-goto-anchor" target="_blank" rel="noopener noreferrer">
                        <img width="29" src="{{ env('APP_URL') }}/site/images/insta.png">
                    </a>
                </div>
            </div>
        </div>

        <div style="background:#333333;padding:40px 30px 40px 30px;overflow:hidden;">
            <div style="float:left;width:370px;padding-right:30px;">
                <div style="font-weight:bold;color:#fff;">О компании</div>

                <div style="color:#636363;margin-top:8px;font-size:12px;">
                    Вы предпочитаете покупать исключительно качественную электронную технику, имеющую все необходимые сертификаты? Значит,
                    магазин «{{env('APP_NO_URL')}}» – то, что вам нужно! Мы рады приветствовать на этом сайте каждого покупателя и готовы
                    предложить вам только подлинные устройства популярных брендов.
                </div>

                <div style="margin-top:20px;overflow:hidden;">
                    <div style="float:left;">
                        <img style="margin-right:7px;" src="https://resize.yandex.net/mailservice?url=https%3A%2F%2Fru-mi.com%2Fimages_for_mail%2Ffeedback.png&amp;proxy=yes&amp;key=5edc0f298698766dfc2177bcf01cf9df">
                    </div>

                    <div style="float:left;padding-top:2px;">
                        <a href="{{ route('contact') }}" style="color:#dc7846;font-size:12px;" class="daria-goto-anchor" target="_blank" rel="noopener noreferrer">
                            Обратная связь</a>
                    </div>
                </div>
            </div>

            @php
                $address = config('shop.address');
                $number_phones = config('shop.number_phones');
            @endphp

            <div style="float:left;width:215px;">
                <div style="font-weight:bold;color:#fff;">Наши контакты</div>

                <div style="color:#afafaf;margin-top:8px;font-size:12px;">
                    {{ $address[0]['addressLocality'] }}, {{ $address[0]['streetAddress'] }}
                </div>

                <div style="color:#afafaf;margin-top:8px;font-size:12px;margin-top:15px;">
                    <div style="color:#fff;text-decoration:underline;font-size:12px;">E-mail:
                        <a href="mailto:{{ env('MAIL_ADMIN') }}" style="color:#fff;font-size:12px;" class="ns-action">
                            {{ env('MAIL_ADMIN') }}
                        </a>
                    </div>

                    <div style="color:#fff;text-decoration:underline;font-size:12px;margin-top:5px;">Позвоните нам:
                        <span class="wmi-callto">
                            <a href="tel: {{ $number_phones[0]['number'] }}" style="color: #ffffff;">
                                {{ $number_phones[0]['format'] }}
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div style="background:#fff;height:60px;line-height:60px;padding-left:30px;">
            <div style="display:inline-block;height:60px;padding-top:10px;margin-right:15px;vertical-align:top;">
               <img src="{{ config('shop.logo') }}" width="100px"/>
            </div>

            <div style="display:inline-block;text-decoration:underline;vertical-align:top;">
                <a href="{{ route('index') }}" style="color:#333333;font-size:12px;"  class="daria-goto-anchor" target="_blank" rel="noopener noreferrer">
                    {{ env('APP_NAME') }}
                </a>
            </div>
        </div>
    </div>

    <div style="text-align:center;margin-top:25px;margin-bottom:50px;">
        <div style="font-size:13px;color:#333333;font-weight:bold;">© 2018 – {{ date('Y') }} {{ env('APP_NO_URL') }}</div>

        <div style="font-size:12px;color:#636363;margin:0 auto;margin-top:15px;">Данное сообщение отправлено автоматически, пожалуйста не отвечайте на него.</div>
    </div>
</div>