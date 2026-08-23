<!-- select -->

<div @include('crud::inc.field_wrapper_attributes') >

    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <?php $entity_model = $crud->model; ?>
    <select
            name="{{ $field['name'] }}"
            @include('crud::inc.field_attributes')
    >
        @if ($entity_model::isColumnNullable($field['name']))
            <option value="">-</option>
        @endif
        @if (isset($field['model']))
            @foreach ($field['model']::all() as $connected_entity_entry)

                <option value="{{ $connected_entity_entry->getKey() }}"
                        @if ( ( old($field['name']) && old($field['name']) == $connected_entity_entry->getKey() ) || (!old($field['name']) && isset($field['value']) && $connected_entity_entry->getKey()==$field['value']))
                            selected
                        @elseif(!isset($field['value']) && $connected_entity_entry->getKey() == 16 && $field['name'] == 'table_ratings_id')
                            selected
                        @endif
                >{{ $connected_entity_entry->{$field['attribute']} }}{{isset($field['attribute2']) && $connected_entity_entry->{$field['attribute2']}?" ".$connected_entity_entry->{$field['attribute2']}:""}}{{isset($field['attribute3']) && $connected_entity_entry->{$field['attribute3']}?" (".$connected_entity_entry->{$field['attribute3']}.")":""}}</option>
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

</div>
