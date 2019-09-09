@extends('layouts.site')

<?php $title = "Авторизация"; ?>
@section('title', $title)
@section('description', $title)
@section('keywords', $title)


@section('content')


    <?php $breadcrumbs = [
        [
            'title' => 'Главная',
            'link'  => '/'
        ],
        [
            'title' => 'Личный кабинет',
            'link'  => '/my-account'
        ],
        [
            'title' => 'Логин',
            'link'  => ''
        ]
    ];?>
    @include('site.includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <div class="section">
        <!-- container -->
        <div class="container">

                <div class="row">
                    <div class="col-md-6">
                        <h4>Новый клиент</h4>
                        <p>Создав учетную запись Вы сможетете быстрее оформлять заказы, отслеживать их статус и просматривать историю покупок.</p>
                        <a href="/register" class="button"><span>Регистрация</span></a>
                    </div>
                    <div class="col-md-4">
                        <h4>Войти в Личный Кабинет</h4>

                        <form action="{{ route('login') }}" id="form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>E-Mail:</label>
                                <input required autofocus type="text" class="input {{ $errors->has('email') ? ' is-invalid' : '' }}"  name="email" value="{{ old('email') }}"/>
                            </div>

                            <div class="form-group">
                                <label>Пароль:</label><br>
                                <input id="password" type="password" class="input {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            </div>
                            <div class="form-group">
                                <a href="{{ route('password.request') }}">Забыли пароль?</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-firm">Войти</button>
                            </div>
                        </form>
                    </div>
                </div>

        </div>
    </div>


@endsection
