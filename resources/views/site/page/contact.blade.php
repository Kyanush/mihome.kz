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
                    @foreach($number_phones as $phone)
                        <a style="font-size: 14px;text-decoration: none;"  href="tel: {{ $phone['number'] }}"> {{ $phone['format'] }}</a>
                    @endforeach

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
                            <li>
                                @foreach($number_phones as $phone)
                                    <a style="font-size: 14px;text-decoration: none;"  href="tel: {{ $phone['number'] }}"> {{ $phone['format'] }}</a>
                                    <br/>
                                @endforeach
                            </li>
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
                      <iframe src="https://yandex.ru/map-widget/v1/?z=12&ol=biz&oid=64393237639" width="100%" height="400" frameborder="0"></iframe>
                </p>
            </div>
        </div>
    </div>


@endsection
