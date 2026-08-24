@include('head/head', [
    'title' => trans('tournaments.title')
])
@include('header/header', [
    'active' => 4,
])
{{-----------------[ HEADER ]-----------------}}


@include('breadcrumb/breadcrumb', [
    'links' => [
        trans('main.home') => route('home'),
        trans('tournaments.title') => '',
    ]
])

@include('tournaments/archive/tournaments_archive', [
    'tournament' => $tournaments,
])

{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
