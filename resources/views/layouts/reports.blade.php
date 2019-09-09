<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title>{{ $title }}</title>
    @if($format == 'pdf')
        <style>
            table {
                border-left: 0.01em solid #000;
                border-right: 0;
                border-top: 0.01em solid #000;
                border-bottom: 0;
                border-collapse: collapse;
                width: 100%;
            }
            table td,
            table th {
                border-left: 0;
                border-right: 0.01em solid #000;
                border-top: 0;
                border-bottom: 0.01em solid #000;
            }
        </style>
    @endif
</head>
<body>

    @if($date_start or $date_end)
        <div>
            <img src="{{ config('shop.logo') }}" height="40" style="float: left;"/>
            <div style="text-align: right;">
                Напечатано {{ date('d.m.Y H:m:s') }}
            </div>
        </div>
        <div style="text-align: right;">
                За период с
                {{ $date_start ? date('d.m.Y H:m:s', strtotime($date_start)) : '' }}
                по
                {{ $date_end ? date('d.m.Y H:m:s', strtotime($date_end)) : ''}}
        </div>
        <br/>
    @endif

    @yield('content')
</body>