@extends('layouts.site')

@section('title', 'Регистрация в интернет магазине ' . env('APP_NAME'))
@section('description', 'Регистрация в интернет магазине ' . env('APP_NAME'))
@section('keywords', 'Регистрация в интернет магазине ' . env('APP_NAME'))

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
                'title' => 'Регистрация',
                'link'  => ''
            ]
        ];?>
        @include('site.includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])


        <!-- SECTION -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-3">
                        @include('site.includes.menu_left_my_account')
                    </div>
                    <div class="col-md-4">
                        <h4>Регистрация</h4>

                            <form id="register" action="{{ route('register') }}" method="post" enctype="multipart/form-data" id="simplepage_form">
                                @csrf

                                <div class="form-group">
                                    <p>
                                        Если Вы уже зарегистрированы, перейдите на страницу <a href="{{ route('login') }}">входа в систему</a>.
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email"
                                           placeholder="Электронная почта *"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           class="input"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Пароль:</label>
                                    <input id="password"
                                           placeholder="Пароль *"
                                           class="input"
                                           type="password"
                                           name="password"
                                           required/>
                                </div>
                                <div class="form-group">
                                    <label>Повторите пароль:</label>
                                    <input
                                            placeholder="Повторите пароль *"
                                            class="input"
                                            type="password"
                                            name="password_confirmation"
                                            required/>
                                </div>
                                <div class="form-group">
                                    <label>Имя:</label>
                                    <input
                                            type="text"
                                            name="name"
                                            class="input"
                                            value="{{ old('name') }}"
                                            placeholder="Имя *">
                                </div>
                                <div class="form-group">
                                    <label>Телефон:</label>
                                    <input
                                            type="tel"
                                            name="phone"
                                            class="input"
                                            class="phone-mask"
                                            value="{{ old('phone') }}"
                                            placeholder="Мобильный телефон *">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-firm">Продолжить</button>
                                </div>

                            </form>

                    </div>
                </div>
            </div>
        </div>



@endsection
