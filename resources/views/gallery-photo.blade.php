@include('head/head',[
    'title' => trans('gallery.title').' | ' . $PhotoGallery->title,
    'title_cont'  => $PhotoGallery->title,
])
@include('header/header', [
    'active' => 7,
])
{{-- [ HEADER ] --}}


<?php
    $array = [
        trans('main.home') => route('home'),
        trans('gallery.title') => route('gallery'),
    ];
    $array[$PhotoGallery->title] = '';
?>

@include('breadcrumb/breadcrumb', [
    'links' => $array
])

@include('gallery/single/single_photo', [
    'PhotoGallery' => $PhotoGallery,
])

{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
