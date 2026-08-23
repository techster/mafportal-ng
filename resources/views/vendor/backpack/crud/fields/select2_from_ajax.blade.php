<!-- select2 from ajax -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <?php $entity_model = $crud->model; ?>
    <input type="hidden" name="{{ $field['name'] }}"  id="select2_ajax_{{ $field['name'] }}"
           @if(isset($field['value']))
           value="{{ $field['value'] }}"
           @else
           @if(old($field['name']))
           value="{{ old($field['name']) }}"
            @endif
            @endif
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_ajax'])
    >
    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

@php
    $connected_entity = new $field['model'];
    $connected_entity_key_name = $connected_entity->getKeyName();
@endphp

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include select2 css-->
        <link href="{{ asset('vendor/backpack/select2/select2.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('vendor/backpack/select2/select2-bootstrap-dick.css') }}" rel="stylesheet"
              type="text/css"/>
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        <script src="{{ asset('vendor/backpack/select2/select2.js') }}"></script>
    @endpush

@endif

<!-- include field specific select2 js-->
@push('crud_fields_scripts')
    <script>
        jQuery(document).ready(function ($) {
            // trigger select2 for each untriggered select2 box
            $("#select2_ajax_prima_nota").on('change', function() {
                if($("#select2_ajax_prima_nota").val() == ''){
                    $("#select_prima").hide();
                }else {
                    $("#select_prima").show();
                }
            })

            $("#select2_ajax_{{ $field['name'] }}").each(function (i, obj) {
                if (!$(obj).data("select2")) {
                    $(obj).select2({
                        placeholder: "{{ $field['placeholder'] }}",
                        minimumInputLength: 1,
                        multiple: "multiple",
                        maximumSelectionSize: 1,
                        ajax: {
                            url: "{{ $field['data_source'] }}",
                            dataType: 'json',
                            quietMillis: 250,
                            data: function (term, page) {
                                return {
                                    q: term, // search term
                                    page: page
                                };
                            },
                            results: function (data, params) {
                                params.page = params.page || 1;

                                var result = {
                                    results: $.map(data.data, function (item) {
                                        textField = "{{ $field['attribute'] }}";
                                        textField2 = "{{isset($field['attribute2'])?$field['attribute2']:''}}";
                                        textField3 = "{{isset($field['attribute3'])?$field['attribute3']:''}}";
                                        return {
                                            text: item[textField2] + (item[textField] ? ' ' + item[textField] : '') + (item[textField3] ? ' (' + item[textField3] + ')' : ''),
                                            id: item["{{ $connected_entity_key_name }}"]
                                        }
                                    }),
                                    more: data.current_page < data.last_page
                                };

                                return result;
                            },
                            cache: true
                        },
                        initSelection: function (element, callback) {
                            $.ajax("{{ $field['data_source'] }}" + '/' + element[0].value, {
                                dataType: "json"
                            }).done(function (data) {
                                textField = "{{ $field['attribute'] }}";
                                textField2 = "{{isset($field['attribute2'])?$field['attribute2']:''}}";
                                textField3 = "{{isset($field['attribute3'])?$field['attribute3']:''}}";
                                callback({
                                    text: data[textField2] + (data[textField] ? ' ' + data[textField] : '') + (data[textField3] ? ' (' + data[textField3] + ')' : ''),
                                    id: data["{{ $connected_entity_key_name }}"]
                                });
                            });
                        },
                    });
                }
            });

        });
    </script>

    @if(isset($fields['prima_nota']) && !isset($fields['prima_nota']['value']))
        <script type="text/javascript">
            $("#select_prima").hide();
        </script>
    @endif
@endpush





