<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('id', 'desc')->paginate(10);
        return view('news', ['news' => $news]);
    }

    public function show($slug)
    {
        $current_news = News::where('slug', $slug)->first();
        if(!$current_news) abort(404);
        $next_news  = News::orderBy("created_at", 'asc')->where('created_at', '>', $current_news->created_at)->first();
        $prev_news  = News::orderBy("created_at", 'desc')->where('created_at', '<', $current_news->created_at)->first();
        $metas_data = json_decode($current_news->metas);

        return view('news-single', [
            'news' => $current_news,
            'next_news' => $next_news,
            'prev_news' => $prev_news,

            'meta_title' =>              isset($metas_data)?(App::getLocale() == 'ru'?$metas_data->meta_title_ru:$metas_data->meta_title_en):NULL,
            'meta_description' =>        isset($metas_data)?(App::getLocale() == 'ru'?$metas_data->meta_description_ru:$metas_data->meta_description_en):NULL,
            'meta_keywords' =>           isset($metas_data)?(App::getLocale() == 'ru'?$metas_data->meta_keywords_ru:$metas_data->meta_keywords_en):NULL,
            'social_meta_title' =>       isset($metas_data)?(App::getLocale() == 'ru'?$metas_data->social_meta_title_ru:$metas_data->social_meta_title_en):NULL,
            'social_meta_description' => isset($metas_data)?(App::getLocale() == 'ru'?$metas_data->social_meta_description_ru:$metas_data->social_meta_description_en):NULL,
        ]);
    }
}
