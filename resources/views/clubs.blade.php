@include('head/head',[
    'title' => trans('clubs.title'),
])
@include('header/header', [
    'active' => 1,
])
{{-----------------[ HEADER ]-----------------}}


@include('breadcrumb/breadcrumb', [
    'links' => [
        trans('main.home') => route('home'),
        trans('clubs.title') => '',
    ]
])

@include('title/title', [
    'title' => trans('clubs.title'),
    'class' => ['p-b-20'],
])

@include('clubs/archive/clubs_archive', [
    'clubs' => $clubs,
    'countries' => $countries,
])


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')

