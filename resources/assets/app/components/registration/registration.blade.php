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
                        <a class="act" href="">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>{{trans('auth.registration')}}
                        </a>
                    </div>
                    <div class="tab-container">
                        <a href="{{ (App::getLocale() == "ru" ? "/ru" : "/en") }}/password/reset/">
                            <i class="fa fa-retweet" aria-hidden="true"></i>{{trans('auth.forgot')}}
                        </a>
                    </div>
                </div>
            </div>

            <div class="FormWr" ng-controller="RegistCtrl">
                <div class="FormtBox">
                    <div class="title_form">{{trans('account.account_information')}}</div>
                    <form name="RegistForm" ng-submit="RegistSubmitForm()" novalidate>
                        {{ csrf_field() }}
                        <div class="input-container" ng-class="{ 'has-error' : RegistForm.name.$invalid && RegistForm.name.$touched }">
                            <input type="text" id="name" name="name" ng-model="user.name" ng-required="true">
                            <label>{{trans('account.name')}}*</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="RegistForm.name.$invalid && RegistForm.name.$touched" class="help-block">{{trans('account.enter_name')}}</p>
                        </div>

                        <div class="input-container" ng-class="{ 'has-error' : RegistForm.last_name.$invalid && RegistForm.last_name.$touched }">
                            <input type="text" id="last_name" name="last_name" ng-model="user.last_name" ng-required="true">
                            <label >{{trans('account.last_name')}}*</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="RegistForm.last_name.$invalid && RegistForm.last_name.$touched" class="help-block">{{trans('account.enter_last_name')}}</p>
                        </div>

                        <div class="input-container" ng-class="{ 'has-error' : RegistForm.nickname.$invalid && RegistForm.nickname.$touched }">
                            <input type="text" name="nickname" ng-model="user.nickname">
                            <label >{{trans('account.nickname')}}</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="RegistForm.nickname.$invalid && RegistForm.nickname.$touched" class="help-block">{{trans('account.enter_nickname')}}</p>
                        </div>

                        <div class="input-container" ng-class="{ 'has-error' : RegistForm.email.$invalid && RegistForm.email.$touched }">
                            <input id="changeEmail" ng-pattern="email_add" type="email" name="email" ng-change="changeEmail()" ng-model="user.email" ng-required="true">
                            <label for="email">{{trans('account.email')}}*</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="RegistForm.email.$invalid && RegistForm.email.$touched" class="help-block">{{trans('account.enter_email')}}</p>
                            <p id="err_email" style="display: none;" class="help-block">{{trans('account.check_email')}}!</p>
                        </div>

                        <div class="input-container" style="position: relative;">
                            <div class="input-group" style="position: relative;">
                                <input type="text" uib-datepicker-popup ng-model="user.date" is-open="popup.opened"  close-text="Close" />
                                <label for="date">{{trans('account.birthday')}}</label>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open()">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="bar"></div>
                        </div>

                        <div class="input-container" ng-class="{ 'has-error' : RegistForm.password.$invalid && RegistForm.password.$touched }">
                            <input type="password" name="password" ng-model="user.password" ng-required="true" ng-minlength=6>
                            <label for="password">{{trans('auth.password')}}*</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="RegistForm.password.$invalid && RegistForm.password.$touched" class="help-block">{{trans('account.enter_password')}}</p>
                        </div>

                        <div class="input-container" ng-class="{ 'has-error' : RegistForm.password_confirmation.$invalid && RegistForm.password_confirmation.$touched }">
                            <input type="password" name="password_confirmation" ng-model="user.password_confirmation" ng-required="true" ng-minlength=6>
                            <label for="password_confirmation">{{trans('auth.password_confirm')}}*</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="RegistForm.password_confirmation.$invalid && RegistForm.password_confirmation.$touched" class="help-block">{{trans('account.enter_password_confirm')}}</p>
                        </div>

                        <div style="text-align: center;margin-bottom: 20px;" class="input-container">
                            <p style="font-size: 14px;font-weight: bold;color: #7e7e7e;margin-bottom: 12px;position: static;">{{trans('auth.main_club')}}</p>
                            <select class="form-control" style="width: 300px;margin: 0 auto;" ng-model="user.club" name="club">
                                <option value=""></option>
                                @foreach($clubs as $club)
                                    <option value="{{$club->id}}">{{$club->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xs-12 g-recaptcha" data-sitekey="6LfEJYMUAAAAAKJFeUTTM-e1y_HyG8pOumfiyodw"></div>

                        <div class="input-container" ng-class="{ 'has-error' : RegistForm.check.$invalid && RegistForm.check.$touched }">
                            <input style="display: none;" type="text" id="check" name="check" ng-model="user.check">
                            <p ng-cloak ng-show="RegistForm.check.$invalid && RegistForm.check.$touched" class="help-block"></p>
                        </div>

                        <input style="display: none;" type="text" id="avatar" name="avatar" ng-model="user.avatar">

                        <div class="button-container">
                            <div class="message_group">
                                {{--<span class="wait show"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Please wait ...</span>--}}
                                {{--<span class="green"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> You have successfully registered</span>--}}
                                {{--<span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Email or password is not correct</span>--}}
                                {{--<span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Error. Try again</span>--}}
                            </div>
                            <div class="loginBtn">
                                <button type="submit" ng-cloak ng-disabled="RegistForm.$invalid">{{trans('auth.send')}}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

