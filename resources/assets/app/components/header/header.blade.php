@include('header/mob-menu/mob-menu')

<div class="wrapper">
    <div class="content">
        <!--[ HEADER ]-->
        <div class="help_fixHeader"></div>
        <header ng-controller="HeaderCtrl">
            <div class="container">
                <div class="row">
                    <!--[ LOGO ]-->
                    <div class="col-md-2">
                        @include('header/logo/logo')
                    </div>
                    <!--[ MENU ]-->
                    <div class="col-md-9">
                        <nav class="headMenu">
                            @include('header/main-menu/main-menu')
                        </nav>
                    </div>

                    <div class="col-md-1 language-column">
                        <!--[ LANG BAR ]-->
                        <div class="col-md-5 lang_bar">
                            @if(App::getLocale() == 'en')
                                <a href="{{ str_replace("/en/", "/", "/ru/" . Request::path() . "/") }}"><span class="language-letter">RU</span></a>
                            @else
                                <a href="{{ str_replace("/ru/", "/", "/en/" . Request::path() . "/") }}"><span class="language-letter">EN</span></a>
                            @endif
                        </div>

                        <div class="langWr col-md-7" style=" padding-right: 0;padding-left: 0;">
                        </div>
                    </div>
                </div>
            </div>
        </header>



        {{--Прибить подвал--}}
    {{--</div>--}}
{{--</div>--}}



