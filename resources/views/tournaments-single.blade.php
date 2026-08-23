@include('head/head',[
    'title' => trans('tournaments.title').' | '.trans('tournaments.about'),
    'title_cont'  => $tournament->title,
    'description' => $tournament->description,
    'image' => $tournament->image
])
@include('header/header', [
    'active' => 4,
])
{{-----------------[ HEADER ]-----------------}}


@include('clubs/clubs_nav/clubs_nav', [
    'links' => [
        trans('tournaments.about') => route('tournaments_about', [$tournament->slug]),
        trans('tournaments.rating') => route('tournaments_rating', [$tournament->slug]),
        trans('tournaments.gallery') => route('tournaments_gallery', [$tournament->slug]),
        trans('tournaments.games')   => route('tournaments_schedule', [$tournament->slug]),
        trans('tournaments.live')   => route('tournaments_live', [$tournament->slug]),
    ]
])

@include('breadcrumb/breadcrumb', [
    'links' => [
        trans('main.home') => route('home'),
        trans('tournaments.title') => route('tournaments'),
        $tournament->title => route('single_tournaments', [$tournament->slug]),
        trans('tournaments.about') => '',
    ]
])

@include('news/single/news_single', [
    'news' => $tournament,
    'next_link' => $next_tournament ? route('single_tournaments', [$next_tournament->slug]) : false,
    'prev_link' => $prev_tournament ? route('single_tournaments', [$prev_tournament->slug]) : false,
])


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
