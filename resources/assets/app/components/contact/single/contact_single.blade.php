<section class="ContactPage" ng-controller="ContactCtrl">
    <div class="container">
        <!--[ CONTENT ]-->
        <div class="ContWr">
            @if($page->content||$page->content_rus)
                <div class="desc">{!! \App\Helpers::relativeLinks(App::getLocale()=='en'||!$page->content_rus?$page->content:$page->content_rus) !!}</div>
            @endif
            <!--[ LINE ]-->
            <div class="line"></div>
            <!--[ INFO ]-->
            <div class="infoWr">
                <!--[ FORM ]-->
                <div class="formWr">
                    <form name="ContForm" ng-submit="submitForm()" novalidate>
                        <div class="input-container" ng-class="{ 'has-error' : ContForm.name.$invalid && ContForm.name.$touched }">
                            <input type="text" name="name" ng-model="user.name" ng-required="true">
                            <label for="name">{{trans('contacts.name')}}*</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="ContForm.name.$invalid && ContForm.name.$touched" class="help-block">{{trans('contacts.name_required')}}</p>
                        </div>

                        <div class="input-container" ng-class="{ 'has-error' : ContForm.email.$invalid && ContForm.email.$touched }">
                            <input type="email" name="email" ng-model="user.email" ng-required="true">
                            <label for="email">{{trans('contacts.email')}}*</label>
                            <div class="bar"></div>
                            <p ng-cloak ng-show="ContForm.email.$invalid && ContForm.email.$touched" class="help-block">{{trans('contacts.valid_email')}}</p>
                        </div>

                        <div class="input-container" ng-class="{ 'has-error' : ContForm.cont.$invalid && ContForm.cont.$touched }">
                            <label class="t-area" type="text">{{trans('contacts.message')}}*</label>
                            <textarea type="text" name="cont" cols="30" rows="10" ng-model="user.cont" ng-required="true"></textarea>
                            <p ng-cloak ng-show="ContForm.cont.$invalid && ContForm.cont.$touched" class="help-block">{{trans('contacts.message_required')}}</p>
                        </div>

                        <div class="button-container">
                            <div class="loginBtn">
                                <button type="submit" ng-cloak ng-disabled="ContForm.$invalid">{{trans('contacts.send')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--[ TEL ]-->
                <div class="text">
                    <p class="text_title"><strong>{{trans('contacts.telephone')}}</strong></p>
                    @if($page->phones)
                        @foreach(json_decode($page->phones) as $key => $phone)
                            <p>
                                <strong>
                                    {{App::getLocale() == 'ru' && $phone->country_ru ? $phone->country_ru : $phone->country}}:
                                </strong>
                                {{$phone->phone}}
                            </p>
                        @endforeach
                    @endif
                    @if($page->email)
                        <p class="last"><strong>Email:</strong>{{$page->email}}</p>
                    @endif
                    <p class="text_title last"></p>
                    <ul class="socialIcon">
                        @if($page->facebook)<li><a href="{{$page->facebook}}"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>@endif
                        @if($page->instagram)<li><a href="{{$page->instagram}}"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>@endif
                        @if($page->twitter)<li><a href="{{$page->twitter}}"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>@endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
