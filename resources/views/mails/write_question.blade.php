@extends('layouts.mail')
@section('content')

    <p>Имя:   {{ $data->name }}</p>
    <p>Email: {{ $data->email }}</p>
    <p>Вопрос: {{ $data->question }}</p>
    <p>Товар: <a href="{{ $data->product->detailUrlProduct() }}">{{ $data->product->name }}</a></p>
    <p>Изменить товар: <a href="{{ env('APP_URL') . $data->product->detailUrlProductAdmin() }}">{{ $data->product->name }}</a></p>
    <p>
        <a href="{{ env('APP_URL') }}/admin/questions-answers">
            Вопросы-ответы
        </a>
    </p>

@endsection