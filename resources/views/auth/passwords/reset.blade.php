@extends('layouts.site')

<?php $title = 'Сброс пароля';?>
@section('title',       $title)
@section('description', $title)
@section('keywords',    $title)

@section('content')



            <?php $breadcrumbs = [
                [
                    'title' => 'Главная',
                    'link'  => '/'
                ],
                [
                    'title' => $title,
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
                        <h4>Забыли пароль?</h4>

                        <form id="form" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label>Адрес электронной почты:</label>
                                <input class="input" type="email"  name="email" value="{{ $email ?? old('email') }}" required autofocus/>
                            </div>
                            <div class="form-group">
                                <label>Пароль:</label>
                                <input class="input" type="password" name="password" required/>
                            </div>
                            <div class="form-group">
                                <label>Подтвердите Пароль:</label>
                                <input class="input" type="password" name="password_confirmation" required/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-firm">Сброс пароля</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>



@endsection
