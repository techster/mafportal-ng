app.controller("ContactCtrl", ["$scope", "$http", function( $scope, $http ){
    "use strict";
    var loc = document.getElementById("global_loc").innerText;
    $scope.submitForm = function() {
        if ($scope.ContForm.$valid) {
            $http({
                method: 'POST',
                url: '/'+loc+'/contact',
                data: "name="+this.user.name+
                "&email="+this.user.email+
                "&cont="+this.user.cont,
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