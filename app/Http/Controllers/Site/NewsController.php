<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{

    public function newsDetail($code)
    {
        $news = News::isActive()->where('code', $code)->firstOrFail();
        return view('site.news.detail', ['news' => $news]);
    }

    public function newsList(){
        $news = News::isActive()->OrderBy('created_at', 'DESC')->paginate(5);
        return view('site.news.list', ['news' => $news]);
    }

}