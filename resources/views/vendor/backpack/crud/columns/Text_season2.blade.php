@if($entry->{$column['name']} >  date('Y-m-d'))
    <td style="color: red; font-weight: bold; font-size: 16px;">{{ str_limit(strip_tags($entry->{$column['name']}), 80, "[...]") }}</td>
@else <td>{{ str_limit(strip_tags($entry->{$column['name']}), 80, "[...]") }}</td>
@endif
