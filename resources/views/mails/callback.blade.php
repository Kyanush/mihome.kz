@extends('layouts.mail')
@section('content')

    <p>Тип: {{ $data->type }}</p>
    <p>
        Телефон:
        <a href="tel:{{ $data->phone }}">
            {{ $data->phone }}
        </a>
    </p>
    <p>
        E-mail:
        <a href="{{ $data->email }}">
            {{ $data->email }}
        </a>
    </p>
    <p>Сообщение: {{ $data->message }}</p>
    <p>Дата: {{ $data->created_at }}</p>

@endsection
