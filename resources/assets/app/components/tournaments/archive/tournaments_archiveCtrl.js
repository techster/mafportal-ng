app.controller("tournaments_archiveCtrl", ["$scope", function( $scope ){
    "use strict";

    $scope.selectedYear = "all";

    $scope.com = function () {
        $scope.visible = true;
    };

    $scope.vip = function () {
        $scope.visible = false;
    };

}]);