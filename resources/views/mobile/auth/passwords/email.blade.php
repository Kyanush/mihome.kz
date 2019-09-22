@include('mobile.includes.topbar', [
    'class'       => '_fixed',
    'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>Забыли пароль?</a>',
    'search_show' => false,
    'menu_link'   => '',
    'menu_class'  => 'icon_menu'
])

<div class="container g-pa0 g-bb-fat g-bg-c0">
    <div class="g-bb-fat">
        @include('mobile.includes.message')

        @if (session('status'))
            <div class="message">
                <div class="warning _green">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <div class="container-title">
             Введите адрес электронной почты Вашей учетной записи. Нажмите кнопку Вперед, чтобы получить пароль по электронной почте.
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

                <div>
                    <div class="input _focused">
                        <label class="input__label">E-Mail *</label>
                            <input  class="input__input"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required/>
                    </div>
                </div>
                <input class="button _big _space" type="submit" value="Продолжить"/>
        </form>
    </div>
</div>

@include('mobile.includes.footer')