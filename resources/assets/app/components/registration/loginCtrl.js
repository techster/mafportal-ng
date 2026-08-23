app.controller("LoginCtrl", ["$scope", "$http", function( $scope, $http ){
    "use strict";

    console.log("LoginCtrl");
    var loc = document.getElementById("global_loc").innerText;
    var plswait = document.getElementById("global_plswait").innerText;

    $scope.LoginSubmitForm = function() {
        if ($scope.LoginForm.$valid) {
            angular.element(document.querySelector(".RegistrationPage .message_group")).html('<span class="wait"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>'+plswait+'</span>');
            $http({
                method: 'POST',
                url: '/'+loc+'/login',
                data: "email="+this.user.email+
                      "&password="+this.user.password,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}  //set the headers so angular passing info as form data (not request payload)
            }).then(function (result) {
                var parser = new DOMParser();
                var message_group = parser.parseFromString(result.data, 'text/html').querySelectorAll('.message_group');
                var error = angular.element(message_group).html();

                if(error === undefined){
                    document.location.replace('/'+loc+"/account");
                } else {
                    angular.element(document.querySelector(".RegistrationPage .message_group")).html(error);
                }
            }, function(result) {
                // not code 200
            });
        }
    };

}]);
