@include('head/head', [
    'title' => "Cart",
])
@include('header/header')
{{--_________________________________________--}}

@include('breadcrumb/breadcrumb', [
    'links' => [
        trans('main.home')  => route('home'),
        trans('account.cart') => "",
    ]
])

@include('title/title', [
    'title' =>  trans('account.cart'),
    'class' => ['p-t-110', 'p-b-70'],
])

@include('cart/cart', [
    'cart' => $cart,
])


{{--_________________________________________--}}
@include('footer/footer')
@include('foot/foot')
