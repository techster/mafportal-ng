@include('head/head',[
    'title' => trans('tournaments.title').' | '.trans('tournaments.live'),
    'title_cont'  => $tournament->title,
    'live' => $tournament->live,
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
        trans('tournaments.live') => '',
    ]
])

@include('live/live', [
    'live' => $tournament,

])

{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
