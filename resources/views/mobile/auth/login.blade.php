@include('mobile.includes.topbar', [
    'class'       => '_fixed',
    'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>Авторизация</a>',
    'search_show' => false,
    'menu_link'   => '',
    'menu_class'  => 'icon_menu'
])
@include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

<div class="container g-pa0 g-bb-fat g-bg-c0">
    @include('mobile.includes.message')
    <form action="{{ route('login') }}" id="form" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="input _focused">
                <label class="input__label">E-Mail *</label>
                <input required
                       autofocus
                       type="text"
                       class="input__input"
                       name="email"
                       value="{{ old('email') }}"/>
            </div>
            <div class="input _focused">
                <label class="input__label">Пароль *</label>
                <input
                       id="password"
                       type="password"
                       class="input__input"
                       name="password"
                       required>
            </div>
            <input class="button _big _space" type="submit" value="Войти"/>
            <br/>
            <p class="text-center">
                <a class="container-more-link" href="{{ route('password.request') }}">Забыли пароль?</a>
            </p>
            <p class="text-center">
                <a class="container-more-link" href="/register">Регистрация</a>
            </p>
    </form>
</div>


@include('mobile.includes.footer')