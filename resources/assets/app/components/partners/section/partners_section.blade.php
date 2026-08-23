@if(isset($partners))
    <section class="PartnersBox">
        <div class="container">
            <div class="partnersWr">
                <h1 class="title">{{ trans('partners.partners') }}</h1>

                @if($partners)
                    <script>
                        slides_parnters = [
                            @foreach($partners as $key => $partner)
                                {
                                    "images": "{{ $partner->logo }}",
                                    "url":    "{{ $partner->link }}",
                                    "title":  "{{ $partner->name }}"
                                },
                            @endforeach
                        ];
                    </script>
                @endif

                {{--[ init ]--}}
                <carousel2></carousel2>

            </div>
        </div>
    </section>
@endif
