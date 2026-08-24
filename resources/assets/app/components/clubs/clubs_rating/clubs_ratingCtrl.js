app.controller("rating2Ctrl", ["$scope", "$http", function( $scope, $http ){
    "use strict";

    const data = document.getElementById("rating-data").value;
    const rating = JSON.parse(data);
    $scope.visible = false;
    $scope.users = rating.users;

    $scope.general = function () {

        $scope.visible = false;
    };

    $scope.main = function () {
        // console.log("dsadfsdfsa");
        $scope.visible = true;
    };

        //date current
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10) {dd = '0'+dd}
        if(mm<10) {mm = '0'+mm}
        today = yyyy + '-' + mm + '-' + dd;

        // active date option
        $("#select_season > option").each(function() {
            if ($(this).attr('name') >= today && $(this).attr('title') <= today) {
                $(this).addClass('actual_class');
                var text = $(this).text();
                $(this).text(text.replace(text, text+' (active)'));
            }
        });

        if(window.location.href.indexOf("?") > -1){
            var length = window.location.href.indexOf("=")+ 1;
            var myString = window.location.href;
            var stringLength = myString.length;
            var final_length = stringLength - length;
            var lastChar = myString.slice(-final_length);
            $('#select_season').val(lastChar);
        }


        // filtering rating table
        $('#select_season').on('change', function() {
            var main_url = window.location.href;
            if (this.value == 'zero') {
                if(main_url.indexOf("?")===-1){
                    window.location.replace(main_url);
                } else {
                    var url = main_url.indexOf('?');
                    var final = main_url.slice(url) ;
                    var final_url = main_url.replace(final, '');
                    window.location.replace(final_url);
                }
            } else {
                if(main_url.indexOf("?")===-1){
                    window.location.replace(main_url + "?season=" + this.value);
                } else {
                    var urll = main_url.indexOf('?');
                    var finall = main_url.slice(urll) ;
                    var final_urll = main_url.replace(finall, '');
                    window.location.replace(final_urll + "?season=" + this.value);
                }
            }



        });
		

    // $http.get('/users.json').then(function (data, status, headers, config) {
    //     $scope.users = data.data.users;
    //     // console.log($scope.users);
    // });


    // Сотртировка по балам
    // =================================================================================================================
    $scope.sortType     = ['Balls', 'BP', 'BM']; // set the default sort type
    $scope.sortReverse  = true;    // set the default sort order
    $scope.searchFish   = '';      // set the default search/filter term

}]);