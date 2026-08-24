@include('head/head',[
    'title' => trans('tournaments.title').' | '.$tournament->title,
    'title_cont'  => $tournament->title,
    'description' => $tournament->description,
    'image' => $tournament->image
])
@include('header/header', [
    'active' => 4,
])
{{-----------------[ HEADER ]-----------------}}


<section id="about">
@include('news/single/news_single', [
    'news' => $tournament,
    'show_share' => false,
    'pagination_top' => true,
    'next_link' => $next_tournament ? route('single_tournaments', [$next_tournament->slug]) : false,
    'prev_link' => $prev_tournament ? route('single_tournaments', [$prev_tournament->slug]) : false,
])
</section>

<section id="rating">
    <div class="container"><h1>{{trans('tournaments.rating')}}</h1></div>
    @include('tournaments/ratings/tournaments_rating')
</section>

<section id="gallery">
    <div class="container"><h1>{{trans('tournaments.gallery')}}</h1></div>
    @include('gallery/archive/gallery_archive', [
        'PhotoGalleries' => $PhotoGalleries,
        'VideoGalleries' => [],
        'photo_only' => true,
    ])
</section>

<section id="schedule">
    <div class="container"><h1>{{trans('tournaments.games')}}</h1></div>
    @include('tournaments/schedule/schedule', [
        'tournament' => $tournament,
        'rating_data' => $schedule_data,
    ])
</section>

<section id="video">
    <div class="container"><h1>{{trans('tournaments.live')}}</h1></div>
    @include('live/live', ['live' => $tournament])
    @include('gallery/archive/gallery_archive', [
        'PhotoGalleries' => [],
        'VideoGalleries' => $VideoGalleries,
        'video_only' => true,
    ])
</section>


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
