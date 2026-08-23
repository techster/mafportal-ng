app.controller("SinglePhotoCtrl", ["$scope", function($scope){
    "use strict";

    lightGallery(document.getElementById('Gallery'), {
        loadYoutubeThumbnail: true,
        youtubeThumbSize: 'mqdefault',
        thumbnail: true,
    });


}]);