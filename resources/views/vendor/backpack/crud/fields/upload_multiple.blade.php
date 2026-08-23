<!-- upload multiple input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label><h3>{!! $field['label'] !!}</h3></label>
    @include('crud::inc.field_translatable_icon')

    {{-- Show the file name and a "Clear" button on EDIT form. --}}

    <div class="well well-sm file-preview-container"
         style="min-height: 200px; background-color: rgba(236,240,245,0.33); border: 2px dotted silver;">
        @if (isset($field['value']) && count($field['value']))
            @foreach($field['value'] as $key => $file_path)
                <div class="file-preview"
                     style=" border: 1px solid silver; background-image:url({{ asset("uploads/".$file_path) }}); background-size:cover; background-position: center center; width:131px; height:130px; margin:8px; display:inline-block;">
                    <a id="{{ $field['name'] }}_{{ $key }}_clear_button" href="#"
                       class="btn btn-default btn-xs pull-right file-clear-button" title="Clear file"
                       data-filename="{{ $file_path }}"><i class="fa fa-remove"></i></a>
                    <div class="clearfix"></div>
                </div>
            @endforeach
        @endif
    </div>

    {{--Show the file picker on CREATE form.--}}
    <input name="{{ $field['name'] }}[]" type="hidden" value="">

    <label style="  border: 1px solid #367fa9;
                    border-radius: 5px;
                    color: white;
                    background-color: #3c8dbc;
                    display: inline-block;
                    padding: 6px 12px;
                    cursor: pointer;">

        <input style="display: none;"
               type="file"
               id="{{ $field['name'] }}_file_input"
               name="{{ $field['name'] }}[]"
               value="@if (old($field['name'])) old($field['name']) @elseif (isset($field['default'])) $field['default'] @endif"
               @include('crud::inc.field_attributes')
               multiple
        >
        {{ trans('gallery.upload') }}
    </label>

    <div style="margin-top:20px;" id="old_name"></div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

@push('crud_fields_scripts')
    <!-- no scripts -->
    <script>

        // not send photos
        $("#saveActions button").click(function (e) {

            e.preventDefault();

            $("#photos_file_input").remove();

            $('.content form').submit();
        });
        $('#photos_file_input').change(function () {
            var files = $(this)[0].files;


            processfileupload(0, files);


        })

        function processfileupload(i, files) {

            showPageLoader();

            var form_data = new FormData();
            var galleryId = $('input[name="id"]').val();
            var file = files[i];
            var old_name = files[i].name;
            form_data.append('file', file);
            form_data.append('galleryId', galleryId);
            form_data.append("_token", "{{ csrf_token() }}");
            $.ajax({
                url: '<?php echo URL::to('/' . Config::get('app.locale') . '/gallery/uploadphoto/');?>', // point to server-side PHP script
                dataType: 'json',  // what to expect back from the PHP script, if anything
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (response) {

                    hidePageLoader();
                    if (response.status == 'success') {
                        var oldname_photo = '<p style="color: #0b7b00;">' + old_name + ' - Done</p>';
                        var key = response.photo_key;
                        var path = '<?php echo asset("uploads/");?>';
                        var newfile = response.filename;
                        var htmlphoto = '<div class="file-preview" style="background-image:url(' + path + '/' + newfile + ');' +
                            'background-size:cover; background-position: center center; width:131px; height:130px; margin:8px; display:inline-block;">' +
                            '<a id="photos_' + key + '_clear_button" href="#" class="btn btn-default btn-xs pull-right file-clear-button" title="Clear file" data-filename="' + newfile + '"><i class="fa fa-remove"></i></a><div class="clearfix"></div></div>';
                        $('.file-preview-container').append(htmlphoto);
                        $('#old_name').append(oldname_photo);
                    }
                    else {
                        var oldname_photo = '<p style="color: red; font-weight: bold;">' + old_name + ' - Failed</p>';
                        $('#old_name').append(oldname_photo);
                    }
                    i++;
                    if (i < files.length) {
                        processfileupload(i, files);
                    }
                }
            });
        }


        $(document).on('click', ".file-clear-button", function (e) {
            e.preventDefault();
            var container = $(this).parent().parent();
            var parent = $(this).parent();
            // remove the filename and button
            parent.remove();

            $("<input type='hidden' name='clear_{{ $field['name'] }}[]' value='" + $(this).data('filename') + "'>").insertAfter("#{{ $field['name'] }}_file_input");
        });

        $("#{{ $field['name'] }}_file_input").change(function () {
            console.log($(this).val());
            // remove the hidden input, so that the setXAttribute method is no longer triggered
            $(this).next("input[type=hidden]").remove();
        });
    </script>
@endpush
