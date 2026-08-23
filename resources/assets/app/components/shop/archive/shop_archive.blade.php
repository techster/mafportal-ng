<section class="Shop" ng-controller="ShopCtrl">
    <div class="container">
        <div class="contWr">
            @if($product)
                <ul class="ProductList">
                    @foreach($product as $prod)
                        <li class="item">
                            <div class="pic" style="background-image: url({{'/'.$prod->image}});">
                                <img src="{{URL::to('/build/img/1_1.gif')}}" alt="pic">
                            </div>
                            <a href="#" class="item_title">{{$prod->title}}</a>
                            <div class="desc">{{$prod->description}}</div>
                            <div class="btnWr">
                                <span class="cena">${{$prod->price}}</span>
                                <a ng-click="OpenShopModal($event, '{{$prod->id}}', '{{csrf_token()}}')" class="buy" href="{{route("add_to_cart")}}">{{ trans('balance.buy') }}</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</section>

<section style="text-align:center; padding:50px; background:#efeeee;">
	<p class="container" style="font-size:15px;"> For all MAFIA (the party game) fans who need an app for the Host of the game, this is the one and only solution in the App Store. This app includes a timer, it integrates your music library, and has a marker for citizens, mafia, don, and the sheriff. The game is similar to Werewolf. </p>
	<div style="margin-top:20px;">
        <a href="https://apps.apple.com/pk/app/mafia-host/id860501682"><img src="{{URL::to('/uploads/appstore1.png')}}" width="200px" /></a>
	</div>	
</section>




