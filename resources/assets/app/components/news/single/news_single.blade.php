<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
<section class="SinleNewsPage">
    <div class="container">
        <!--[ TITLE ]-->
        @if($news->title)
            <div class="NewsTitle">{{$news->title}}</div>
        @endif
        <!--[ CONTENT ]-->
        <div class="ContWr">
            <!--[ DESC ]-->
            <div class="descWr">
                @if($news->created_at)
                    <div class="date">{{$news->created_at->format('d M Y')}}</div>
                @endif

                @if($news->description)
                    <div class="text">{{strip_tags($news->description)}}</div>
                @endif
            </div>
            <!--[ PIC ]-->
            @if($news->image)
                <div class="pic" style="background-image: url({{ $news->image }});">
                    <img src="{{URL::to('/build/img/3_1.gif')}}">
                </div>
            @endif
            <!--[ TEXT ]-->
                <div class="MainCont">{!! $news->text !!}</div>
            @if( $news->slug == '17th-world-championship-in-yerevan_BK' || $news->slug == '1st-us-open-mafia-championship_BK' )
                <div class="row">
                
                    <form class="col-xs-12" id="contactForm" method="post" action="{{ route('tournaments.contactForm') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="tournament" value="{{ $news->title }}">
                        <div>
                            <input name="fname" type="text" class="contact col-xs-12"
                               placeholder="{{ App::getLocale() == 'ru' ? 'Твое имя' : 'Your First Name' }} *" required>
                        </div>
                        <div>
                            <input name="lname" type="text" class="contact col-xs-12"
                               placeholder="{{ App::getLocale() == 'ru' ? 'Ваша фамилия' : 'Your Last Name' }} *" required>
                        </div>
                        <div>
                            <input name="email" type="email" class="contact col-xs-12"
                               placeholder="{{ App::getLocale() == 'ru' ? 'Адрес электронной почты' : 'E-mail address' }} *" required>
                        </div>
                        <div>
                            <textarea name="message" class="contact col-xs-12"
                                  placeholder="{{ App::getLocale() == 'ru' ? 'Сообщение (необязательно)' : 'Message (optional)' }}" ></textarea>
                        </div>
                        <div class="col-xs-12 g-recaptcha" data-sitekey="6LfEJYMUAAAAAKJFeUTTM-e1y_HyG8pOumfiyodw"></div>
                        <input type="submit" id="submit" value="{{ App::getLocale() == 'ru' ? 'Отправить регистрацию' : 'Submit Registration' }}">
                    </form>
                </div>

            @endif
            <!--[ SHARE ]-->
            <div class="ShareWr">
                <span>Share:</span>
                <ul class="shareList">
                    <?php $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
                    <li><a href="https://www.facebook.com/sharer.php?u=<?php echo $url;?>" rel="nofollow" ><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="https://twitter.com/intent/tweet?url=<?php echo $url;?>&amp;text={{$news->title}}" rel="nofollow" ><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="https://plus.google.com/share?url=<?php echo $url;?>" rel="nofollow" ><i class="fa fa-google" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
        <!--[ PAGINATION ]-->
        <div class="PaginationPost">
            @if($prev_link)
                <a class="prev" href="{{ $prev_link }}"><div class="arrow prev"></div><span>{{trans('clubs.prev')}}</span></a>
            @endif

            @if($next_link)
                <a class="next" href="{{ $next_link }}"><div class="arrow next"></div><span<?=(App::getLocale() == 'ru'?' style="right:129px"':'')?>>{{trans('clubs.next')}}</span></a>
            @endif
        </div>
    </div>
    <script type="text/javascript">
        
        $(document).ready(function(){
            @if(session()->has('success'))
                successToast("{{ session()->get('success') }}");
            @endif
            @if ($errors->any())
                errorToast("{{ $errors->first() }}");
            @endif
            function successToast(msg) {
                $.toast({
                    heading: 'Success',
                    text: msg,
                    icon: 'success',
                    position : 'top-right',
                    hideAfter : 6000,
                    loader: true,        // Change it to false to disable loader
                    // loaderBg: '#9EC600'  // To change the background
                });
            }
            function errorToast(msg) {
                $.toast({
                    heading: 'Error',
                    text: msg,
                    icon: 'error',
                    position : 'top-right',
                    hideAfter : 6000,
                    loader: true,        // Change it to false to disable loader
                    // loaderBg: '#9EC600'  // To change the background
                });
            }
            $('#contactForm').validate({
                rules : {
                    'fname' : {
                        required : true
                    },
                    'lname' : {
                        required : true
                    },
                    'email' : {
                        required : true,
                        email : true
                    }

                }

            });
            $('#contactForm').on('submit', function(e) {
                if(grecaptcha.getResponse() == "") {
                    e.preventDefault();
                    alert("Captcha is required");
                } else {
                    $('#contactForm').submit();
                }
            });
        });
    </script>
</section>
