app.controller("RegistCtrl", ["$scope", "$http", "$filter", function ($scope, $http, $filter) {
    "use strict";

    console.log("REGISTRATION CTRL");


    $scope.open = function() {
        $scope.popup.opened = true;
    };


    var loc = document.getElementById("global_loc").innerText;

    //Email validation
    $scope.email_add = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    //email not same check

    $scope.changeEmail = function() {
        $http({
            method: 'POST',
            url: '/'+loc+'/register/check_email',
            data: "email="+$( '#changeEmail' ).val(),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (result) {
            if(result.data == 'false') {
                $('#err_email').show();
                $scope.RegistForm.$invalid = true;
            } else {
                $('#err_email').hide();
            }
        }, function (error) {
            // errorCallback(error.data);
        });
    };


    $scope.popup = {
        opened: false
    };

    var plswait = document.getElementById("global_plswait").innerText;
    $scope.user = {};
    $scope.RegistSubmitForm = function () {
        if ($scope.RegistForm.$valid) {
            angular.element(document.querySelector(".RegistrationPage .message_group")).html('<span class="wait"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>'+plswait+'</span>');
            $http({
                method: 'POST',
                url: '/'+loc+'/register',
                data: "name="+this.user.name+
                      "&email="+this.user.email+
                      "&last_name="+this.user.last_name+
                      "&nickname="+this.user.nickname+
                      "&club="+this.user.club+
                      "&avatar="+this.user.avatar+
                      "&check="+this.user.check+
                      "&date="+$filter('date')(this.user.date, "yyyy-MM-dd")+
                      "&password="+this.user.password+
                      "&password_confirmation=" + this.user.password_confirmation,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}  //set the headers so angular passing info as form data (not request payload)
            }).then(function (result) {
                angular.element(document.querySelector(".RegistrationPage .message_group")).html('<span style="margin-bottom: 30px;" class="green"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> You have successfully registered. A link to confirm your registration has been sent to your email address.</span>');
            }, function(result) {
                angular.element(document.querySelector(".RegistrationPage .message_group")).html('');
                for (var item in result.data) {
                    angular.element(document.querySelector(".RegistrationPage .message_group")).append('<span style="margin-bottom: 30px;" class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+result.data[item][0]+'</span>');
                }
            });
        }
    };
}]);