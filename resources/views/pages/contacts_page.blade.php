@include('head/head', [
    'title' => App::getLocale()=='en'||!$page->title_rus?$page->title:$page->title_rus,
])
@include('header/header')

@include('breadcrumb/breadcrumb', [
        'links' => [
            trans('main.home')  => route('home'),
            App::getLocale()=='en'||!$page->title_rus?$page->title:$page->title_rus => "",
        ]
    ])

@include('title/title', [
        'title' => App::getLocale()=='en'||!$page->title_rus?$page->title:$page->title_rus,
        'class' => ['p-b-30', 'p-t-110'],
    ])

@include('contact/single/contact_single', [
        'page' => $page,
    ])

@include('footer/footer')
@include('foot/foot')
