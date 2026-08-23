@extends('account.account')
@section('content')
    <h2 style="margin-bottom: 20px;">{{ trans('balance.your_balance') }}: $<?=number_format(Auth::user()->balance, 2, ',', ' ')?></h2>

    <section class="ContactPage" ng-controller="balanceCtrl">
        <div class="ContWr">
            <div class="infoWr">
                <div class="formWr" style="flex-basis: 50%;">
                    <p class="text_title">
                        <strong>{{ trans('balance.billing_address') }}</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </p>
                    <br>

                    <form name="ContForm" ng-submit="submitForm()" novalidate>
                        <fieldset ng-disabled="billing.same">
                            <div ng-init="billing.title='{{ Auth::user() ? Auth::user()->withFakes()->billing_title : "MRS." }}'" style="margin-bottom: 8px;font-size: 13px;" class="input-container" ng-class="{ 'has-error' : ContForm.name.$invalid && ContForm.name.$touched }">

                                <input style="width: auto;" type="radio" name="billing_title" ng-model="billing.title" value="MRS."> MRS.&nbsp;&nbsp;&nbsp;
                                <input style="width: auto;" type="radio" name="billing_title" ng-model="billing.title" value="MS."> MS.&nbsp;&nbsp;&nbsp;
                                <input style="width: auto;" type="radio" name="billing_title" ng-model="billing.title" value="MR."> MR.&nbsp;&nbsp;&nbsp;

                                <p ng-cloak ng-show="ContForm.name.$invalid && ContForm.name.$touched" class="help-block">{{trans('contacts.name_required')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.name.$invalid && ContForm.name.$touched }">
                                <input type="text" name="name" ng-init="billing.name='{{ Auth::user() ? Auth::user()->withFakes()->billing_name : "" }}'" ng-model="billing.name" ng-required="true">
                                <label for="name">{{ trans('balance.full_name') }}</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.name.$invalid && ContForm.name.$touched" class="help-block">{{trans('contacts.name_required')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.address1.$invalid && ContForm.address1.$touched }">
                                <input type="text" name="address1" ng-init="billing.address1='{{ Auth::user() ? Auth::user()->withFakes()->billing_address1 : "" }}'" ng-model="billing.address1" ng-required="true">
                                <label for="address1">{{ trans('balance.address_line1') }}</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.address1.$invalid && ContForm.address1.$touched" class="help-block">{{trans('contacts.valid_address1')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.address2.$invalid && ContForm.address2.$touched }">
                                <input type="text" name="address2" ng-init="billing.address2='{{ Auth::user() ? Auth::user()->withFakes()->billing_address2 : "" }}'" ng-model="billing.address2" ng-required="true">
                                <label for="address2">{{ trans('balance.address_line2') }}</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.address2.$invalid && ContForm.address2.$touched" class="help-block">{{trans('contacts.valid_address2')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.city.$invalid && ContForm.city.$touched }">
                                <input type="text" name="city" ng-init="billing.city='{{ Auth::user() ? Auth::user()->withFakes()->billing_city : "" }}'" ng-model="billing.city" ng-required="true">
                                <label for="city">{{ trans('balance.city') }}</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.city.$invalid && ContForm.city.$touched" class="help-block">{{trans('contacts.valid_city')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.region.$invalid && ContForm.region.$touched }">
                                <input type="text" name="region" ng-init="billing.region='{{ Auth::user() ? Auth::user()->withFakes()->billing_region : "" }}'" ng-model="billing.region" ng-required="true">
                                <label for="region">{{ trans('balance.state') }}</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.region.$invalid && ContForm.region.$touched" class="help-block">{{trans('contacts.valid_region')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.zip.$invalid && ContForm.zip.$touched }">
                                <input type="text" name="zip" ng-init="billing.zip='{{ Auth::user() ? Auth::user()->withFakes()->billing_zip : "" }}'" ng-model="billing.zip" ng-required="true">
                                <label for="zip">ZIP:</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.zip.$invalid && ContForm.zip.$touched" class="help-block">{{trans('contacts.valid_zip')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.country.$invalid && ContForm.country.$touched }">
                                <select class="ng-not-empty" style="width: 100%;height: 22px;border:none;font-weight:bold;position:relative;margin:12px 0 8px 0;" type="text" name="country" ng-init="billing.country='{{ Auth::user() ? Auth::user()->withFakes()->billing_country : "" }}'" ng-model="billing.country" ng-required="true">
                                    @foreach($countrylist as $key => $item)
                                        <option value="{{$key}}">{{$item["name"]}}</option>
                                    @endforeach
                                </select>
                                <label for="country">{{ trans('balance.country') }}</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.country.$invalid && ContForm.country.$touched" class="help-block">{{trans('contacts.valid_country')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.email.$invalid && ContForm.email.$touched }">
                                <input type="text" name="email" ng-init="billing.email='{{ Auth::user() ? Auth::user()->withFakes()->billing_email : "" }}'" ng-model="billing.email" ng-required="true">
                                <label for="email">Email:</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.email.$invalid && ContForm.email.$touched" class="help-block">{{trans('contacts.valid_email')}}</p>
                            </div>
                        </fieldset>
                    </form>
                </div>

                <div class="formWr" style="flex-basis: 50%;margin-right: 0;">
                    <p class="text_title">
                        <strong>{{ trans('balance.payment') }}</strong>
                    </p>
                    <br>

                    <div ng-init="billing.payment_type='credit_card'" style="margin-bottom: 8px;font-size: 13px;" class="input-container" ng-class="{ 'has-error' : ContForm.payment_type.$invalid && ContForm.payment_type.$touched }">
                        <input style="width: auto;cursor: pointer;" type="radio" name="payment_type" ng-model="billing.payment_type" id="credit_card" value="credit_card">
                        <label style="position: static;transform: none;cursor: pointer;color: #000;" for="credit_card">{{ trans('balance.credit_card') }}&nbsp;&nbsp;&nbsp;</label>

                        <input style="width: auto;cursor: pointer;" type="radio" name="payment_type" ng-model="billing.payment_type" id="paypal" value="paypal">
                        <label style="position: static;transform: none;cursor: pointer;color: #000;" for="paypal">PayPal&nbsp;&nbsp;&nbsp;</label>

                        <p ng-cloak ng-show="ContForm.payment_type.$invalid && ContForm.payment_type.$touched" class="help-block">{{trans('contacts.payment_type_required')}}</p>
                    </div>

                    <div class="ContWr" ng-show="billing.payment_type=='credit_card'">
                        <div class="infoWr">
                            <div class="formWr" style="flex-basis:100%; margin-right:0;">
                                <form name="CardForm" ng-submit="submitForm()" style="text-align: justify;" novalidate>
                                    <div class="input-container" ng-class="{ 'has-error' : ContForm.name.$invalid && ContForm.name.$touched }">
                                        <input type="text" name="name" ng-model="billing.amount" ng-required="true">
                                        <label for="name">{{ trans('balance.refill_balance') }}</label>
                                        <div class="bar"></div>
                                        <p ng-cloak ng-show="ContForm.name.$invalid && ContForm.name.$touched" class="help-block">{{trans('contacts.name_required')}}</p>
                                    </div>

                                    <div style="display: inline-block;width: 100%;" class="input-container" ng-class="{ 'has-error' : CardForm.number.$invalid && CardForm.number.$touched }">
                                        <input type="text" name="number" ng-init="card.number=''" ng-model="card.number" ng-required="true">
                                        <label for="number">{{ trans('balance.card_number') }}</label>
                                        <div class="bar"></div>
                                        <p ng-cloak ng-show="CardForm.number.$invalid && CardForm.number.$touched" class="help-block">{{trans('contacts.number_required')}}</p>
                                    </div>

                                    <div style="width: 48%; display: inline-block;" class="input-container" ng-class="{ 'has-error' : CardForm.expiration.$invalid && CardForm.expiration.$touched }">
                                        <input type="text" name="expiration" ng-init="card.expiration=''" ng-model="card.expiration" ng-required="true">
                                        <label for="expiration">{{ trans('balance.mm_yy') }}</label>
                                        <div class="bar"></div>
                                        <p ng-cloak ng-show="CardForm.expiration.$invalid && CardForm.expiration.$touched" class="help-block">{{trans('contacts.expiration_required')}}</p>
                                    </div>

                                    <div style="width: 48%; display: inline-block;" class="input-container" ng-class="{ 'has-error' : CardForm.cvc.$invalid && CardForm.cvc.$touched }">
                                        <input type="text" name="cvc" ng-init="card.cvc=''" ng-model="card.cvc" ng-required="true">
                                        <label for="cvc">{{ trans('balance.cvc') }}</label>
                                        <div class="bar"></div>
                                        <p ng-cloak ng-show="CardForm.cvc.$invalid && CardForm.cvc.$touched" class="help-block">{{trans('contacts.cvc_required')}}</p>
                                    </div>

                                    <div style="width: 100%; display: inline-block;"></div>

                                    <div class="button-container" style="margin-top: -15px; width: 100%;">
                                        <div class="loginBtn">
                                            <button style="font-size: 13px;" ng-click="send_order(billing, card, '{{csrf_token()}}')" type="submit">{{ trans('balance.refill') }} - $@{{ billing.amount ? billing.amount : 0 }}</button>
                                            <img ng-show="loader==true" class="loader" src="/build/img/loader.gif" alt="">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="ContWr" ng-show="billing.payment_type=='paypal'">
                        <div class="infoWr">
                            <div class="formWr" style="flex-basis:100%; margin-right:0;">
                                <form name="PaypalForm" ng-submit="submitForm()" novalidate>
                                    <div class="input-container" ng-class="{ 'has-error' : ContForm.name.$invalid && ContForm.name.$touched }">
                                        <input type="text" name="name" ng-model="billing.amount" ng-required="true">
                                        <label for="name">{{ trans('balance.refill_balance') }}</label>
                                        <div class="bar"></div>
                                        <p ng-cloak ng-show="ContForm.name.$invalid && ContForm.name.$touched" class="help-block">{{trans('contacts.name_required')}}</p>
                                    </div>

                                    <div class="button-container">
                                        <div class="loginBtn">
                                            <button style="font-size: 13px;" ng-click="send_order(billing, 'paypal', '{{csrf_token()}}')" type="submit">{{ trans('balance.refill') }} - $@{{ billing.amount ? billing.amount : 0 }}</button>
                                            <img ng-show="loader==true" class="loader" src="/build/img/loader.gif" alt="">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection