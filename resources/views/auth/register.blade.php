@include('head/head',[
    'title' => trans('auth.registration'),
])
@include('header/header')

@include('title/title', [
        'title' => trans('auth.registration')
    ])

@include('registration/registration')

@include('footer/footer')
@include('foot/foot')
