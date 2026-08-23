<?php
    $data_season = \App\Models\Season::where('title', $entry->{$column['name']})->get();

    if ($data_season[0]->end >= date('Y-m-d') && $data_season[0]->start <= date('Y-m-d') ) {
        echo '<td style="color: red; font-weight: bold; font-size: 16px;">'.str_limit(strip_tags($entry->{$column['name']}), 80, "[...]").' (active)</td>';
    }
    else {
        echo '<td>'.str_limit(strip_tags($entry->{$column['name']}), 80, "[...]").'</td>';
    }
?>
