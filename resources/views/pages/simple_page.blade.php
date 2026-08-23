@include('head/head', [
    'title' => App::getLocale()=='en'||!$page->title_rus?$page->title:$page->title_rus,
])
@include('header/header')

@include('breadcrumb/breadcrumb', [
    'links' => [
        trans('main.home')  => route('home'),
        App::getLocale() == 'ru' && $page->title_rus ? $page->title_rus : $page->title => "",
    ]
])

@include('title/title', [
    'title' => App::getLocale() == 'ru' && $page->title_rus ? $page->title_rus : $page->title,
    'class' => ['p-t-110', 'p-b-70'],
])

@include('page/page', [
    'content' => App::getLocale() == 'ru' && $page->content_rus ? $page->content_rus : $page->content,
])

@include('footer/footer')
@include('foot/foot')
