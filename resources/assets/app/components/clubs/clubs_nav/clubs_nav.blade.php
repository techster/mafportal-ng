<?php
$class_act = isset($class_act) ? $class_act : true;
$links = isset($links) ? $links :  $links = [];
?>

<nav class="ClubsNav">
    <div class="container" style="height: 100%;">
        <ul class="headList">
            @foreach ($links as $name => $link)
                <li class="{{ strpos($link, Request::path()) !== false ? 'act' : '' }}">
                    <a href="{{ $link }}">{{ $name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</nav>
