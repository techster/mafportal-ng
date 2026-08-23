<section class="ModalBox" ng-controller="ModalCtrl">
    <div class="modal" @yield('ctrl') ng-cloak>

        <div class="modal-guts">
            <div class="title">
                <div ng-click="closeThisDialog()" class="close_button"></div>

                @yield('title')

            </div>
        </div>

        <div class="wrapMadal">

            @yield('content')

        </div>

    </div>
</section>