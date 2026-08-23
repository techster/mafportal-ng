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
                        <a class="act" href=""><i class="fa fa-retweet" aria-hidden="true"></i>{{trans('auth.reset')}}</a>
                    </div>
                </div>
            </div>

            <div class="FormWr" ng-controller="ResetCtrl">
                <div class="FormtBox">
                    <div class="title_form">{{trans('auth.reset')}}</div>
                    <form name="ResetForm" ng-submit="ResetSubmitForm()" novalidate>

                        <input type="hidden" name="token" ng-model="user.token" value="{{ $token }}">

                        <div class="input-container" ng-class="{ 'has-error' : ResetForm.email.$invalid && ResetForm.email.$touched }">
                            <input type="email" name="email" ng-model="user.email" ng-required="true">
                            <label for="email">{{trans('account.email')}}*</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="ResetForm.email.$invalid && ResetForm.email.$touched" class="help-block">Enter a valid Email Address.</p>
                        </div>

                        <div class="input-container" ng-class="{ 'has-error' : ResetForm.password.$invalid && ResetForm.password.$touched }">
                            <input type="password" name="password" ng-model="user.password" ng-required="true" ng-minlength=6>
                            <label for="password">{{trans('account.password')}}*</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="ResetForm.password.$invalid && ResetForm.password.$touched" class="help-block">Password must be at least 6 characters.</p>
                        </div>

                        <div class="input-container" ng-class="{ 'has-error' : ResetForm.password_confirmation.$invalid && ResetForm.password_confirmation.$touched }">
                            <input type="password" name="password_confirmation" ng-model="user.password_confirmation" ng-required="true" ng-minlength=6>
                            <label for="password_confirmation">{{trans('account.password_confirm')}}*</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="ResetForm.password_confirmation.$invalid && ResetForm.password_confirmation.$touched" class="help-block">Password must be at least 6 characters.</p>
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
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                                @if ($errors->has('password'))
                                    <span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                                {{--<span class="wait show"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Please wait ...</span>--}}
                                {{--<span class="green"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> You have successfully registered</span>--}}
                                {{--<span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Email or password is not correct</span>--}}
                                {{--<span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Error. Try again</span>--}}
                            </div>
                            <div class="loginBtn">
                                <button type="submit" ng-cloak ng-disabled="ResetForm.$invalid">{{trans('auth.sent')}}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>