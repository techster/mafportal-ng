@include('head/head',[
    'title' => 'Shop',
])
@include('header/header')
{{-----------------[ HEADER ]-----------------}}


@include('breadcrumb/breadcrumb', [
        'links' => [
            trans('main.home') => route('home'),
            trans('main.shop') => '',
        ]
    ])

@include('title/title', [
        'title' => trans('main.shop'),
        'class' => ['p-b-70','p-t-110'],
    ])

@include('shop/archive/shop_archive')

@include('pagination/pagination')


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
