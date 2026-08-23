@include('head/head',[
    'title' => trans('clubs.title') . ' | ' . trans('clubs.rating')
])
@include('header/header', [
    'active' => 1,
])
{{-- [ HEADER ] --}}

@include('breadcrumb/breadcrumb', [
    'color' => (!$global->image?'#000':'#fff'),
    'links' => [
        trans('main.home') => route('home'),
        trans('clubs.title')  => route('clubs'),
        trans('clubs.rating') => '',
    ]
])
<section class="Carusel " >
    <div uib-carousel active="active" >

        <div >

            <div class="item_pic" style="background-image: url({{ $global->image ? '../../../../uploads/'.$global->image : URL::to('/build/img/not_img.jpg') }});"></div>
            <div class="titleWr ng-scope cap0" ng-class="cap0">
                <h1 class="title text-center">
                    {{ App::getLocale() == 'en' ? $global->rating_title : $global->rating_title_ru }}
                </h1>
            </div>
        </div>
    </div>
</section>

<section class="AboutClub">
    <div class="container">
        <div class="line m-b-30"></div>
        <h1 class="title m-b-30">{{ App::getLocale() == 'en' ? $global->sub_heading : $global->sub_heading_ru }}</h1>
        <div class="cont">
            {!! App::getLocale() == 'en' ? $global->description : $global->description_ru !!}
        </div>
    </div>
</section>
@if(!Request::get('error'))
    @include('clubs/clubs_rating/global_club_rating', ['global' => $global])
@else
    @include('no_access/no_access', ['text' => Request::get('error')])
@endif

{{-- [ FOOTER ] --}}

@include('footer/footer')

@include('foot/foot')


