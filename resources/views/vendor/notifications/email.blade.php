@extends('layouts.mail')
@section('content')

<p>Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.</p>

<a style="font-family: Avenir,Helvetica,sans-serif;
    box-sizing: border-box;
    border-radius: 3px;
    color: #fff;
    display: inline-block;
    text-decoration: none;
    background-color: #333333;
    border-top: 10px solid #333333;
    border-right: 18px solid #333333;
    border-bottom: 10px solid #333333;
    border-left: 18px solid #333333;" href="{{ $actionUrl }}">Сброс пароля</a>

<p style="margin-top: 15px;">Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.</p>

@endsection