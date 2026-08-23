<?php
$text = isset($text) ? $text : 'TEXT';
?>

<section class="no_access">
    <div class="sms text-red">
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
        {{$text}}
    </div>
</section>
