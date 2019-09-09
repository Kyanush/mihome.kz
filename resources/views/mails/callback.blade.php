@extends('layouts.mail')
@section('content')

    <p>Тип: {{ $data->type }}</p>
    <p>Телефон: {{ $data->phone }}</p>
    <p>E-mail: {{ $data->email }}</p>
    <p>Сообщение: {{ $data->message }}</p>
    <p>Дата: {{ $data->created_at }}</p>

@endsection