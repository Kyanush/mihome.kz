@include('mobile.includes.topbar', [
    'class'       => '_fixed',
    'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>Регистрация</a>',
    'search_show' => false,
    'menu_link'   => '',
    'menu_class'  => 'icon_menu'
])

@include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

<div class="container g-pa0 g-bb-fat g-bg-c0">
    <div class="g-bb-fat">
        @include('mobile.includes.message')

            <div class="container-title">
                Если Вы уже зарегистрированы, перейдите на страницу входа в систему.
            </div>

            <form action="{{ route('register') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="input _focused">
                        <label class="input__label">Email</label>
                        <input class="input__input"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required/>
                    </div>
                </div>
                <div>
                    <div class="input _focused">
                        <label class="input__label">Пароль</label>
                        <input class="input__input"
                               type="password"
                               name="password"
                               required>
                    </div>
                </div>
                <div>
                    <div class="input _focused">
                        <label class="input__label">Повторите пароль</label>
                        <input  class="input__input"
                                type="password"
                                name="password_confirmation"
                                required/>
                    </div>
                </div>
                <div>
                    <div class="input _focused">
                        <label class="input__label">Имя</label>
                        <input  class="input__input"
                                type="text"
                                name="name"
                                value="{{ old('name') }}">
                    </div>
                </div>
                <div>
                    <div class="input _focused">
                        <label class="input__label">Телефон</label>
                        <input  class="input__input phone-mask"
                                type="tel"
                                name="phone"
                                value="{{ old('phone') }}">
                    </div>
                </div>
                <input class="button _big _space" type="submit" value="Продолжить"/>

                <br/>
                <p class="text-center">
                    <a class="container-more-link" href="/login">Авторизация</a>
                </p>
                <p class="text-center">
                    <a class="container-more-link" href="/register">Регистрация</a>
                </p>

            </form>
    </div>
</div>


@include('mobile.includes.footer')