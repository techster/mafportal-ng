<section class="AboutClub">
    <div class="container">
        <div class="line m-b-30"></div>
        <h1 class="title m-b-30">{{trans('clubs.about_the_club')}}</h1>
        @if($club->text)
            <div class="cont">
                {!! $club->text !!}
            </div>
        @endif
    </div>
</section>