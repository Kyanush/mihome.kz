<?php
namespace App\Requests;
use App\Models\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Request;

class SaveProductRequest extends FormRequest
{

    public function rules()
    {
        $product_id = $this->input('product.id');
        $parent_id  = $this->input('product.parent_id');

        $rules = [
            'product.id'          => (!empty($product_id) ? 'exists:products,id' : 'nullable'),
            'product.name'        => 'max:255|required|unique:products,name' . ($product_id ? (',' . $product_id . ',id') : ''),
            'product.url'         => 'max:255|nullable|unique:products,url'  . ($product_id ? (',' . $product_id . ',id') : ''),
            'product.price'       => 'numeric|required|min:0',
            'product.sku'         => 'max:100|unique:products,sku' . ($product_id ? (',' . $product_id . ',id') : ''),
            'product.stock'       => 'integer',
            'product.active'      => 'required|integer|min:0|max:1',
            'specific_price.reduction'       => 'nullable|numeric|min:0',
            'specific_price.discount_type'   => 'nullable|max:10',
            'product_images.*.value'         => ''
        ];

        if(!$parent_id)
        {
            $rules['product.youtube']          = 'max:25';
            $rules['product.description']      = 'required';
            $rules['categories']               = 'required|exists:categories,id';
            $rules['categories.*']             = 'required|exists:categories,id';
        }

        if ($this->input('specific_price.reduction') > 0)
        {
            if ($this->input('specific_price.start_date'))
                $rules['specific_price.start_date']      = 'nullable|date_format:"Y-m-d H:i:s"';

            if ($this->input('specific_price.expiration_date'))
                $rules['specific_price.expiration_date'] = 'nullable|date_format:"Y-m-d H:i:s"';
        }

        if($this->file("photo"))
            $rules['photo'] = 'required|image|mimes:jpeg,jpg,png|max:10000';

        return $rules;
    }

    public function attributes()
    {
        $rules = [
            'product.id'          => "'Название'",
            'product.name'        => "'Название'",
            'product.url'         => "'Ссылка'",
            'product.description' => "'Описание'",
            'product.price'       => "'Цена продажи'",
            'product.sku'         => "'SKU'",
            'product.stock'       => "'Количество на складе'",
            'product.active'      => "'Статус'",
            'product.youtube'     => "'YouTube'",
            'photo'               => "'Фото товара'",
            'categories'          => "'Категории'",
            'categories.*'        => "'Категории'",
            'specific_price.reduction'       => "'Снижение'",
            'specific_price.discount_type'   => "'Тип скидки'",
            'specific_price.start_date'      => "'Дата начала'",
            'specific_price.expiration_date' => "'Дата окончания срока'",
            'product_images.*.value'         => "'Картинки'",
        ];

        return $rules;
    }

}
