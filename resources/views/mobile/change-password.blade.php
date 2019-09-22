@extends('layouts.mobile')

<?php $title = "Смена пароля"; ?>
@section('title', $title)
@section('description', $title)
@section('keywords', $title)

@section('content')

    @include('mobile.includes.topbar', [
        'class'       => '_fixed',
        'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>' . $title . '</a>',
        'search_show' => false,
        'menu_link'   => '',
        'menu_class'  => 'icon_menu'
    ])
    @include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

    <div class="container g-pa0 g-bb-fat g-bg-c0">
        @include('mobile.includes.message')
        <form action="" method="post" enctype="multipart/form-data">
            @csrf

            <div class="input _focused">
                <label class="input__label">Пароль</label>
                <input type="password" name="password" class="input__input"/>
            </div>
            <div class="input _focused">
                <label class="input__label">Подтвердите пароль</label>
                <input type="password" name="password_confirmation" class="input__input"/>
            </div>

            <button type="submit" class="button _big _space">Изменить</button>

        </form>
    </div>

    @include('mobile.includes.footer')

@endsection