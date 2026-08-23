@include('head/head',[
    'title'       => trans('clubs.events').' | '.$current_event->title,
    'title_cont'  => $current_event->title,
    'description' => $current_event->description,
    'image'       => $current_event->image
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
    'class' => [],
    'links' => [
        trans('main.home')  => route('home'),
        trans('clubs.title') => route('clubs'),
        $club->title => route('single_clubs', [$club->slug]),
        trans('clubs.events') => route('club_events', [$club->slug]),
        $current_event->title => "",
    ]
])

@include('news/single/news_single', [
    'news' => $current_event,
    'next_link' => $next_event ? route('club_single_events', [$club->slug, $next_event->slug]) : false,
    'prev_link' => $prev_event ? route('club_single_events', [$club->slug, $prev_event->slug]) : false,
])


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
