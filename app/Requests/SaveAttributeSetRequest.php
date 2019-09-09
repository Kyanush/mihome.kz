<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveAttributeSetRequest extends FormRequest
{

    public function rules()
    {
        $data = $this->request->all();
        $data = $data['attribute_set'];

        return [
            'attribute_set.id' => (!empty($data['id']) ? 'exists:attribute_sets,id' : 'nullable'),
            'attribute_set.name' => 'required|max:255',
            'attribute_set.attributes' => 'required',
            'attribute_set.attributes.*' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'attribute_set.id' => "'id'",
            'attribute_set.name' => "'Название'",
            'attribute_set.attributes' => "'Атрибуты'",
            'attribute_set.attributes.*' => "'Атрибуты'"
        ];
    }

}