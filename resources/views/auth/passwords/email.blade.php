@extends('layouts.site')

<?php $title = 'Забыли пароль?';?>
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

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h4>Забыли пароль?</h4>
                        <form id="form" method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group">
                                <p>Введите адрес электронной почты Вашей учетной записи. Нажмите кнопку Вперед, чтобы получить пароль по электронной почте.</p>
                            </div>

                            <div class="form-group">
                                <label>E-Mail:</label>
                                <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required>
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
