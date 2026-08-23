<section class="RegistrationPage">
    <div class="container">
        <div class="registrationWr">

            <div class="TabBox">
                <div class="tabWr">
                    <div class="tab-container">
                        <a class="act" href="">
                            <i class="fa fa-sign-in" aria-hidden="true"></i>{{trans('auth.login')}}
                        </a>
                    </div>

                    <div class="tab-container">
                        <a href="{{ (App::getLocale() == "ru" ? "/ru" : "/en") }}/register/">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>{{trans('auth.registration')}}
                        </a>
                    </div>

                    <div style="text-align:center;" class="tab-container">
                        <div onlogin="logInFb();" class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>
                    </div>

                    <div class="tab-container">
                        <a href="{{ (App::getLocale() == "ru" ? "/ru" : "/en") }}/password/reset/">
                            <i class="fa fa-retweet" aria-hidden="true"></i>{{trans('auth.forgot')}}
                        </a>
                    </div>
                </div>
            </div>

            <div class="FormWr" ng-controller="LoginCtrl">
                <div class="FormtBox">
                    <div class="title_form">{{trans('auth.login')}}</div>
                    <form name="LoginForm" ng-submit="LoginSubmitForm()" novalidate>

                        <div class="input-container" ng-class="{ 'has-error' : LoginForm.email.$invalid && LoginForm.email.$touched }">
                            <input type="email" name="email" ng-model="user.email" ng-required="true">
                            <label for="email">{{trans('auth.your_email')}}</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="LoginForm.email.$invalid && LoginForm.email.$touched" class="help-block">{{trans('auth.valid_email')}}</p>
                        </div>

                        <div class="input-container" ng-class="{ 'has-error' : LoginForm.password.$invalid && LoginForm.password.$touched }">
                            <input type="password" name="password" ng-model="user.password" ng-required="true" ng-minlength=6>
                            <label for="password">{{trans('auth.your_password')}}</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="LoginForm.password.$invalid && LoginForm.password.$touched" class="help-block">{{trans('auth.valid_password')}}</p>
                        </div>

                        <div class="button-container">

                            <div class="message_group">
                                @if ($errors->has('email'))
                                    <span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        {{trans('auth.failed')}}
                                    </span>
                                @endif
                                @if ($errors->has('password'))
                                    <span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        {{trans('auth.throttle')}}
                                    </span>
                                @endif
                                {{--<span class="wait"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Please wait ...</span>--}}
                                {{--<span class="green"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> You are logged in successfully</span>--}}
                                {{--<span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Email or password is not correct</span>--}}
                                {{--<span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Error. Try again</span>--}}
                            </div>

                            <div class="loginBtn">
                                <button type="submit" ng-cloak ng-disabled="LoginForm.$invalid">{{trans('auth.send')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

