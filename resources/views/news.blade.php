@include('head/head', [
    'title' => trans('news.title'),
 ])
@include('header/header', [
    'active' => 3,
])
{{-----------------[ HEADER ]-----------------}}


@include('breadcrumb/breadcrumb', [
    'links'    => [
        trans('main.home') => route('home'),
        trans('news.title') => '',
    ]
])

@include('title/title', [
    'title' => trans('news.title'),
 ])

@include('news/news-list/news-list', [
    'news' => $news,
])

{{ $news->links('pagination/pagination') }}


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
