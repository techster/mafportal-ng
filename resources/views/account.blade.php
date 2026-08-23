@include('head/head', [
    'title' => trans('account.account'),
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
    'title' => trans('account.account'),
    'class' => ['p-b-70','p-t-110'],
])

@include('account_profile/account_profile')


{{-----------------[ FOOTER ]-----------------}}
@include('footer/footer')
@include('foot/foot')
