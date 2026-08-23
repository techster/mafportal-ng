app.controller("ShopCtrl", ["$scope", "ngDialog", "$http", function( $scope, ngDialog, $http ){
    "use strict";
    var loc = document.getElementById("global_loc").innerText;
    $scope.OpenShopModal = function ($event, id, token) {
        if ($event.preventDefault) {$event.preventDefault();} else {$event.returnValue = false;}

        var this_elem = angular.element($event.currentTarget);
        this_elem.css('opacity', '0.3');

        $http({
            method: 'POST',
            url: '/'+loc+"/shop/add_to_cart",
            data: JSON.stringify({"id":id, "csrf-token":token})
        })
        .then(function (success) {
            this_elem.css('opacity', '1');
            ngDialog.open({
                template: '/'+loc+'/shop-modal',
                className: 'ngdialog-theme-plain'
            });
            // console.log(success.data);
        }, function (error) {
            // errorCallback(error.data);
        });





    };

}]);