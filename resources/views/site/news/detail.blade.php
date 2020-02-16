@extends(\App\Tools\Helpers::isMobile() ? 'layouts.mobile' : 'layouts.site')

@section('title',       $news->title )
@section('description', strip_tags($news->preview_text))
@section('keywords',    '')

@section('content')

    @if(\App\Tools\Helpers::isMobile())

        @include('mobile.includes.topbar', [
           'class'       => '_fixed',
           'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>' . $news->title . '</a>',
           'search_show' => false,
           'menu_link'   => '',
           'menu_class'  => 'icon_menu'
        ])
        @include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

        <div class="container" id="news-detail">
            {!! $news->detail_text !!}
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
               'link'  => route('news_list')
           ],
           [
               'title' => $news->title,
               'link'  => ''
           ]
       ]])

        <!-- SECTION -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <h1>
                    {{ $news->title }}
                </h1>
                <div id="news-detail">
                    <p><i class="fa fa-clock-o firm-red"></i> {{ \App\Tools\Helpers::ruDateFormat($news->created_at) }}</p>
                    {!! $news->detail_text !!}
                </div>
            </div>
        </div>
    @endif

@endsection
