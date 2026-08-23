app.controller("ShopModalCtrl", ["$scope", function( $scope ){
    "use strict";

    // console.log("ShopModalCtrl");
    $scope.submitForm = function() {
        if ($scope.RegistForm.$valid) {
            alert('Send form');
        }
    };

}]);