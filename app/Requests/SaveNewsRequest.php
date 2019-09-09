<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveNewsRequest extends FormRequest
{
    public function rules()
    {
        $news_id = $this->input('news.id');

        return [
            'news.id'           => ($news_id ? 'exists:news,id' : 'nullable'),
            'news.title'        => 'required|max:255',
            'news.code'         => 'max:255',
            'news.created_at'   => 'required|date_format:"Y-m-d H:i:s"',
            'news.image'        => $this->file('news.image')  ? 'image|mimes:jpeg,jpg,png|max:5000' : 'nullable' . (!$news_id ? '|required' : ''),
            'news.preview_text' => 'required|max:500',
            'news.detail_text'  => 'required',
            'news.active'       => 'numeric:min:0|max:1',
        ];
    }

    public function attributes()
    {
        return [
            'news.id'           => 'id',
            'news.title'        => 'Название',
            'news.code'         => 'Ссылка',
            'news.created_at'   => 'Дата',
            'news.image'        => 'Картина',
            'news.preview_text' => 'Описание',
            'news.detail_text'  => 'Текст',
            'news.active'       => 'Статус',
        ];
    }
}