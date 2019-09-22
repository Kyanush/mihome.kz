@include('mobile.includes.topbar', [
    'class'       => '_fixed',
    'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>Забыли пароль?</a>',
    'search_show' => false,
    'menu_link'   => '',
    'menu_class'  => 'icon_menu'
])

@include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

<div class="container g-pa0 g-bb-fat g-bg-c0">
    <div class="g-bb-fat">
        @include('mobile.includes.message')
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <div class="input _focused">
                        <label class="input__label">Адрес электронной почты</label>
                        <input  class="input__input"
                                type="email"
                                name="email"
                                value="{{ $email ?? old('email') }}"
                                required
                                autofocus/>
                    </div>
                    <div class="input _focused">
                        <label class="input__label">Новый пароль</label>
                        <input  class="input__input"
                                type="password"
                                name="password"
                                required/>
                    </div>
                    <div class="input _focused">
                        <label class="input__label">Подтвердите пароль</label>
                        <input  class="input__input"
                                type="password"
                                name="password_confirmation"
                                required/>
                    </div>
                </div>
                <input class="button _big _space" type="submit" value="Сброс пароля"/>
        </form>
    </div>
</div>

@include('mobile.includes.footer')