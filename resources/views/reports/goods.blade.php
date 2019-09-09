@extends('layouts.reports')
@section('content')

    <table border="1">
        <thead>
            <tr>
                <td style="background-color: #A4D1F1;text-align: center;"><b>№</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>ID товара</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>Товар</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>Количество</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>Сумма</b></td>
            </tr>
        </thead>
        <tbody>
            @php
                $number = 1;
                $quantity = $sum = 0;
            @endphp
            @foreach ($data as $key => $item)
                <tr>
                    <td style="text-align: center;">{{ $number++ }}</td>
                    <td style="text-align: center;">{{ $item['product']->id }}</td>
                    <td style="padding-left: 10px;">{{ $item['product']->name }}</td>
                    <td style="text-align: center;">{{ $item['quantity'] }}</td>
                    <td style="text-align: center;">{{ \App\Tools\Helpers::priceFormat($item['sum'], false) }}</td>
                </tr>
                @php
                    $quantity += $item['quantity'];
                    $sum      += $item['sum'];
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td style="background-color: #A4D1F1;text-align: center;"><b>Итого</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b></b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b></b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>{{ $quantity }}</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>{{ \App\Tools\Helpers::priceFormat($sum, false) }}</b></td>
            </tr>
        </tfoot>
    </table>

@endsection