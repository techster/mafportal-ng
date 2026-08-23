<section class="RegistrationPage">
    <div class="container">

        <div class="registrationWr">
            <div class="TabBox">
                <div class="tabWr">
                    <div class="tab-container">
                        <a href="{{ (App::getLocale() == "ru" ? "/ru" : "/en") }}/login/">
                            <i class="fa fa-sign-in" aria-hidden="true"></i>{{trans('auth.login')}}
                        </a>
                    </div>

                    <div class="tab-container">
                        <a href="{{ (App::getLocale() == "ru" ? "/ru" : "/en") }}/register/">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>{{trans('auth.registration')}}
                        </a>
                    </div>

                    <div class="tab-container">
                        <a class="act" href=""><i class="fa fa-retweet" aria-hidden="true"></i>{{trans('auth.forgot')}}</a>
                    </div>
                </div>
            </div>

            <div class="FormWr" ng-controller="ForgotCtrl">
                <div class="FormtBox">
                    <div class="title_form">{{trans('auth.reset')}}</div>
                    <form name="ForgotForm" ng-submit="ForgotSubmitForm()" novalidate>

                        <div class="input-container" ng-class="{ 'has-error' : ForgotForm.email.$invalid && ForgotForm.email.$touched }">
                            <input type="email" name="email" ng-model="user.email" ng-required="true">
                            <label for="email">{{trans('auth.your_email')}}*</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="ForgotForm.email.$invalid && ForgotForm.email.$touched" class="help-block">{{trans('auth.valid_email')}}</p>
                        </div>

                        <div class="button-container">
                            <div class="message_group">
                                @if (session('status'))
                                    <span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        {{ session('status') }}
                                    </span>
                                @endif
                                @if ($errors->has('email'))
                                    <span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        {{trans('passwords.user')}}
                                    </span>
                                @endif
                                @if ($errors->has('password'))
                                    <span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        {{trans('passwords.sent')}}
                                    </span>
                                @endif
                                {{--<span class="wait"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Please wait ...</span>--}}
                                {{--<span class="show green"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Your reset link send to your email</span>--}}
                                {{--<span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Error. Try again</span>--}}
                            </div>
                            <div class="loginBtn">
                                <button type="submit" ng-cloak ng-disabled="ForgotForm.$invalid">{{trans('auth.send')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>