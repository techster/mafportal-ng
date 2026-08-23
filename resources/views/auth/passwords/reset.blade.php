@include('head/head',[
    'title' => trans('auth.reset'),
])
@include('header/header')

@include('title/title', [
    'title' => trans('auth.reset')
])

@include('registration/reset')

@include('footer/footer')
@include('foot/foot')
