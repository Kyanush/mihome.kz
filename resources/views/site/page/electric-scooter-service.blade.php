@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/electric_scooter_service/img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">

    @include('includes.department_code')

    <link rel="stylesheet" type="text/css" href="/electric_scooter_service/css/global.css">
    <link rel="stylesheet" type="text/css" href="/electric_scooter_service/css/nice-select.css">
    <link rel="stylesheet" type="text/css" href="/electric_scooter_service/css/style.css">
    <link rel="stylesheet" type="text/css" href="/electric_scooter_service/css/adaptive.css">

    <link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600&amp;subset=latin,cyrillic">

    <script type="text/javascript" src="{{ asset('/site/js/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('/site/js/jquery.lazyload.min.js') }}"></script>




</head>
<body>



@php
    $address = config('shop.address');
    $number_phones = config('shop.number_phones');
@endphp


<div id="wrapper">
    <header id="header">
        <div class="inner">
            <div class="fleft rL">
                <a href="{{ route('electricScooterService') }}">
                    <img src="/electric_scooter_service/img/logo.jpg" alt="">
                </a>
            </div>
            <div class="rL button_block">
                <p class="bingc-action-open-passive-form w100 h100 button alCenter cp button-2 button01">Заказать звонок</p>
            </div>
            <div class="fright rL">

                @foreach($number_phones as $phone)
                    <a href="tel:{{ $phone['number'] }}" class="db button">
                        {{ $phone['format'] }}
                    </a>
                @endforeach

            </div>
            <div class="fright nowrap address">
                 {{ $address[0]['streetAddress'] }}
            </div>
            <div class="clear"></div>
        </div>
    </header>
    <main id="main">
        <div class="repairs rL hid">
            <div class="inner">

                <h1 class="h2 db alCenter">Ремонт электросамокатов и гироскутеров в  Алматы</h1>

                <div class="row rL hid">
                    <div class="item box rL fright w25">
                        <img src="/electric_scooter_service/img/Icon3.png" alt="" class="db alCenter">
                        <img src="/electric_scooter_service/img/Iconmob3.png" alt="" class="db alCenter hide">
                        <span class="alCenter db">Курьер приедет<b class="p"></b> за 40 минут бесплатно</span>
                    </div>
                    <div class="item box rL fright w25">
                        <img src="/electric_scooter_service/img/Icon2.png" alt="" class="db alCenter">
                        <img src="/electric_scooter_service/img/Iconmob2.png" alt="" class="db alCenter hide">
                        <span class="alCenter db">Ремонт<b class="p"></b> за 1 день</span>
                    </div>
                    <div class="item box rL fright w25">
                        <img src="/electric_scooter_service/img/Icon1.png" alt="" class="db alCenter">
                        <img src="/electric_scooter_service/img/Iconmob1.png" alt="" class="db alCenter hide">
                        <span class="alCenter db">Диагностика<b class="p"></b> бесплатно</span>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="row rL hid hide">
                    <div class="item box rL fright w25">
                        <img src="/electric_scooter_service/img/Icon3.png" alt="" class="db alCenter">
                        <img src="/electric_scooter_service/img/Iconmob3.png" alt="" class="db alCenter hide">
                        <span class="alCenter db">Ремонт<b class="p"></b> за 1 день</span>
                    </div>
                    <div class="item box rL fright w25">
                        <img src="/electric_scooter_service/img/Icon1.png" alt="" class="db alCenter">
                        <img src="/electric_scooter_service/img/Iconmob1.png" alt="" class="db alCenter hide">
                        <span class="alCenter db">Курьер приедет<b class="p"></b> за 40 минут бесплатно</span>
                    </div>
                    <div class="item box rL fright w25">
                        <img src="/electric_scooter_service/img/Icon2.png" alt="" class="db alCenter">
                        <img src="/electric_scooter_service/img/Iconmob2.png" alt="" class="db alCenter hide">
                        <span class="alCenter db">Диагностика<b class="p"></b> бесплатно</span>
                    </div>
                    <div class="clear"></div>
                </div>

                <p class="bingc-action-open-passive-form w100 h100 button alCenter cp fright button-2 button-2 button0">Вызвать курьера</p>
                <div class="clear"></div>
            </div>
        </div>
        <div class="problem rL">
            <div class="inner">
                <span class="h2 alCenter db">Что случилось с вашим транспортом?</span>
                <form>
                    <select name="" id="main_select">
                        <option value="1">Датчик неверно показывает</option>
                        <option value="2">Не работает дисплей</option>
                        <option value="3">Проблемы с колесами</option>
                        <option value="4">Не разгоняется</option>
                        <option value="5">Не заряжается</option>
                    </select>
                    <div class="clear"></div>
                </form>
                <div class="w50 fleft rL">
                    <p class="bingc-action-open-passive-form button cp button-2">Узнать стоимость</p>
                </div>
                <div class="w50 fleft rL">
                    <p class="bingc-action-open-passive-form button cp button-2">Связаться с менеджером</p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="advantages rL hid">
            <div class="inner">
                <div class="row rL hid">
                    <div class="item box rL fleft w33-3">
                        <img src="/electric_scooter_service/img/Icon4.png" alt="" class="db alCenter">
                        <img src="/electric_scooter_service/img/Iconmob3.png" alt="" class="db alCenter hide">
                        <p class="alCenter">Гарантия</p>
                        <span class="alCenter db">Даём гарантию «под печать»<b class="p"></b>
