    <table border="1">
        <thead>
            <tr>
                <td>Наименование товара</td>
                <td>Цена</td>
                <td>Категория</td>
                <td>Ссылка на товар на сайте магазина</td>
                <td>Ссылка на картинку</td>
                <td>Описание</td>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->getReducedPrice() }}</td>
                    <td>{{ $product->category->name ?? ''}}</td>
                    <td>{{ $product->detailUrlProduct() }}</td>
                    <td>{{ env('APP_URL') . $product->pathPhoto(true) }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>