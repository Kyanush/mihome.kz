<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CloneProductRequest extends FormRequest
{

    public function rules()
    {
        return [
            'clone_product.product_id' => 'exists:products,id',
            'clone_product.name'       => "max:255|required|unique:products,name",
            'clone_product.sku'        => "max:100|required|unique:products,sku"
        ];
    }

    public function attributes()
    {
        return [
            'clone_product.product_id' => "'Товар ID'",
            'clone_product.name'       => "'Название'",
            'clone_product.sku'        => "'SKU'"
        ];
    }

}