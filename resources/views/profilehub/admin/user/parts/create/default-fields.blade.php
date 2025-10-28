@php
$group_settings = $page_data->where('page_module', 'default');
$group_enabled = $group_settings->first() ? $group_settings->where('page_key', 'group_enabled') : null;
$genabled = $group_enabled != null && $group_enabled->first() ? ($group_enabled->first()->page_data > 0 ? 1 : 0) : 0;

$group_input = $group_settings->first() ? $group_settings->where('page_key', 'group_input') : null;
$group_input = $group_input != null && $group_input->first() ? $group_input->first()->page_data : null;

$group_layout = $page_data->first() ? $page_data->where('page_key', 'group_layout') : null;
$glayout = $group_layout != null && $group_layout->first() ? $group_layout->first()->page_data : '';
@endphp
<div class="mt-3 mb-3">
    <strong><i class="fa fa-user" aria-hidden="true"></i> Personal Info</strong>
    <hr />
    <div class="{{ $glayout == 'cards' ? 'card' : '' }}">
        <div class="{{ $glayout == 'cards' ? 'card-body' : '' }}">
            <div class="row">
                @foreach ($page_defaults as $default)
                    @php
                        $page_settings = $page_data->where('page_module', $default);
                        $input_enabled = $page_settings->first() ? $page_settings->where('page_key', 'page_input') : null;
                        $input_enabled = $input_enabled->first() ? ($input_enabled->first()->page_data > 0 ? 1 : 0) : 0;

                        $input_required = $page_settings->first() ? $page_settings->where('page_key', 'page_input_required') : null;
                        $input_required = $input_required->first() ? ($input_required->first()->page_data > 0 ? 'required' : '') : '';

                        $input_settings = $page_settings->first() ? $page_settings->where('page_key', 'page_input_settings') : null;
                        $input_settings = $input_settings->first() && $input_settings->first()->page_data ? json_decode($input_settings->first()->page_data) : null;
                        $input_type = $input_settings != null ? $input_settings->input : 'text';
                    @endphp
                    @if ($input_enabled > 0)
                        <div class="{{ $input_type == 'textarea' ? 'col-12' : $group_input }}">

                            <label class=""
                                for="{{ $default }}">{{ ucwords($UserFunctions->userprofile_lang($default)) }}
                            </label>
                            <div class="form-group">
                                <div class="form-line">
                                    @if ($default == 'name')

                                    @else
                                        @if ($input_type == 'textarea')
                                            <textarea type="text" id="{{ $default }}" name="{{ $default }}" class="form-control disable-autofill"
                                                placeholder="Enter your {{ $default }}..." {{ $input_required }}></textarea>
                                            @php
                                                echo '</div>';
                                            @endphp
                                        @elseif ($input_type == 'dropdown')
                                            <select type="text" id="{{ $default }}" name="{{ $default }}"
                                                class="form-control disable-autofill" placeholder="Enter your {{ $default }}..."
                                                {{ $input_required }}>

                                            </select>
                                        @elseif(in_array($input_type, $html_inputs))
                                            @if ($input_type == 'file')
                                                <input type="file" name="{{ $default }}" id="{{ $default }}"
                                                    data-show-loader="false" class="dropify"
                                                    data-default-file="{{ $profile_pic }}"
                                                    {{ $profile_pic == '' ? $input_required : '' }} />
                                            @elseif ($input_type == 'image')
                                                <input type="file" name="{{ $default }}" id="{{ $default }}"
                                                    data-show-loader="false" data-allowed-file-extensions="jpg png jpeg"
                                                    class="dropify" {{ $profile_pic == '' ? $input_required : '' }} />
                                            @elseif ($input_type == 'range')
                                                <input type="{{ $input_type }}" id="{{ $default }}"
                                                    name="{{ $default }}" value="" class="form-range disable-autofill"
                                                    {{ $input_required }} />
                                            @else
                                                <input type="{{ $input_type }}" id="{{ $default }}"
                                                    name="{{ $default }}" value="" class="form-control disable-autofill"
                                                    placeholder="Enter your {{ $default }}..."
                                                    {{ $input_required }} />
                                            @endif
                                        @elseif(in_array($input_type, $custom_inputs))
                                            <input type="{{ $input_type }}" id="{{ $default }}"
                                                name="{{ $default }}" value="" class="form-control disable-autofill"
                                                placeholder="Enter your {{ $default }}..." {{ $input_required }} />
                                        @else
                                            <input type="text" id="{{ $default }}" name="{{ $default }}"
                                                value="" class="form-control disable-autofill"
                                                placeholder="Enter your {{ $default }}..." {{ $input_required }} />
                                        @endif 
                                    @endif 
                                    <div id="invalid_feedback_{{ $default }}" class="invalid-feedback">
                                        {{ $default }} is required.
                                    </div>
                                    <div id="valid_feedback_{{ $default }}" class="valid-feedback">
                                        :-)
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                @endforeach
            </div>
        </div>
    </div>
