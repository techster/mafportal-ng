app.controller("gallery_archiveCtrl", ["$scope", function( $scope ){
    "use strict";

    $scope.visible = true;
    // ===================================================
    $scope.photo = function () {
        $scope.visible = true;
    };

    $scope.video = function () {
        $scope.visible = false;
    };

    lightGallery(document.getElementById('gallery-video-content'), {
        loadYoutubeThumbnail: true,
        youtubeThumbSize: 'mqdefault',
        thumbnail: true,
    });

}]);



