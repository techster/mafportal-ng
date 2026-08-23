@include('head/head')
@include('header/header')
{{-----------------[ HEADER ]-----------------}}

@include('carusel/carusel_section', [
    'slides' => $slides,
])

@include('event/section/event_section', [
    'page' => "home",
    'events' => $events,
    'class' => [
        'p-t-50',
        'm-b-50'
    ]
])

@include('title/title', [
    'title' => trans('main.last_news'),
    'class' => [
        'm-b-10',
        'p-t-10'
    ],
])

@include('news/news-list/news-list', [
    'class' => [
        'm-b-90'
    ],
    'news' => $news,
])

@include('review/section/review_section', [
    'testimonials' => $testimonials,
])

@include('about/section/about_section', [
    'about' => $about,
])

@include('partners/section/partners_section')


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
