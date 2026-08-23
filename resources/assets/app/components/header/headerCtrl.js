app.controller("HeaderCtrl", ["$scope", "ngDialog", function( $scope, ngDialog ){
    "use strict";

    // console.log("HeaderCtrl");

    $scope.OpenModal = function (modal) {
        ngDialog.open({
            template: modal,
            className: 'ngdialog-theme-plain'
        });
    };

}]);