<?php
$title = isset($title) ? $title : 'Title';
$class = isset($class) ? $class : [''];
?>

@if($title)
    <section class="Title @foreach($class as $className) {{ $className }} @endforeach">
        <div class="container">
            <div class="titleWr">
                <div class="left_line lineDef"></div>
                <h1 class="title_name">{{ $title }}</h1>
                <div class="right_line lineDef"></div>
            </div>
        </div>
    </section>
@endif