от 1 года до 3-х лет</span>
                    </div>
                    <div class="item box rL fleft w33-3">
                        <img src="/electric_scooter_service/img/Icon5.png" alt="" class="db alCenter">
                        <img src="/electric_scooter_service/img/Iconmob2.png" alt="" class="db alCenter hide">
                        <p class="alCenter">Оригинальные запчасти</p>
                        <span class="alCenter db">Предоставляем сертификаты<b class="p"></b>
подлинности</span>
                    </div>
                    <div class="item box rL fleft w33-3">
                        <img src="/electric_scooter_service/img/Icon6.png" alt="" class="db alCenter">
                        <img src="/electric_scooter_service/img/Iconmob1.png" alt="" class="db alCenter hide">
                        <p class="alCenter">Профессионализм</p>
                        <span class="alCenter db">Опыт работы мастеров<b class="p"></b>
более 10 лет</span>
                    </div>
                    <div class="clear"></div>
                </div>
                <p class="bingc-action-open-passive-form w100 h100 button alCenter cp button-2 button0">Оформить диагностику</p>
                <div class="clear"></div>
            </div>
        </div>
        <div class="evacuation rL hie">
            <div class="inner">
                <span class="h2 db alCenter">Эвакуация за 40 минут.</span>
                <p class="alCenter">Курьер заберёт ваш транспорт в сервис, а вас доставит<b class="p"></b> до пункта «Б» – бесплатно!</p>
                <p class="bingc-action-open-passive-form w100 h100 button alCenter cp button-2 button0">Вызвать курьера</p>
            </div>
        </div>
        <div class="catalog rL hid">
            <div class="inner">
                    <span class="h2 db alCenter">Ремонт электротранспорта всех брендов и моделей</span>

                <?php
                $scooters = [
                    [
                        'img'  => '/electric_scooter_service/scooters/item.png',
                        'name' => 'Xiaomi Mijia'
                    ],
                    [
                        'img'  => '/electric_scooter_service/scooters/item2.png',
                        'name' => 'Ninebot ES1'
                    ],
                    [
                        'img'  => '/electric_scooter_service/scooters/item3.png',
                        'name' => 'Balancing Wheel B03'
                    ],
                    [
                        'img'  => '/electric_scooter_service/scooters/item4.png',
                        'name' => 'Airwhell Z8'
                    ],
                    [
                        'img'  => '/electric_scooter_service/scooters/item5.png',
                        'name' => 'Kickscooter ES1'
                    ],
                    [
                        'img'  => '/electric_scooter_service/scooters/item6.png',
                        'name' => 'Jack Hot 4.4'
                    ],
                    [
                        'img'  => '/electric_scooter_service/scooters/item7.png',
                        'name' => 'Kugoo S2'
                    ],
                    [
                        'img'  => '/electric_scooter_service/scooters/item8.png',
                        'name' => 'Kuaike K1'
                    ],
                    [
                        'img'  => '/electric_scooter_service/scooters/item9.png',
                        'name' => 'Fastwheel eva-classic'
                    ],
                    [
                        'img'  => '/electric_scooter_service/scooters/item10.png',
                        'name' => 'Smart balance'
                    ],
                    [
                        'img'  => '/electric_scooter_service/scooters/item11.png',
                        'name' => 'Cactus CS'
                    ],
                    [
                        'img'  => '/electric_scooter_service/scooters/item12.png',
                        'name' => 'SB affroad'
                    ]
                ];
                ?>

                <div class="row rL hid">

                    @foreach($scooters as $item)
                        <div class="item box fleft rL w25">
                            <div class="block box rL cp button-3">
                                <a class="bingc-action-open-passive-form db w100" style="background-image: url('{{ $item['img'] }}');"></a>
                                <p class="alCenter">{{ $item['name'] }}</p>
                            </div>
                        </div>
                    @endforeach

                    <div class="clear"></div>
                </div>
                <a class="bingc-action-open-passive-form db alCenter search rL button-2 cp">Не нашли свою модель?</a>
            </div>
        </div>
        <div class="warranty rL hid">
            <div class="inner">
                <span class="h2 db alCenter">Гарантия низкой цены</span>
                <p class="alCenter">найдёшь дешевле и мы опустим стоимость:</p>
                <div class="block">
                    <div class="tb w100 alCenter">
                        <div class="tr">
                            <div class="tbc vM">Ремонт/замена АКБ</div>
                            <div class="tbc vM">от 2490 тг</div>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="tb w100 alCenter">
                        <div class="tr">
                            <div class="tbc vM">Замена мотора колеса </div>
                            <div class="tbc vM">от 3490 тг</div>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="tb w100 alCenter">
                        <div class="tr">
                            <div class="tbc vM">Ремонт/замена котроллера</div>
                            <div class="tbc vM">от 1990 тг</div>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="tb w100 alCenter">
                        <div class="tr">
                            <div class="tbc vM">Замена покрышки</div>
                            <div class="tbc vM">от 1490 тг</div>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="tb w100 alCenter">
                        <div class="tr">
                            <div class="tbc vM">Ремонт проводки</div>
                            <div class="tbc vM">от 2990 тг</div>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="tb w100 alCenter">
                        <div class="tr">
                            <div class="tbc vM">Ремонт/замена фар</div>
                            <div class="tbc vM">от 2990 тг</div>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="tb w100 alCenter">
                        <div class="tr">
                            <div class="tbc vM">Устранение люфта</div>
                            <div class="tbc vM">от 1990 тг</div>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="tb w100 alCenter">
                        <div class="tr">
                            <div class="tbc vM">Настройка тормоза</div>
                            <div class="tbc vM">от 2990 тг</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="reviews rL">
            <div class="inner">
                <span class="h2 db alCenter">Наши отзывы</span>
                <div class="slider_clients rL">
                    <div class="item">
                        <div class="block rL box">
                            <div class="user_block">
                                <div class="fleft rL" style="background-image:url(/electric_scooter_service/img/reviews.png); "></div>
                                <div class="fright rL">
                                    <p>Ерик Атказин</p>
                                    <ul>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                    </ul>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <span class="db review">На день рождение подарили сыну гироскутер. Так он все время то и дело, что катался на нем. В итоге перестала играть музыка. Он был расстроен. После чего я решил обратится в сервисный центр ОдинСервис. По моим просьбам его отремонтировали очень быстро. Также решил сразу же воспользоваться и услугой по ремонту бытовой техники. После ремонта все работает на высшем уровне. сервису ставлю 5+</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="block rL box">
                            <div class="user_block">
                                <div class="fleft rL" style="background-image:url(/electric_scooter_service/img/reviews1.jpg); "></div>
                                <div class="fright rL">
                                    <p>Виктор Усачёв</p>
                                    <ul>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                    </ul>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <span class="db review">На электросамокате Xiaomi нужно было заменить камеру переднего колеса, батарею так как не включался электросамокат, и убрать люфт руля- болтался. Камеру заменили, всё в порядке. батарею заменили (заряжает, включается, работает). Люфт руля убрали. Менеджера проверили электросамокат после ремонта и только после этого выдали в полностью рабочем состоянии. Спасибо, рекомендую!</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="block rL box">
                            <div class="user_block">
                                <div class="fleft rL" style="background-image:url(/electric_scooter_service/img/reviews2.jpg); "></div>
                                <div class="fright rL">
                                    <p>Айнура Раисова</p>
                                    <ul>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                        <li class="inb vM" style="background-image: url(/electric_scooter_service/img/star.png);"></li>
                                    </ul>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <span class="db review">Обращались в этот сервис несколько раз, отдавали на ремонт гироскутер, компьютер и мелкие гаджеты. Огромный плюс, что мастера берутся чинить практически любую технику, да и поломки устраняют тоже любой сложности. Цены адекватные, ремонт производился быстро и четко, без каких-либо заминок. Если нужно было что-то заменить, специалисты сами занимались поиском и подбором нужной запчасти. Обращаться приятно, по телефону отвечают вежливо, а мастера относятся к работе щепетильно.</span>
                        </div>
                    </div>
                </div>
                <p class="bingc-action-open-passive-form w100 h100 button alCenter cp button-2 button0">Связаться с менеджером</p>
            </div>
        </div>

        <div class="hurry-popup">
            <img src="/electric_scooter_service/img/qual/hurry.png" class="hurry-desc" alt="">
            <div class="hurry-mob-wrapper">
                <div class="closeblock close-mob">+</div>
                <img src="/electric_scooter_service/img/qual/hurry-mob.jpg" class="hurry-mob" alt="">
                <div class="btn-mob-wrapper">
                    <button class="bingc-action-open-passive-form hurry-btn hurry-btn-mob">
                            <span>Получить<br>
                        супер-комбо

                    </span>
                    </button>
                </div>

                <img src="/electric_scooter_service/img/qual/hurry-mob2.jpg" class="hurry-mob" alt="">
            </div>

            <div class="closeblock close-desc">+</div>
            <button class="bingc-action-open-passive-form hurry-btn hurry-btn-desc">
                    <span>Получить<br>
                супер-комбо

            </span>
            </button>
        </div>






        <div class="footer rL hid">
            <div class="fright rL">
                <span class="h2 db">Контакты</span>
                <p class="rL"> {{ $address[0]['streetAddress'] }}</p>
                <div class="fon">
                    @foreach($number_phones as $k => $phone)
                        <a href="tel:{{ $phone['number'] }}" class="@if($k == 0) rL @endif db">
                            {{ $phone['format'] }}
                        </a>
                    @endforeach
                </div>
                <div class="rights">1сервис {{ date('Y') }} © Все права защищены.</div>
            </div>
            <div class="rL hid">
                <div class="block">
                    <div id="map"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </main>
</div>





<script src="/electric_scooter_service/js/jquery-1.12.1.js"></script>
<script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>
<script src="/electric_scooter_service/js/jquery.nice-select.js"></script>
<script src="/electric_scooter_service/js/owl.carousel.js"></script>
<script src="/electric_scooter_service/js/es.js"></script>

<script src="/global/script.js"></script>


<script src="/site/js/jquery.lazyload.min.js"></script>
<script src="/site/js/jquery.maskedinput.min.js"></script>

<script src="/electric_scooter_service/js/script.js"></script>


<div id="callback" class="callback" style="display: none;">
    <form action="javascript:void(null);" onsubmit="callback(this); return false;" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="url" value="{{ url()->current() }}"/>
        <p>
            Введите номер телефона
        </p>
        <p>
                <input type="text"
                       name="phone"
                       class="form-control phone-mask"
                       placeholder="+7 (___) ___-__-__">
        </p>
        <p>
            <button type="submit">
                Отправить
            </button>
        </p>
    </form>
</div>


@include('includes.analytics_body')
@include('includes.analytics')

</body>
</html>
