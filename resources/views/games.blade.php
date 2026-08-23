@include('head/head', [
    'title' => trans('account.balance'),
])
@include('header/header')
{{-----------------[ HEADER ]-----------------}}


@include('breadcrumb/breadcrumb', [
    'links' => [
        trans('main.home')       => route('home'),
        trans('account.games') => '',
    ]
])

@include('title/title', [
    'title' => trans('account.games'),
    'class' => ['p-b-70','p-t-110'],
])

@include('games.game', [])


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
