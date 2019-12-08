@extends('layouts.mobile')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

    @include('mobile.includes.topbar', [
        'class'       => '_fixed',
        'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>' . $seo['title'] . '</a>',
        'search_show' => false,
        'menu_link'   => '',
        'menu_class'  => 'icon_menu'
    ])
    @include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

    @php
        $address = config('shop.address');
        $number_phones = config('shop.number_phones');
    @endphp

    <div class="container">
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
        <p>
            <ul>
                <li>
                    <b>Телефоны:</b>
                    <br/>
                    Ежедневно, круглосуточно(телефон или WhatsApp)
                    <br/>
                    @foreach($number_phones as $phone)
                        <a href="tel: {{ $phone['number'] }}"> {{ $phone['format'] }}</a>
                    @endforeach
                </li>
                <li>
                    <b>Время работы:</b>
                    <br/>
                    {{ $address[0]['working_hours'] }}
                </li>
                <li>
                    <b>Адрес:</b>
                    <br/>
                    {{ $address[0]['addressLocality'] }}, {{ $address[0]['streetAddress'] }}
                </li>
                <li>
                    <b>E-mail:</b>
                    <br/>
                    Вопросы по розничным продажам и.д.
                    <br/>
                    <a href="mailto:{{ config('shop.site_email') }}">{{ config('shop.site_email') }}</a>
                </li>

            </ul>
        </p>
        <p>
            <ul>
                <li><b>Мы в соцсетях.</b></li>
                <li>
                    <p>
                        @foreach(config('shop.social_network') as $item)
                            <a href="{{ $item['url'] }}" title="{{ $item['title'] }}" target="_blank" rel="nofollow">
                                <img height="30" src="{{ $item['icon'] }}"/>
                            </a>
                        @endforeach
                    </p>
                </li>
            </ul>
        </p>
        <p>
            <iframe src="https://yandex.ru/map-widget/v1/?z=12&ol=biz&oid=64393237639" width="100%" height="600" frameborder="0"></iframe>
        </p>
    </div>

    @include('mobile.includes.footer')

@endsection
