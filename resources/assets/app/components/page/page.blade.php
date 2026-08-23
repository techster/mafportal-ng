<?php
$content = isset($content) ? $content : '';
?>

<section class="GamePage">
    <div class="container">
        <!--[ CONTENT ]-->
        @if($content)
            <div class="contWr">
                {!! \App\Helpers::relativeLinks($content) !!}
            </div>
        @endif
    </div>
</section>