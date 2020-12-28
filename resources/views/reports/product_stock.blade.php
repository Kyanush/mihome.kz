    <table border="1" width="100%">
        <thead>
            <tr>
                <td style="background-color: #A4D1F1;text-align: center;" width="5"><b>№</b></td>
                <td style="background-color: #A4D1F1;text-align: center;" width="32"><b>Название</b></td>
                <td style="background-color: #A4D1F1;text-align: center;" width="12"><b>Поступление</b></td>
                <td style="background-color: #A4D1F1;text-align: center;" width="9"><b>Продажа</b></td>
                <td style="background-color: #A4D1F1;text-align: center;" width="8"><b>Остаток</b></td>
                <td style="background-color: #A4D1F1;text-align: center;" width="10"><b>Цена</b></td>
                <td style="background-color: #A4D1F1;text-align: center;" width="25"><b>Себестоимость</b></td>
            </tr>
        </thead>
        <tbody>
            @php $stock = $sold = $balance = 0  @endphp
            @foreach ($data as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->balance['stock'] }}</td>
                    <td>{{ $item->balance['sold'] }}</td>
                    <td>{{ $item->balance['balance'] }}</td>
                    <td>{{ $item->format_price }}</td>
                    <td>
                        @foreach($item->stock as $stock_item)
                           {{ $stock_item->quantity }} - {{ $stock_item->price }}
                        @endforeach
                    </td>
                </tr>
                @php
                    $stock   += $item->balance['stock'];
                    $sold    += $item->balance['sold'];
                    $balance += $item->balance['balance'];
                @endphp
            @endforeach
        </tbody>
        <tbody>
            <tr>
                <td></td>
                <td>Итого</td>
                <td style="background-color: #A4D1F1;">{{ $stock }}</td>
                <td style="background-color: #A4D1F1;">{{ $sold }}</td>
                <td style="background-color: #A4D1F1;">{{ $balance }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>