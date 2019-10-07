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
                    Остались вопросы? Наш call center к вашим услугам ежедневно с 11:00 до 19:00.
                    Дозвониться к нам можно по номерам:
                    @foreach($number_phones as $phone)
                        <a style="font-size: 14px;text-decoration: none;"  href="tel: {{ $phone['number'] }}"> {{ $phone['format'] }}</a>
                    @endforeach
                    .
                    Также наша почта <a style="font-size: 14px;text-decoration: none;" href="mailto:{{ config('shop.site_email') }}">
                        {{ config('shop.site_email') }}
                    </a> всегда готова выслушать ваши претензии. Для получения обратной связи укажите свой телефон и ваше имя.
                    Мы открыты к любым предложениям.
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
                                @foreach(config('shop.social_network') as $item)
                                    <a href="{{ $item['url'] }}" title="{{ $item['title'] }}" target="_blank">
                                        <img height="30" src="{{ $item['icon'] }}"/>
                                    </a>
                                @endforeach
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
