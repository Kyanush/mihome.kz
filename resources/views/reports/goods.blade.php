    <table border="1" width="100%">
        <thead>
            <tr>
                <td colspan="7">
                    {{ $title }} | напечатано {{ date('d.m.Y H:m:s') }} |
                    За период: {{ $date_start }} - {{ $date_end }}
                </td>
            </tr>
            <tr>
                <td style="background-color: #A4D1F1;text-align: center;" width="5"><b>№</b></td>
                <td style="background-color: #A4D1F1;text-align: center;" width="12"><b>ID товара</b></td>
                <td style="background-color: #A4D1F1;text-align: center;" width="87"><b>Фото</b></td>
                <td style="background-color: #A4D1F1;text-align: center;" width="87"><b>Товар</b></td>
                <td style="background-color: #A4D1F1;text-align: center;" width="12"><b>Количество</b></td>
                <td style="background-color: #A4D1F1;text-align: center;" width="12"><b>Сумма</b></td>
                <td style="background-color: #A4D1F1;text-align: center;" width="12"><b>Прибыль</b></td>
            </tr>
        </thead>
        <tbody>
            @php
                $number = 1;
                $quantity = $sum = $profit = 0;
            @endphp
            @foreach ($data as $key => $item)
                <tr>
                    <td style="text-align: center;">{{ $number++ }}</td>
                    <td style="text-align: center;">{{ $item['product']->id }}</td>
                    <td style="padding-left: 10px;">
                        @php
                            $path = ($format == 'excel' ? public_path() : env('APP_URL')) . $item['product']->pathPhoto(true);
                        @endphp
                        @if(file_exists($path))
                            <img width="100" src="{{ $path }}">
                        @endif
                    </td>
                    <td style="padding-left: 10px;">{{ $item['product']->name }}</td>
                    <td style="text-align: center;">{{ $item['quantity'] }}</td>
                    <td style="text-align: center;">{{ \App\Tools\Helpers::priceFormat($item['sum'], false) }}</td>
                    <td style="text-align: center;">{{ \App\Tools\Helpers::priceFormat($item['profit'], false) }}</td>
                </tr>
                @php
                    $quantity += $item['quantity'];
                    $sum      += $item['sum'];
                    $profit   += $item['profit'];
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td style="background-color: #A4D1F1;text-align: center;"><b>Итого</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b></b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b></b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b></b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>{{ $quantity }}</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>{{ \App\Tools\Helpers::priceFormat($sum, false) }}</b></td>
                <td style="background-color: #A4D1F1;text-align: center;"><b>{{ \App\Tools\Helpers::priceFormat($profit, false) }}</b></td>
            </tr>
            <tr>
                <td colspan="7">
                    Прибыль %: {{ 100 / $sum * $profit   }}
                </td>
            </tr>
        </tfoot>
    </table>