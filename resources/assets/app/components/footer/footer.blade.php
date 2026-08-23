</div>{{--[ END CONTENT ]--}}
    <footer class="footer">
        <!--[ CONTACTS ]-->
        <div class="contactsWr">
            <div class="container">
                <div class="row">

                    @if(isset($footer_contacts) && $footer_contacts->phones)
                        <!--[ TEL ]-->
                        <div class="col-md-10 col-sm-12">
                            @if($footer_contacts->phones)
                                <div class="telephone">
                                    <p>{{ trans('footer.telephone') }}</p>
                                    <ul>
                                        @foreach(json_decode($footer_contacts->phones) as $key => $phone)
                                            <li>
                                                <strong>
                                                    {{App::getLocale() == 'ru' && $phone->country_ru ? $phone->country_ru : $phone->country}}:
                                                </strong>
                                                <span>{{$phone->phone}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif


                    <!--[ ICON ]-->
                    <div class="col-md-2 hidden-md-down">
                        <div class="socialIcon">
                            <ul>
                                @if(isset($footer_contacts) && $footer_contacts->facebook)<li><a href="{{$footer_contacts->facebook}}"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>@endif
                                @if(isset($footer_contacts) && $footer_contacts->instagram)<li><a href="{{$footer_contacts->instagram}}"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>@endif
                                @if(isset($footer_contacts) && $footer_contacts->twitter)<li><a href="{{$footer_contacts->twitter}}"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>@endif
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="line"></div>
            </div>
        </div>
        <!--[ COPYRIGHT ]-->
        <div class="copyrightWr">
            <div class="container">
                <p class="desktop">
                    {{ trans('footer.copyright', ['date' => date('Y')]) }}

                    <!--[ E-mail ]-->
                @if(isset($footer_contacts) && $footer_contacts->email)
                    @if($footer_contacts->email)

                            <strong>E-mail:</strong>&#160;
                            <a href="mailto:{{$footer_contacts->email}}">{{$footer_contacts->email}}</a>
                        @endif
                        @endif
                </p>
                <p class="mobile">
                    {{ trans('footer.copyright_mobile', ['date' => date('Y')]) }}
                </p>
            </div>
        </div>
    </footer>
</div>{{--[END WRAPPER]--}}

<style>
    .Rating_table th {
        padding: 15px 10px !important;
    }
</style>
