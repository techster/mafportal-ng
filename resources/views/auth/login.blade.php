@include('head/head',[
    'title' => trans('auth.login'),
])
@include('header/header')

@include('title/title', [
        'title' => trans('auth.login')
    ])

@include('registration/login')

@include('footer/footer')
@include('foot/foot')
