<!-- select2 -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <?php $entity_model = $crud->getModel(); ?>

    <div class="row">

        <div class="col-sm-4">
            <div class="checkbox">
                <label>
                    <input class="js-all" type="checkbox" name="all" value="all"> All
                </label>
            </div>
        </div>

        @foreach ($field['model']::all() as $connected_entity_entry)
            <div class="col-sm-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"
                               name="{{ $field['name'] }}[]"
                               value="{{ $connected_entity_entry->id }}"

                               @if( ( old( $field["name"] ) && in_array($connected_entity_entry->id, old( $field["name"])) ) || (isset($field['value']) && in_array($connected_entity_entry->id, $field['value']->pluck('id', 'id')->toArray())))
                               checked="checked"
                                @endif > {!! $connected_entity_entry->{$field['attribute']} !!}
                    </label>
                </div>
            </div>
        @endforeach
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif


    {{-- Denis --}}
    @push('crud_fields_scripts')
        <script>
            jQuery(document).ready(function ($) {
                var all = $(".js-all");
                var all_checkbox = all.parents('.row').find('.checkbox input').not(all);
                var select_checkbox = all.parents('.row').find('.checkbox input:checked').not(all);
                check_if_all();

                function check_if_all() {
                    var all_checkbox = all.parents('.row').find('.checkbox input').not(all);
                    var select_checkbox = all.parents('.row').find('.checkbox input:checked').not(all);

                    if (all_checkbox.length == select_checkbox.length) {
                        all.prop('checked', true);
                    } else {
                        all.prop('checked', false);
                    }
                }

                jQuery(".js-all").change(function ($) {
                    if (all.prop('checked')) {
                        all_checkbox.prop('checked', true);
                    } else {
                        all_checkbox.prop('checked', false);
                    }
                });

                jQuery(all_checkbox).change(function ($) {
                    check_if_all();
                });

            });
        </script>
    @endpush
</div>
