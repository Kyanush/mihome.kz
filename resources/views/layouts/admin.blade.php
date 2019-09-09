<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" href="{{ config('shop.favicon') }}" />
    <title></title>

    @yield('before_styles')

    <!--
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    -->
    <meta content="" name="viewport">

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/pnotify/pnotify.custom.min.css') }}">

    <!-- BackPack Base CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/backpack/backpack.base.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/overlays/backpack.bold.css') }}">

    @yield('after_styles')

    <!-- jQuery 2.2.3 -->
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=2">



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/darkness/jquery-ui.css" />
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>

    <!--
    <link rel="stylesheet" href="{{ asset('vendor/backpack/nestedSortable/nestedSortable.css') }}">
    <script src="{{ asset('vendor/backpack/nestedSortable/jquery.mjs.nestedSortable2.js') }}" type="text/javascript"></script>
-->

    <script src="https://cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>




<!--
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.print.css">
-->


</head>
<body class="skin-blue sidebar-mini">

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>


<script>
    function highchartsMonthlyAmount(categories, series, element_id, title_text, yAxis_title_text){


        Highcharts.chart(element_id, {
            chart: {
                type: 'line'
            },
            title: {
                text: title_text
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                    text: yAxis_title_text
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: series
        });
    }
</script>
<script type="text/javascript">
    /* Recover sidebar state */
    (function () {
        if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
            var body = document.getElementsByTagName('body')[0];
            body.className = body.className + ' sidebar-collapse';
        }
    })();
</script>
<!-- Site wrapper -->
<div class="wrapper">
    @yield('content')
</div>
<!-- ./wrapper -->


@yield('before_scripts')
<!-- JavaScripts -->
<script src="{{ mix('js/app.js') }}?r={{ rand() }}"></script>

<script>window.jQuery || document.write('<script src="{{ asset('vendor/adminlte') }}/plugins/jQuery/jQuery-2.2.3.min.js"><\/script>')</script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset('vendor/adminlte') }}/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ asset('vendor/adminlte') }}/plugins/pace/pace.min.js"></script>
<script src="{{ asset('vendor/adminlte') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="{{ asset('vendor/adminlte') }}/plugins/fastclick/fastclick.js"></script>
<script src="{{ asset('vendor/adminlte') }}/dist/js/app.min.js"></script>

<!-- page script -->
<script type="text/javascript">

    /* Store sidebar state */
    $('.sidebar-toggle').click(function(event) {
        event.preventDefault();
        if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
            sessionStorage.setItem('sidebar-toggle-collapsed', '');
        } else {
            sessionStorage.setItem('sidebar-toggle-collapsed', '1');
        }
    });
    // To make Pace works on Ajax calls
    $(document).ajaxStart(function() { Pace.restart(); });

    // Ajax calls should always have the CSRF token attached to them, otherwise they won't work
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Set active state on menu element
    var current_url = "{{ Request::fullUrl() }}";
    var full_url = current_url+location.search;
    var $navLinks = $("ul.sidebar-menu li a");
    // First look for an exact match including the search string
    var $curentPageLink = $navLinks.filter(
        function() { return $(this).attr('href') === full_url; }
    );
    // If not found, look for the link that starts with the url
    if(!$curentPageLink.length > 0){
        $curentPageLink = $navLinks.filter(
            function() { return $(this).attr('href').startsWith(current_url) || current_url.startsWith($(this).attr('href')); }
        );
    }

    $curentPageLink.parents('li').addClass('active');
            {{-- Enable deep link to tab --}}
    var activeTab = $('[href="' + location.hash.replace("#", "#tab_") + '"]');
    location.hash && activeTab && activeTab.tab('show');
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        location.hash = e.target.hash.replace("#tab_", "#");
    });
</script>

<!--include('backpack::inc.alerts')-->

@yield('after_scripts')


<link rel="stylesheet" href="{{ asset('includes/bootstrap-select-1.12.4') }}/bootstrap-select.css"/>
<script src="{{ asset('includes/bootstrap-select-1.12.4') }}/bootstrap-select.js" type="text/javascript"></script>

<!-- Mask --->
<script type="text/javascript" src="/site/js/jquery.maskedinput.min.js"></script>
<!-- Mask --->

<a id="back-site" title="Переходит на сайт" href="/" class="btn btn-primary">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSOAjYknCEUVppGNp8dwMY17QBFpytdJUkDyo1IF6346tKFrWU9">
</a>


</body>
</html>
