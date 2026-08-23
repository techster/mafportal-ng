app.controller("MobMenuCtrl", ["$scope", function( $scope ){
    "use strict";

    $scope.ShowId = function(event)
    {
        if ($('#drop-'+event.target.id).hasClass( "hidden" )) {
            $('#drop-'+event.target.id).removeClass( "hidden" );
            $('#'+event.target.id).html('&#9650');
        }
        else {
            $('#drop-'+event.target.id).addClass( "hidden" );
            $('#'+event.target.id).html('&#9660');
        }
    };

    $scope.ShowId_unlink = function(event)
    {
        if ($('#drop-'+event.target.id).hasClass( "hidden" )) {
            $('#drop-'+event.target.id).removeClass( "hidden" );
            $('#'+event.target.id).html(event.target.name+' &#9650');
        }
        else {
            $('#drop-'+event.target.id).addClass( "hidden" );
            $('#'+event.target.id).html(event.target.name+' &#9660');
        }
    };

    var menu = document.getElementById('menu-toggle'),
        nav_wrp = document.getElementById('nav-wrp'),
        body = document.getElementById('body'),
        toggled = false;

    menu.addEventListener( 'click', function() {
        if ( !toggled ) {
            this.className += " toggled";
            toggled = true;
            nav_wrp.style.right = "0";
            body.className += " openMenu";

        } else {
            this.className = this.className.replace(/\b\stoggled\b/, "");
            toggled = false;
            nav_wrp.style.right = "-100%";
            body.className = body.className.replace(/\b\sopenMenu\b/, "");
        }
    }, false );



    $('body').click(function(evt){
        if ($("#body").hasClass("openMenu")) {
            if(evt.target.id == "nav-wrp" && evt.target.id == "menu-toggle")
                return;
            if($(evt.target).closest('#nav-wrp').length)
                return;
            if($(evt.target).closest('#menu-toggle').length)
                return;

            menu.className = menu.className.replace(/\b\stoggled\b/, "");
            toggled = false;
            nav_wrp.style.right = "-100%";
            body.className = body.className.replace(/\b\sopenMenu\b/, "");
        }
    });

}]);