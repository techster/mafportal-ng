app.controller("balanceCtrl", ["$scope", "$http", function( $scope, $http ){
    "use strict";

    $scope.loader = false;
    var loc = document.getElementById("global_loc").innerText;
    // Отправить заказ
    $scope.send_order = function(billing, card, token) {
        $scope.loader = true;
        $scope.card = card;
        $http({
            method: 'POST',
            url: '/'+loc+"/shop/send_order",
            data: JSON.stringify({"shipping":billing, "billing":billing, "cart":billing.amount, "card":card, "csrf-token":token})
        }).then(function (success) {
            if($scope.card=="paypal"){
                window.location.replace(success.data);
            }else{
                window.location.replace('/'+loc+"/shop/thank/");
                // $scope.loader = false;
                // angular.element(document.querySelector('.RatingCL')).remove();
                // angular.element(document.querySelector('.ContactPage')).remove();
                // angular.element(document.querySelector('.title_name')).html('Thanks for your order!');
            }
        }, function (error) {
            // errorCallback(error.data);
        });
    };




}]);