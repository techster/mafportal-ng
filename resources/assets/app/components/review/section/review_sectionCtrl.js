app.controller('review_sectionCtrl', ['$scope', "$http", function($scope, $http) {
    "use strict";

    $scope.myInterval = 5000;
    $scope.noWrapSlides = false;
    $scope.active = 0;
    $scope.sliderImages = [
        {
            src:  './build/img/maaw.jpg',
            txt:  'Frank Costello-1',
            txt1: '1 Guillaume studied materials in his undergraduate studies but needed an extra boost to help him be competitive enough to pursue his passion further at the Doctoral Level.',
            txt2: '1 A&J immediately began leveraging its academic contacts to help Guillaume have prestigious attachments to research groups at several universities around the world, also matching him to potential supervisors that worked in fields he was specifically interested in.',
        },
        {
            src:  'http://elitefon.ru/images/201211/elitefon.ru_17856.jpg',
            txt:  'Frank Costello-2',
            txt1: '2 Guillaume studied materials in his undergraduate studies but needed an extra boost to help him be competitive enough to pursue his passion further at the Doctoral Level.',
            txt2: '2 A&J immediately began leveraging its academic contacts to help Guillaume have prestigious attachments to research groups at several universities around the world, also matching him to potential supervisors that worked in fields he was specifically interested in.',

        },
        {
            src:  'https://img3.goodfon.ru/wallpaper/big/5/80/alkogol-konyak-bokal-sigara.jpg',
            txt:  'Frank Costello-3',
            txt1: '3Guillaume studied materials in his undergraduate studies but needed an extra boost to help him be competitive enough to pursue his passion further at the Doctoral Level.',
            txt2: '3A&J immediately began leveraging its academic contacts to help Guillaume have prestigious attachments to research groups at several universities around the world, also matching him to potential supervisors that worked in fields he was specifically interested in.',

        }
    ];


}]);