@include('head/head', [
    'title' => "Cart",
])
@include('header/header')
{{--_________________________________________--}}

@include('breadcrumb/breadcrumb', [
    'links' => [
        trans('main.home')  => route('home'),
        "Cart" => "",
    ]
])

@include('title/title', [
    'title' => "Payment canceled!",
    'class' => ['p-t-110', 'p-b-70'],
])

{{--_________________________________________--}}
@include('footer/footer')
@include('foot/foot')
