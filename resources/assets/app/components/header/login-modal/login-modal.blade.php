@extends('layouts.modal')


@section('ctrl') ng-controller="LoginModalCtrl" @endsection


@section('title')
        <p ng-show="!Forgot">{{trans('auth.login_or_create')}}</p>
        <p ng-show="Forgot">{{trans('auth.forgot')}}</p>
@endsection


@section('content')
<script src="https://connect.facebook.net/en_US/sdk.js"></script>
    <div class="formBox" ng-class="{'Forgot': Forgot}">

        <div ng-show="!Forgot" class="formWr">
            <span class="or">{{trans('auth.or')}}</span>
            <div ng-show="!Register" class="login">
                <div class="title">{{trans('auth.login')}}</div>
                <form name="RegistForm" ng-submit="submitForm()" novalidate>

                    <div class="input-container" ng-class="{ 'has-error' : RegistForm.email.$invalid && RegistForm.email.$touched }">
                        <input type="email" name="email" ng-model="user.email" ng-required="true">
                        <label for="email">{{trans('auth.your_email')}}</label>
                        <div class="bar"></div>
                        <p ng-cloak ng-show="RegistForm.email.$invalid && RegistForm.email.$touched" class="help-block">{{trans('auth.valid_email')}}</p>
                    </div>

                    <div class="input-container" ng-class="{ 'has-error' : RegistForm.password.$invalid && RegistForm.password.$touched }">
                        <input type="password" name="password" ng-model="user.password" ng-required="true" ng-minlength=6>
                        <label for="password">{{trans('auth.your_password')}}</label>
                        <div class="bar"></div>
                        <p ng-cloak ng-show="RegistForm.password.$invalid && RegistForm.password.$touched" class="help-block">{{trans('auth.valid_password')}}</p>
                    </div>

                    <div class="forgot">
                        <a ng-click="Forgot = !Forgot" href="">{{trans('auth.forgot')}}</a>
                    </div>

                    <div class="button-container">
                        <div class="loginBtn">
                            <button type="submit" ng-cloak ng-disabled="RegistForm.$invalid">{{trans('auth.login')}}</button>
                        </div>

                        <div class="cancel">
                            <a ng-click="closeThisDialog()" href="">{{trans('auth.cancel')}}</a>
                        </div>
                        {{--[ message ]--}}
                        <div class="message_group"></div>
                    </div>

                </form>
            </div>
        </div>

        <div ng-show="Forgot" class="ForgotWr animate-show-hide">
            <form name="ForgotForm" ng-submit="submitForgotForm()" novalidate>

                <div class="input-container corgot_con" ng-class="{ 'has-error' : ForgotForm.email.$invalid && ForgotForm.email.$touched }">
                    <input type="email" name="email" ng-model="user.email" ng-required="true">
                    <label for="email">{{trans('auth.your_email')}}</label>
                    <div class="bar"></div>
                    <p ng-cloak ng-show="ForgotForm.email.$invalid && ForgotForm.email.$touched" class="help-block">{{trans('auth.valid_email')}}</p>
                </div>

                <div class="button-container cust-cont">
                    <div class="loginBtn">
                        <button type="submit" ng-cloak ng-disabled="ForgotForm.$invalid">{{trans('auth.send')}}</button>
                    </div>
                    {{--[ message ]--}}
                    <div class="message_group"></div>
                </div>

            </form>
        </div>
        <div class="reg_div">
            <div ng-show="!Forgot" class="register">
                <a href="{{ (App::getLocale() == "ru" ? "/ru" : "/en") }}/register">{{trans('auth.registration')}}</a>
            </div>

            <div ng-show="!Forgot" class="facebook_log">
                <div class="fb-login-button" data-max-rows="1" data-size="large"
                     data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false">
                    <form  action="{{ url('auth/facebook') }}">
                        <button class="btn btn-lg btn-google text-uppercase google-login" type="submit">
                            <img src="/images/facebook.jpg" style="width:193px;height: 42px">
                        </button>
                    </form>
                </div>
            </div>

            <div  style="text-align: center; margin-right: -36px">
                <form  action="{{ url('auth/google') }}">
                    <button class="btn btn-light btn-google text-uppercase google-login" type="submit">
                        <img src="/images/google.png" style="width: 201px;height:46px;margin-left: 13px; margin-top: -12px">
                    </button>
                </form>
            </div>

            <script>
                (function ($) {
                    FB.XFBML.parse();
                })(jQuery);
            </script>
        </div>
    </div>

@endsection

<style>
    .google-login{
        font-size: 14px;
        background: white;
    }

    .facebook_log{
        width: 100%;
        margin: 20% 0 0 -24.3% !important;
        display: block;
    }

    .instagram-login{
        width: 100%;
        margin: 5% 0 0 23% !important;
        display: block;
    }
</style>

<script>
    function onClick() {
        debugger
    }
</script>
