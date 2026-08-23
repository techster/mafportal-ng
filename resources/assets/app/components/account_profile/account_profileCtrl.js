app.controller("AccountCtrl", ["$scope", "$http", "$filter", function( $scope, $http, $filter){
    "use strict";

    $scope.open = function() {
        $scope.popup.opened = true;
        console.log($scope.user.date);
    };

    $scope.popup = {
        opened: false
    };


    var loc = document.getElementById("global_loc").innerText;


    $scope.RegistSubmitForm = function() {
        if ($scope.RegistForm.$valid) {
            $http({
                method: 'POST',
                url: '/'+loc+'/account/edit_account',
                data: "name="+this.user.name+
                      "&email="+this.user.email+
                      "&last_name="+this.user.last_name+
                      "&nickname="+this.user.nickname+
                      "&date="+$filter('date')(this.user.date, "yyyy-MM-dd")+
                      "&password="+this.user.password+
                      "&password_confirmation=" + this.user.password_confirmation,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}  //set the headers so angular passing info as form data (not request payload)
            }).then(function (data) {
                if (data.status == "200") { //success comes from the return json object
                    document.location.replace('/'+loc+"/account");
                } else {

                }
            });
        }
    };
}]);