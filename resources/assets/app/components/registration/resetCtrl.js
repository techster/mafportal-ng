app.controller("ResetCtrl", ["$scope", '$http', function( $scope, $http){
    "use strict";

    console.log("ResetCtrl");
    var loc = document.getElementById("global_loc").innerText;
    var plswait = document.getElementById("global_plswait").innerText;
    $scope.ResetSubmitForm = function() {
        if ($scope.ResetForm.$valid) {
            angular.element(document.querySelector(".RegistrationPage .message_group")).html('<span class="wait"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>'+plswait+'</span>');
            $http({
                method: 'POST',
                url: '/'+loc+'/password/reset',
                data: "email="+this.user.email+
                      "&password="+this.user.password+
                      "&password_confirmation="+this.user.password_confirmation+
                      "&token="+this.ResetForm.token.$$attr.value,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                console.log(result);

                var parser = new DOMParser();
                var message_group = parser.parseFromString(result.data, 'text/html').querySelectorAll('.message_group');
                var error = angular.element(message_group).html();
                if(error === undefined){
                    document.location.replace('/'+loc+"/account");
                } else {
                    angular.element(document.querySelector(".RegistrationPage .message_group")).html(error);
                }

            }, function(result) {
                console.log(result);
                if(result.status == '422'){
                    angular.element(document.querySelector(".RegistrationPage .message_group")).html('');
                    for (var item in result.data) {
                        angular.element(document.querySelector(".RegistrationPage .message_group")).append('<span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+result.data[item][0]+'</span>');
                    }
                }
            });
        }
    };
}]);
