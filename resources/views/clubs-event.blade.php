@include('head/head',[
    'title' => trans('clubs.title') . ' | ' . trans('clubs.events'),
])
@include('header/header', [
    'active' => 1,
])
{{-----------------[ HEADER ]-----------------}}


@include('clubs/clubs_nav/clubs_nav', [
    'club' => $club,
    'links' => [
        trans('clubs.about')   => route('club_about', [$club->slug]),
        trans('clubs.events')  => route('club_events', [$club->slug]),
        trans('clubs.rating')  => route('club_rating', [$club->slug]),
        trans('clubs.gallery') => route('club_gallery', [$club->slug]),
    ]
])

@include('breadcrumb/breadcrumb', [
    'class' => ['p-b-100'],
    'links' => [
        trans('main.home') => route('home'),
        trans('clubs.title') => route('clubs'),
        $club->title => route('single_clubs', [$club->slug]),
        trans('clubs.events') => "",
    ]
])

@if(!Request::get('error'))
        @include('event/section/event_section', [
        'events' => $events,
        'class' => ['p-t-50', 'm-b-100'],
    ])
@else
    @include('no_access/no_access', ['text' => Request::get('error')])
@endif

{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
