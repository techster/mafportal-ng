<?php
$page  = isset($page)  ? $page  : "";
$class  = isset($class)  ? $class  : ['p-t-50', 'm-b-120'];
$events = isset($events) ? $events : [];

$sort_events = [];
foreach($events as $key => $event){
    $dt = new DateTime($event->created_at);
    $sort_events[$dt->format('Y-m-d')][] = $event;
}
?>

@if(count($events))
    <script>
        slides = [
            @foreach($sort_events as $key_event_date => $event_date)
                {
                    "date": "{{$key_event_date}}",
                    "events": [
                        @foreach($event_date as $key_event => $event)
                        {
                            "title": "{{ \Illuminate\Support\Str::limit($event->title, 33,'...') }}",
                            @if(!isset($event->type) || $event->type == 'event')
                                @if(isset($event->clubs[0]))
                                "link": "{{ route('club_single_events', [$event->clubs[0]->slug, $event->slug]) }}",
                                @endif
                            @else
                                "link": "{{ route('single_tournaments', [$event->slug]) }}",
                            @endif
                            <?php $description = preg_replace( "/\r|\n/", " ", strip_tags($event->description) ); ?>
                            "description": "{{ \Illuminate\Support\Str::words($description, 14,'...')  }}",
                            "time": "{{ Carbon\Carbon::parse($event->created_at)->format('H:i') }}",
                        },
                        @endforeach
                    ]
                },
            @endforeach
        ];
    </script>


    <section class="EventBox @foreach($class as $className) {{ $className }} @endforeach" ng-controller="eventSectionCtrl">
        <div class="line"></div>
        <div class="eventWr">
            <carousel></carousel>
        </div>
    </section>
@elseif($page != "home")
    @include('no_access/no_access', ['text' => trans('clubs.no_events')])
@endif
