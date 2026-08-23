@include('head/head', [
    'title' => trans('news.title').' | ' . $news->title,
    'title_cont'  => $news->title,
    'description' => $news->description,
    'image' => $news->image
])
@include('header/header', [
    'active' => 3,
])
{{-----------------[ HEADER ]-----------------}}


<?php
    $array = [
        trans('main.home') => route('home'),
        trans('news.title') => route('news'),
    ];
    $array[$news->title] = '';
?>

@include('breadcrumb/breadcrumb', [
    'links' => $array
])

@include('news/single/news_single', [
    'news'      => $news,
    'next_link' => $next_news ? route('single_news', [$next_news->slug]) : false,
    'prev_link' => $prev_news ? route('single_news', [$prev_news->slug]) : false,
])


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
