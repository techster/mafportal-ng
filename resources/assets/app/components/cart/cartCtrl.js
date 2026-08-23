app.controller("rating3Ctrl", ["$scope", "$http", function( $scope, $http ){
    "use strict";

    const data = document.getElementById("data").value;
    const rating = JSON.parse(data);

    $scope.items = rating.items;
    $scope.loader = false;

    var loc = document.getElementById("global_loc").innerText;

    // Удаление елемента
    $scope.RemoveCartItem = function ($event, $id, token) {
        if ($event.preventDefault) {$event.preventDefault();} else {$event.returnValue = false;}
        var elementPos = $scope.items.map(function(x) {return x.id; }).indexOf($id);

        $http({
            method: 'POST',
            url: '/'+loc+"/shop/remove_from_cart",
            data: JSON.stringify({"id":$id, "csrf-token":token})
        })
        .then(function (success) {
            $scope.items.splice(elementPos, 1);
        }, function (error) {
            // errorCallback(error.data);
        });
    };

    // Изменение количества
    $scope.ChangeCartItem = function ($event, $id, token, $qty) {
        $http({
            method: 'POST',
            url: '/'+loc+"/shop/change_qty_in_cart",
            data: JSON.stringify({"id":$id, "qty":$qty, "csrf-token":token})
        })
        .then(function (success) {
            //
        }, function (error) {
            // errorCallback(error.data);
        });
    };

    // Расчет общей суммы
    $scope.sum = function(items, prop, prop2){
        return items.reduce( function(a, b){
            return a + (b[prop] * b[prop2]);
        }, 0);
    };

    //redirect to login
    $('#redirect_login').click(function () {
        window.location.replace('/'+loc+"/register");
    });


    //Email validation
    $scope.eml_add = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    // Отправить заказ

    $('#click_submit').click(function() {
        var price = $('#price_value').text();
        if(price == '$0') {
            $( "#no_product_error" ).css("display", "initial");
        } else {

            $scope.send_order = function(shipping,cart, card, token) {
                $scope.loader = true;
                $scope.card = card;
                $http({
                    method: 'POST',
                    url: '/'+loc+"/shop/send_order",
                    data: JSON.stringify({"shipping":shipping, "cart":cart, "card":card, "csrf-token":token})
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

        }
    });





    // Сортировка по балам
    // =================================================================================================================
    $scope.sortType     = 'Balls'; // set the default sort type
    $scope.sortReverse  = true;    // set the default sort order
    $scope.searchFish   = '';      // set the default search/filter term

}]);