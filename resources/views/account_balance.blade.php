@include('head/head', [
    'title' => trans('account.balance'),
])
@include('header/header')
{{-----------------[ HEADER ]-----------------}}


@include('breadcrumb/breadcrumb', [
    'links' => [
        trans('main.home')       => route('home'),
        trans('account.account') => '',
    ]
])

@include('title/title', [
    'title' => trans('account.balance'),
    'class' => ['p-b-70','p-t-110'],
])

@include('account_balance/account_balance', [

])


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
