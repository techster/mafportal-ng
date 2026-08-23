@extends('layouts.modal')


@section('ctrl') ng-controller="ShopModalCtrl" @endsection


@section('title')
    <p>{{ trans('balance.add_item') }}</p>
@endsection


@section('content')
        <div class="shop">
            <form name="RegistForm" ng-submit="submitForm()" novalidate style="text-align: center;">

                <div class="button-container" style="text-align: center; display: inline-block; margin: 0 15px;">
                    <div class="loginBtn">
                        <a href="/{{ Config::get('app.locale') }}/cart" class="button">{{ trans('balance.go_cart') }}</a>
                    </div>
                </div>

                <div class="button-container" style="text-align: center; display: inline-block; margin: 0 15px; cursor: pointer;">
                    <div class="loginBtn">
                        <div ng-click="closeThisDialog()" class="button">{{ trans('balance.continue') }}</div>
                    </div>
                </div>

            </form>
        </div>
@endsection