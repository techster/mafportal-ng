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
                    <div class="col-md-8">
                        <nav class="headMenu">
                            @include('header/main-menu/main-menu')
                        </nav>
                    </div>

                    <!--[ LOGIN ]-->

                    <div class="col-md-2">
                        <!--[ LANG BAR ]-->
                        <div class="col-md-5 lang_bar">
                            @if(App::getLocale() == 'en')
                                <a style="margin-left: 5px; float: right;" href="{{ str_replace("/en/", "/", "/ru/" . Request::path() . "/") }}"><img class="flagImg" src="{{asset('build/img/ru_flag.svg')}}" alt="ru"></a>
                                <a style="float: right;" href=""><img class="flagImg" src="{{ asset('build/img/en_flag.svg')}}" alt="en"></a>
                            @else
                                <a style="margin-left: 5px; float: right;" href=""><img class="flagImg" src="{{asset('build/img/ru_flag.svg')}}" alt="ru"></a>
                                <a style="float: right;" href="{{ str_replace("/ru/", "/", "/en/" . Request::path() . "/") }}"><img class="flagImg" src="{{asset('build/img/en_flag.svg')}}" alt="en"></a>
                            @endif
                        </div>

                        <div class="langWr col-md-7" style=" padding-right: 0;padding-left: 0;">

                            <!--[ MODAL ]-->
                            @if (Auth::guest())
                                <input type="hidden" id="locale" value="{{ Request::fullUrl() }}">

                                <div class="sign_style" ng-click="OpenModal('{{ (App::getLocale() == "ru" ? "/ru" : "/en") }}/modal')">
                                    <p STYLE="font-size: 14px;">{{ trans('auth.sign_in') }}</p>
                                </div>
                            @else
                                <div id="myBtn" class="loginBox dropdown dropbtn checkdiv">
                                    @if(Auth::user()->avatar == null)
                                        <img class="checkdiv"  src="{{URL::to('/build/img/Group.svg')}}" alt="account">
                                    @else
                                        <img style="border-radius: 100%" class="checkdiv avatar_user"  src="{{URL::to(Auth::user()->avatar)}}" alt="account">
                                    @endif
                                    <div id="myDropdown" class="dropdown-content">
                                        <a href="{{ route('account') }}">{{trans('account.account')}}</a>
                                        <a href="{{ route('account_clubs') }}">{{trans('account.my_clubs')}}</a>
                                        <a href="{{ route('account_balance') }}">{{trans('account.balance')}}</a>
                                        <a href="{{route('games')}}">{{trans('account.games')}}</a>
                                        <a href="{{ route('cart') }}">{{trans('account.cart')}}</a>
                                        <a href="{{ url( (App::getLocale() == "ru" ? "/ru" : "/en").'/logout' ) }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                            {{trans('account.exit')}}
                                        </a>
                                        <form id="logout-form" action="{{ url( (App::getLocale() == "ru" ? "/ru" : "/en").'/logout' ) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </div>
                                <script>

                                    $( document ).ready(function() {
                                        $('#myBtn').click(function(){
                                            $('#myDropdown').addClass( "show" )
                                        })


                                        $('html').click(function(e) {
                                            if( !$(e.target).hasClass('checkdiv') )
                                            {
                                                $('#myDropdown').removeClass( "show" )

                                            }
                                        });
                                    });


                                </script>


                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </header>



        {{--Прибить подвал--}}
    {{--</div>--}}
{{--</div>--}}



