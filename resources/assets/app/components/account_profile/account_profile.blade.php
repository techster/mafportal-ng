@extends('account.account')
@section('content')
@if(!Auth::user()->verified)
    <p style="color: red;">
        {{trans('account.confirm_email')}}
        <a style="color: red;text-decoration: underline;" href="{{ route('sendConfirmEmail') }}">
            {{trans('account.send')}}
        </a>
    </p>
@endif
<p>
    {{trans('account.welcome', ['name' => Auth::user()->name])}}
</p>
<div class="line m-t-30 m-b-20"></div>
<div class="formBoxa">
    <div class="title_form">{{trans('account.account_information')}}</div>

    <div style="margin: 20px auto;"  >
        @if(Auth::user()->avatar == null)
            <img style="display: block;width: 150px; height: 150px; border-radius: 50%;"  src="{{URL::to('/build/img/unknown_image.jpg')}}">
            <button type="button" style="margin-top:10px;display: block; border-radius: 100px;padding: 8px 20px;background-color: #b22121;font-size: 15px;font-weight: bold;color: #ffffff;border: none;transition: .3s;" data-toggle="modal" data-target="#myModal">{{trans('account.avatar_create')}}</button>
        @else
            <img style="display: block;width: 150px; height: 150px; border-radius: 50%;"   src="{{URL::to(Auth::user()->avatar)}}">
            <button type="button" style="margin-top:10px;display: block; border-radius: 100px;padding: 8px 20px;background-color: #b22121;font-size: 15px;font-weight: bold;color: #ffffff;border: none;transition: .3s;" data-toggle="modal" data-target="#myModal">{{trans('account.avatar_change')}}</button>
        @endif

    </div>

    <div style="margin: 0 auto;" class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <div>
                <div class="panel panel-default">
                    <div class="panel-heading"></div>
                    <div class="panel-body">


                        <div class="row">
                            <div class="col-md-4 col-xs-12 ">
                                <div id="upload-demo" style="width:350px"></div>
                            </div>
                            <div class="col-md-4 col-xs-8 col-xs-offset-1" style="padding-top:30px; float:right;margin-right: 50px">
                                <strong>{{trans('account.avatar_select')}}</strong>
                                <br/>
                                <input type="file" id="upload">
                                <br/>
                                <button class="btn btn-primary upload-result">{{trans('account.avatar_add')}}</button>
                                @if(Auth::user()->avatar != null)
                                    <button style="margin-top: 10px;" class="btn btn-danger delete-result">{{trans('account.avatar_delete')}}</button>
                                @endif
                                <h4 style="display: none; color: red;" id="error1">{{trans('account.avatar_nothing')}}</h4>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>

    <form id="asd" name="RegistForm" method="post" ng-submit="RegistSubmitForm()" novalidate>

        <div class="input-container" ng-class="{ 'has-error' : RegistForm.name.$invalid && RegistForm.name.$touched }">
            <input type="text" name="name" ng-model="user.name" ng-init="user.name='{{Auth::user()->name}}'">
            <label>{{trans('account.name')}}*</label>
            <div class="bar"></div>
            <p ng-cloak ng-show="RegistForm.name.$invalid && RegistForm.name.$touched" class="help-block">{{trans('account.enter_name')}}</p>
        </div>

        <div class="input-container" ng-class="{ 'has-error' : RegistForm.last_name.$invalid && RegistForm.last_name.$touched }">
            <input type="text" name="last_name" ng-model="user.last_name" ng-init="user.last_name='{{Auth::user()->last_name}}'">
            <label >{{trans('account.last_name')}}*</label>
            <div class="bar"></div>
            <p ng-cloak ng-show="RegistForm.last_name.$invalid && RegistForm.last_name.$touched" class="help-block">{{trans('account.enter_last_name')}}</p>
        </div>

        <div class="input-container" ng-class="{ 'has-error' : RegistForm.nickname.$invalid && RegistForm.nickname.$touched }">
            <input type="text" name="nickname" ng-model="user.nickname" ng-init="user.nickname='{{Auth::user()->nickname}}'">
            <label >{{trans('account.nickname')}}</label>
            <div class="bar"></div>
            <p ng-cloak ng-show="RegistForm.nickname.$invalid && RegistForm.nickname.$touched" class="help-block">{{trans('account.enter_nickname')}}</p>
        </div>

        <div class="input-container" ng-class="{ 'has-error' : RegistForm.email.$invalid && RegistForm.email.$touched }">
            <input type="email" name="email" ng-model="user.email" ng-init="user.email='{{Auth::user()->email}}'">
            <label for="email">{{trans('account.email')}}*</label>
            <div class="bar"></div>
            <p ng-cloak ng-show="RegistForm.email.$invalid && RegistForm.email.$touched" class="help-block">{{trans('account.enter_email')}}</p>
        </div>

        <div class="input-container" style="position: relative;">
            <div class="input-group" style="position: relative;">
                <input
                        type="text"
                        ng-not-empty="true"
                        uib-datepicker-popup
                        ng-model="user.date"
                        ng-value="user.date_init"
                        value="user.date_init"
                        is-open="popup.opened"
                        ng-init="user.date_init='{{ Auth::user()->date }}'"
                />
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
            <input type="password" name="password" ng-model="user.password" ng-minlength=6>
            <label for="password">{{trans('account.password')}}*</label>
            <div class="bar"></div>
            <p ng-cloak ng-show="RegistForm.password.$invalid && RegistForm.password.$touched" class="help-block">{{trans('account.enter_password')}}</p>
        </div>

        <div class="input-container" ng-class="{ 'has-error' : RegistForm.password_confirmation.$invalid && RegistForm.password_confirmation.$touched }">
            <input type="password" name="password_confirmation" ng-model="user.password_confirmation" ng-minlength=6>
            <label for="password_confirmation">{{trans('account.password_confirm')}}*</label>
            <div class="bar"></div>
            <p ng-cloak ng-show="RegistForm.password_confirmation.$invalid && RegistForm.password_confirmation.$touched" class="help-block">{{trans('account.enter_password_confirm')}}</p>
        </div>

        <div style="text-align: center;" class="button-container">
            <div class="loginBtn">
                <button type="submit" ng-cloak ng-disabled="RegistForm.$invalid">{{trans('account.save')}}</button>
            </div>
        </div>

    </form>
</div>
<script type="text/javascript">

    $( document ).ready(function() {

        $('#upload').attr('accept','image/*');

        $uploadCrop = $('#upload-demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'circle'
            },
            boundary: {
                width: 300,
                height: 300
            }
        });

        $('#upload').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });

        var loc = document.getElementById("global_loc").innerText;

        $('.upload-result').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport',
            }).then(function (resp) {
                $.ajax({
                    url: "/"+loc+"/image-crop",
                    type: "POST",
                    data: {"image":resp,
                        "_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        if (data != null && data.success) {
                            document.location.replace('/'+loc+"/account");
                        } else {
                            $('#error1').css("display", "block");
                        }
                    },
                    error: function () {

                    }
                });
            });
        });

        $('.delete-result').on('click', function (ev) {

            $.ajax({
                url: "/"+loc+"/image-delete",
                type: "POST",
                data: {"image_name":'delete',
                    "_token": "{{ csrf_token() }}"},
                success: function (data) {
                    if (data != null && data.success) {
                        document.location.replace('/'+loc+"/account");
                    } else {

                    }
                },
                error: function () {

                }
            });
        });

    });




</script>

@endsection
