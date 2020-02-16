@extends(\App\Tools\Helpers::isMobile() ? 'layouts.mobile' : 'layouts.site')

@section('title',       'Новости')
@section('description', 'Новости о компании '. env('APP_NO_URL'))
@section('keywords',    'Новинки, Обзоры, Сравнения')

@section('content')


    @if(\App\Tools\Helpers::isMobile())

        @include('mobile.includes.topbar', [
           'class'       => '_fixed',
           'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>Новости</a>',
           'search_show' => false,
           'menu_link'   => '',
           'menu_class'  => 'icon_menu'
        ])
        @include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

        <div class="container">
            @include('site.news.widget', ['news' => $news])
            {!! $news->links("pagination::default") !!}
        </div>

        @include('mobile.includes.footer')

    @else
        @include('site.includes.breadcrumb', ['breadcrumbs' => [
           [
               'title' => 'Главная',
               'link'  => env('APP_URL')
           ],

           [
               'title' => 'Новости',
               'link'  => ''
           ]
        ]])
        <div class="section">
            <div class="container">
                <h1>Новости</h1>
                <br/>
                @include('site.news.widget', ['news' => $news])
                <br/>
                {!! $news->links("pagination::default") !!}
            </div>
        </div>
    @endif

@endsection
