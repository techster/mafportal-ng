<?php
$color = isset ($color) ? $color :  '#000';
$class = isset ($class) ? $class :  [];
$links = isset ($links) ? $links :  $links = ['Home' => route('home'), 'Test' => ''];
?>

<Section class="Breadcrumb @foreach($class as $className) {{ $className }} @endforeach">
    <div class="container">
        <ul>
            @foreach ($links as $name => $link)
                <li class="act">
                    <?php if($link){ ?><a href="{{ $link }}" style="color: {{ $color }};">{{ $name }}</a><?php } ?>
                    <?php if(!$link){ ?><span style="color: {{ $color }};">{{ $name }}</span><?php } ?>
                </li>
            @endforeach
        </ul>
    </div>
</Section>
