<td>
    <?php
    if ($entry->{$column['entity']}) {
        echo $entry->{$column['entity']}->{$column['attribute']} . " " . (isset($column['attribute2']) && $entry->{$column['entity']}->{$column['attribute2']} ? $entry->{$column['entity']}->{$column['attribute2']} : "") . (isset($column['attribute3']) && $entry->{$column['entity']}->{$column['attribute3']} ? " (" . $entry->{$column['entity']}->{$column['attribute3']} . ")" : "");
    }
    ?>
</td>
