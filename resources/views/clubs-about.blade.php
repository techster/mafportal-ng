@include('head/head',[
    'title' => trans('clubs.title') . ' | ' . trans('clubs.about'),
    'image' => $club->image,
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
    'color' => (!$club->image?'#000':'#fff'),
    'links' => [
        trans('main.home') => route('home'),
        trans('clubs.title') => route('clubs'),
        $club->title => route('single_clubs', [$club->slug]),
        trans('clubs.about') => ''
    ]
])

@if(!Request::get('error'))
    @if($club->image)
        @include('carusel/carusel_section', [
            'slides' => [$club],
            'btn_down' => true,
            'btn' => true,
            'btn_text' => 'true',
        ])
    @else
        <div style="height: 83px;"></div>
    @endif

    @include('clubs/about_club/about_club', ['club' => $club])
@else
    @include('no_access/no_access', ['text' => Request::get('error')])
@endif


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
