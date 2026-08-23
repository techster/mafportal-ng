@include('head/head',[
    'title' => trans('gallery.title'),
])
@include('header/header', [
    'active' => 7,
])
{{-----------------[ HEADER ]-----------------}}


@include('breadcrumb/breadcrumb', [
    'links' => [
        trans('main.home') => route('home'),
        trans('gallery.title') => '',
    ]
])

@include('title/title', [
    'title' => trans('gallery.title')
])

@include('gallery/archive/gallery_archive', [
    'PhotoGalleries' => $PhotoGalleries,
    'VideoGalleries' => $VideoGalleries,
])


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
