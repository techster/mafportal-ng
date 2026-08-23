@include('head/head',[
    'title' => trans('clubs.title') . ' | ' . trans('clubs.rating'),
])
@include('header/header', [
    'active' => 1,
])
{{-----------------[ HEADER ]-----------------}}

@include('breadcrumb/breadcrumb', [
    'links' => [
        trans('main.home') => route('home'),
        trans('clubs.rating') => '',
    ]
])

{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
