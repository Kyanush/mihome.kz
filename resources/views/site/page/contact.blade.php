@extends('layouts.site')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

    <?php $breadcrumbs = [
        [
            'title' => 'Главная',
            'link'  => '/'
        ],
        [
            'title' => $seo['title'],
            'link'  => ''
        ]
    ];?>
    @include('site.includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

    @php
        $address = config('shop.address');
        $number_phones = config('shop.number_phones');
    @endphp

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <div class="contact">
                <p>
                    Обсудить с нами возникшие вопросы или проконсультироваться звоните к нам по номеру:
                    <a style="font-size: 14px;text-decoration: none;" href="tel:{{ $number_phones[0]['number'] }}">
                        {{ $number_phones[0]['format'] }}
                    </a>
                    (ежедневно с 11-00 до 19-00).
                    Кроме того, Вы можете отправить любые запросы или вопросы нам на электронную почту
                    <a style="font-size: 14px;text-decoration: none;" href="mailto:{{ config('shop.site_email') }}">
                        {{ config('shop.site_email') }}
                    </a> ,
                    не забудьте указать Ваше имя и контактные номера телефонов. Если Вас не устраивают какие-либо наши товары или услуги,
                    мы с удовольствием выслушаем Вас. Мы всегда готовы решить проблему.
                </p>
                <br/>
                <p>
                <div class="row">
                    <div class="col-md-4">
                        <ul>
                            <li><b>Ежедневно, круглосуточно(телефон или WhatsApp)</b></li>
                            <li><a href="tel:{{ $number_phones[0]['number'] }}">{{ $number_phones[0]['format'] }}</a></li>
                            <li><b>Время работы</b></li>
                            <li>{{ $address[0]['working_hours'] }}</li>
                            <li><b>Адрес</b></li>
                            <li>{{ $address[0]['addressLocality'] }}, {{ $address[0]['streetAddress'] }}</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li><b>Вопросы по розничным продажам и.д.</b></li>
                            <li>
                                <a href="mailto:{{ config('shop.site_email') }}">
                                    {{ config('shop.site_email') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li><b>Мы в соцсетях.</b></li>
                            <li>
                                <a href="{{ config('shop.social_network.instagram') }}" title="Вы в Instagram" target="_blank">
                                    <i class="fa fa-instagram fa-2x"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                </p>
                <br/>
                <p>
                    @if(env('APP_NO_URL') == 'Magazin-Xiaomi.kz')
                        <iframe src="https://yandex.ru/map-widget/v1/?z=12&ol=biz&oid=97441155893" width="100%" height="600" frameborder="0"></iframe>
                    @endif
                    @if(env('APP_NO_URL') == 'MiHome.kz')
                        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A0907f0b379ab1ff176a45fb714a2ee57862dd92278b63d35c0061ca3d613456b&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
                    @endif
                </p>
            </div>
        </div>
    </div>


@endsection
