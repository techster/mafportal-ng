<section class="Account" ng-controller="AccountCtrl">
    <div class="container">
        <div class="line m-b-30"></div>
        <div class="row">
            <div class="col-md-3 col-sm-5 col-xs-12">
                <nav class="menu">
                    <ul>
                        {{--<li><a href="#">Account Dashboard</a></li>--}}
                        <li class="{{Route::currentRouteName()=='account'?'act':''}}"><a href="{{route('account')}}">{{trans('account.account_information')}}</a></li>
                        <li class="{{Route::currentRouteName()=='account_clubs'?'act':''}}"><a href="{{route('account_clubs')}}">{{trans('account.my_clubs')}}</a></li>
                        <li class="{{Route::currentRouteName()=='account_balance'?'act':''}}"><a href="{{route('account_balance')}}">{{trans('account.balance')}}</a></li>
                        <li class="{{Route::currentRouteName()=='games'?'act':''}}"><a href="{{route('games')}}">{{trans('account.games')}}</a></li>
                        {{--<li><a href="#">Address Book</a></li>--}}
                        {{--<li><a href="#">{{trans('account.orders')}}</a></li>--}}
                        {{--<li><a href="#">{{trans('account.billing_agreements')}}</a></li>--}}
                        {{--<li><a href="#">Recurring Profiles</a></li>--}}
                        {{--<li><a href="#">My Product Reviews</a></li>--}}
                        {{--<li><a href="#">My Tags</a></li>--}}
                        {{--<li><a href="#">My Downloadable Products</a></li>--}}
                        {{--<li><a href="#">Newsletter Subscriptions</a></li>--}}
                        <li>
                            <a href="{{ url( (App::getLocale() == "ru" ? "/ru" : "/en").'/logout' ) }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{trans('account.exit')}}
                            </a>
                            <form id="logout-form" action="{{ url( (App::getLocale() == "ru" ? "/ru" : "/en").'/logout' ) }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-9 col-sm-7 col-xs-12">
                <div class="content">
                    <div class="desc">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
