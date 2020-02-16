@extends('layouts.mail')
@section('content')

    <p>Здравствуйте, <b>{{ $order->user->name }}</b></p>
    <p>Ваш заказ № <a href="{{ route('order_history_detail', ['order_id' => $order->id]) }}"> <b>{{ $order->id }}</b></a></p>
    <p>Статус вашего заказа: <b>{{ $order->status->name }}</b></p>


    @if($order->status->id == 5)
        <br/>
        <br/>
        <h2 style="text-align: center;color: red;">Уважаемый покупатель!!! Здесь Вы можете оставить свои отзывы, пожелания и предложения!!! Ваше мнение нам важно!!! С Уважением !!</h2>
        <br/>
        <p style="text-align: center;">
            @foreach(config('shop.social_network') as $key => $item)
                @if(in_array($key, ['yandex', 'google', '2gis']))
                    <a href="{{ $item['url'] }}" title="{{ $item['title'] }}" target="_blank" rel="nofollow">
                        <img height="30" src="{{ $item['icon'] }}"/>
                    </a>
                    &nbsp;
                    &nbsp;
                @endif
            @endforeach
        </p>


        <br/>
        <br/>
        <h2 style="text-align: center;color: red;">Подписывайтесь на наш Instagram! <br/> Будь в курсе всех новинок!</h2>
        <br/>
        <p style="text-align: center;">
            @foreach(config('shop.social_network') as $key => $item)
                @if(in_array($key, ['instagram']))
                    <a href="{{ $item['url'] }}" title="{{ $item['title'] }}" target="_blank" rel="nofollow">
                        <img height="30" src="{{ $item['icon'] }}"/>
                    </a>
                @endif
            @endforeach
        </p>
    @endif


@endsection