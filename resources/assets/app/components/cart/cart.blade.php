@if(json_decode($cart))
<div ng-controller="rating3Ctrl">
<input type="hidden" value="{{$cart}}" id="data">

<div class="Tab RatingCL m-t-20 m-b-100" ng-cloak>
    <div class="container">
        <div class="TablWr">
            <div class="toolbar">
                <div class="members">{{ trans('balance.item') }} @{{ filterFun.length ? filterFun.length : 0 }}</div>
                <div class="filtersWr"></div>
            </div>
            <!--[ TABLE ]-->
            <div class="Rating_table">
                <div class="table_content">
                    <table class="body" cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                            <tr>
                                <th>#</th>
                                <th><span class="ar" ng-click="sortType = 'name';  sortReverse = !sortReverse">{{ trans('balance.name') }}</span></th>
                                <th><span class="ar" ng-click="sortType = 'qty';   sortReverse = !sortReverse">{{ trans('balance.qty') }}</span></th>
                                <th><span class="ar" ng-click="sortType = 'price'; sortReverse = !sortReverse">{{ trans('balance.price') }}</span></th>
                                <th><span class="ar" ng-click="sortType = 'subtotal'; sortReverse = !sortReverse">{{ trans('balance.subtotal') }}</span></th>
                                <th><span class="ar">{{ trans('balance.remove') }}</span></th>
                            </tr>
                            <tr class="animate_repeat"
                                ng-repeat="item in filterFun = (items | filter:query | orderBy:sortType:sortReverse)">
                                <th><span>@{{$index + 1}}</span></th>
                                <th>@{{item.name}}</th>
                                <th><input ng-model="item.qty" ng-change="ChangeCartItem($event, item.id, '{{csrf_token()}}', item.qty)" style="text-align: center;width: 30px;" type="text" name="qty"></th>
                                <th>$@{{item.price}}</th>
                                <th>$@{{item.price*item.qty}}</th>
                                <th><a ng-click="RemoveCartItem($event, item.id, '{{csrf_token()}}')" style="color: #000" href="{{route("remove_from_cart")}}" item-id="@{{item.id}}">{{ trans('balance.remove') }}</a></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>{{ trans('balance.total') }}</th>
                                <th></th>
                                <th></th>
                                <th id="price_value">$@{{ items ? sum(items, 'price', 'qty') : 0 }}</th>
                                <th></th>
                            </tr>

                            <tbody ng-if="filterFun.length == 0">
                                <tr class="animate_repeat">
                                    <td colspan="8">
                                        <i class="fa fa-exclamation-circle text-red" aria-hidden="true"></i>&#160;&#160;
                                            <strong class="text-red">{{trans('clubs.no_results')}}</strong>
                                    </td>
                                </tr>
                            </tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<section class="ContactPage">
    <div class="container">
        <div class="ContWr">
            <div class="infoWr">
                @if (!Auth::check())
                    <div style="margin: 0 auto;">
                        <form>
                            <input id="redirect_login" class="not_auth_complete" type="submit" value="{{ trans('balance.to_purchase') }}">
                        </form>
                    </div>
                @else
                    <div class="formWr" style="flex-basis: 50%;">
                        <p class="text_title" style="text-align: center;">
                            <strong>{{ trans('balance.shipping_address') }}</strong>
                        </p>
                        <br>

                        <form name="ContForm" ng-submit="submitForm()" novalidate>
                            <div style="margin-bottom: 8px;font-size: 13px;" class="input-container" ng-init="shipping.title='{{ isset($payment_data->shipping_title)  ? $payment_data->shipping_title : "MRS." }}'" ng-class="{ 'has-error' : ContForm.name.$invalid && ContForm.name.$touched }">

                                <input style="width: auto;" type="radio" name="shipping_title" ng-model="shipping.title" value="MRS."> MRS.&nbsp;&nbsp;&nbsp;
                                <input style="width: auto;" type="radio" name="shipping_title" ng-model="shipping.title" value="MS."> MS.&nbsp;&nbsp;&nbsp;
                                <input style="width: auto;" type="radio" name="shipping_title" ng-model="shipping.title" value="MR."> MR.&nbsp;&nbsp;&nbsp;

                                <p ng-cloak ng-show="ContForm.shipping_title.$invalid && ContForm.shipping_title.$touched" class="help-block">{{trans('contacts.name_required')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.name.$invalid && ContForm.name.$touched }">
                                <input type="text" name="name" ng-model="shipping.name" ng-init="shipping.name='{{ isset($payment_data->shipping_name) ? $payment_data->shipping_name : "" }}'"  required>
                                <label for="name">{{ trans('balance.full_name') }}</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.name.$invalid && ContForm.name.$touched" class="help-block">{{trans('contacts.name_required')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.address1.$invalid && ContForm.address1.$touched }">
                                <input type="text" name="address1" ng-model="shipping.address1" ng-init="shipping.address1='{{ isset($payment_data->shipping_address1) ? $payment_data->shipping_address1 : "" }}'" required>
                                <label for="address1">{{ trans('balance.address_line1') }}</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.address1.$invalid && ContForm.address1.$touched" class="help-block">{{trans('contacts.valid_address1')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.address2.$invalid && ContForm.address2.$touched }">
                                <input type="text" name="address2" ng-model="shipping.address2" ng-init="shipping.address2='{{ isset($payment_data->shipping_address2) ? $payment_data->shipping_address2 : "" }}'">
                                <label for="address2">{{ trans('balance.address_line2') }}</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.address2.$invalid && ContForm.address2.$touched" class="help-block">{{trans('contacts.valid_address2')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.city.$invalid && ContForm.city.$touched }">
                                <input type="text" name="city" ng-model="shipping.city" ng-init="shipping.city='{{ isset($payment_data->shipping_city) ? $payment_data->shipping_city : "" }}'" required>
                                <label for="city">{{ trans('balance.city') }}</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.city.$invalid && ContForm.city.$touched" class="help-block">{{trans('contacts.valid_city')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.region.$invalid && ContForm.region.$touched }">
                                <input type="text" name="region" ng-model="shipping.region" ng-init="shipping.region='{{ isset($payment_data->shipping_region) ? $payment_data->shipping_region : "" }}'" required>
                                <label for="region">{{ trans('balance.state') }}</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.region.$invalid && ContForm.region.$touched" class="help-block">{{trans('contacts.valid_region')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.zip.$invalid && ContForm.zip.$touched }">
                                <input type="number" name="zip" ng-model="shipping.zip" ng-init="shipping.zip={{ isset($payment_data->shipping_zip) ? $payment_data->shipping_zip : "" }}" required>
                                <label for="zip">ZIP:</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.zip.$invalid && ContForm.zip.$touched" class="help-block">{{trans('contacts.valid_zip')}}</p>
                            </div>


                            <div class="input-container" ng-class="{ 'has-error' : ContForm.country.$invalid && ContForm.country.$touched }">
                                <select class="ng-not-empty" style="width: 100%;height: 22px;border:none;font-weight:bold;position:relative;margin:12px 0 8px 0;" type="text" name="country" ng-model="shipping.country" ng-init="shipping.country='{{ isset($payment_data->shipping_country) ? $payment_data->shipping_country : "" }}'" required>
                                    @foreach($countrylist as $key => $item)
                                        <option value="{{$key}}">{{$item["name"]}}</option>
                                    @endforeach
                                </select>
                                <label for="country">{{ trans('balance.country') }}</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.country.$invalid && ContForm.country.$touched" class="help-block">{{trans('contacts.valid_country')}}</p>
                            </div>

                            <div class="input-container" ng-class="{ 'has-error' : ContForm.email.$invalid && ContForm.email.$touched }">
                                <input id="eml" type="text" ng-pattern="eml_add" name="email" ng-model="shipping.email" ng-init="shipping.email='{{ isset($payment_data->shipping_email) ? $payment_data->shipping_email : "" }}'" required>
                                <label for="email">Email:</label>
                                <div class="bar"></div>
                                <p ng-cloak ng-show="ContForm.email.$invalid && ContForm.email.$touched" class="help-block">{{trans('contacts.valid_email')}}</p>
                            </div>

                            <div class="button-container" style="margin-top: 40px;">
                                <div class="loginBtn">
                                    <button id="click_submit" ng-disabled="ContForm.$invalid" ng-click="send_order(shipping, items, 'paypal', '{{csrf_token()}}')" type="submit">{{ trans('balance.pay') }} - $@{{ items ? sum(items, 'price', 'qty') : 0 }}</button>
                                    <img ng-show="loader==true" class="loader" src="/build/img/loader.gif" alt="">
                                </div>
                            </div>

                            <div id="no_product_error" style="display: none;" class="input-container">
                                <h4 style="text-align: center; margin-top: 20px; color: #b22121; font-weight: bold;">{{trans('contacts.no_product')}}</h4>
                            </div>

                        </form>
                    </div>
                @endif


            </div>
        </div>
    </div>




</section>










@else
    <div class="Tab RatingCL m-t-20 m-b-100" ng-cloak>
        <div class="container">
            <div class="col-md-12">
                <h4 class="text-red no_cont">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    <span>{{ trans('balance.empty_cart') }}</span>
                </h4>
            </div>
        </div>
    </div>
@endif
</div>
