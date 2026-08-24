app.controller("ratingCtrl", ["$scope", "$http", function( $scope, $http ){
    "use strict";

    const data = document.getElementById("schedule-data").value;
    const rating = JSON.parse(data);

    $scope.users = rating;


    // Сотртировка по балам
    // =================================================================================================================
    $scope.sortType     = 'Balls'; // set the default sort type
    $scope.sortReverse  = true;    // set the default sort order
    $scope.searchFish   = '';      // set the default search/filter term

}]);