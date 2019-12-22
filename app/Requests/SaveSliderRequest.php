<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveSliderRequest extends FormRequest
{
    public function rules()
    {
        $slider_id = $this->input('slider.id');

        return [
            'slider.id'    => ($slider_id ? 'exists:sliders,id' : 'nullable'),
            'slider.name'  => 'required|max:255',
            'slider.link'  => 'max:255',
            'slider.image' => $this->file('slider.image')  ? 'max:10000' : 'nullable',
            'slider.sort'  => 'required|integer',
            'slider.show_where'  => 'required|max:20',
        ];
    }

    public function attributes()
    {
        return [
            'slider.id'    => "'Слайдер ID'",
            'slider.name'  => "'Название'",
            'slider.link'  => "'Ссылка'",
            'slider.image' => "'Файл'",
            'slider.sort'  => "'Сортировка'",
            'slider.show_where'  => "'Где отображать'",
        ];
    }
}