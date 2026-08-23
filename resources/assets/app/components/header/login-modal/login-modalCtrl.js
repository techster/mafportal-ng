angular.module("app").controller("LoginModalCtrl", ["$scope", "$http", function( $scope, $http ){
    "use strict";

    console.log("Login-modalCtrl");
    var loc = document.getElementById("global_loc").innerText;
    var plswait = document.getElementById("global_plswait").innerText;

    $scope.submitForm = function() {
        if ($scope.RegistForm.$valid) {
            angular.element(document.querySelector(".ModalBox .formWr .message_group")).html('<span class="wait"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>'+plswait+'</span>');
            console.log(document.getElementById("locale").value);
            var redirect = document.getElementById("locale").value;
            $http({
                method: 'POST',
                url: '/'+loc+'/login',
                data: "email="+this.user.email+
                      "&password="+this.user.password,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}  //set the headers so angular passing info as form data (not request payload)
            }).then(function (result) {
                var parser = new DOMParser();
                var message_group = parser.parseFromString(result.data, 'text/html').querySelectorAll('.hidden_error');
                var error = angular.element(message_group).html();
                console.log(error);
                console.log(typeof error);
                if(error.indexOf('span') > -1){
                    angular.element(document.querySelector(".ModalBox .formWr .message_group")).html(error);

                } else {
                    document.location.replace(redirect);

                }
            }, function(result) {
                // not code 200
            });
        }
    };

    $scope.submitForgotForm = function() {
        if ($scope.ForgotForm.$valid) {
            angular.element(document.querySelector(".ModalBox .ForgotWr .message_group")).html('<span class="wait"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>'+plswait+'</span>');
            $http({
                method: 'POST',
                url: '/'+loc+'/password/email',
                data: "email="+this.user.email,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                var parser = new DOMParser();
                var message_group = parser.parseFromString(result.data, 'text/html').querySelectorAll('.hidden_errorr');
                var error = angular.element(message_group).html();
                if(error === undefined){
                    // document.location.replace("/account");
                } else {
                    angular.element(document.querySelector(".ModalBox .ForgotWr .message_group")).html(error);
                }
            }, function(result) {
                // not code 200
            });
        }
    };

}]);