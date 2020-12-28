@extends('layouts.reports')
@section('content')

    <table border="1">
        <thead>
            <tr>
                <td style="background-color: #A4D1F1;text-align: center;"><b>№</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>Товар</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>Поступление</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>Продажа</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>Остаток</b></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $key => $product)
                @php
                    $balance = $product->balance();
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $key + 1 }}</td>
                    <td style="text-align: center;">{{ $product->name }}</td>
                    <td style="text-align: center;">{{ $balance['stock'] }}</td>
                    <td style="text-align: center;">{{ $balance['sold'] }}</td>
                    <td style="text-align: center;">{{ $balance['balance'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection