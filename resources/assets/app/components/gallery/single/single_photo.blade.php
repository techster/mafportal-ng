<section class="SinlgePhoto m-t-80" ng-controller="SinglePhotoCtrl">
    <div class="container">
        <div class="title">{{$PhotoGallery->title}}</div>

        <div id="Gallery" class="Gallery row">
            @if($PhotoGallery->photos)
                @foreach($PhotoGallery->photos as $key => $gallery)
                    @if(isset($gallery) && $gallery)
                        <a class="col-xs-12 col-md-4 col-sm-6" href="{{ asset("uploads/".$gallery) }}">
                            <div class="help_overlay">
                                <img src="{{ asset("uploads/thumb/".$gallery) }}" alt="pic">
                                <div class="gi_overlay">
                                    <i class="fa fa-eye"></i>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            @endif
        </div>

    </div>
</section>

{{--https://github.com/blueimp/Gallery--}}