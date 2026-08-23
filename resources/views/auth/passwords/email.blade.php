@include('head/head',[
    'title' => trans('auth.forgot'),
])
@include('header/header')

@include('title/title', [
        'title' => trans('auth.forgot')
    ])

@include('registration/forgot')

@include('footer/footer')
@include('foot/foot')
