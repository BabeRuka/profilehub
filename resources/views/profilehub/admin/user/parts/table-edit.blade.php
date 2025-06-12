@php
$sequence = 1;
//$user_fields = $user_fields->where('field_id',$table[0]->field_id)->first();
@endphp
<div class="row">
@for ($td = 0; $td < $detailsdata_rows; $td++)
    <div class="row">
        <div class="col-1 text-center">{{ $td + 1 }}</div>
        <div class="col-10">
            <div class="row">
                @foreach ($son_fields as $table)
                    <div class="{{ $group_input }}">
                        <div class="card">
                            <div class="card-body text-left">
                                <div class="form-group">
                                    <label for="son_entry_{{$td + 1}}_{{ $table->field_id }}_{{ $table->son_id }}">{{ $table->translation }}</label>
                                    @php
                                        $user_entry = $userdetails->one_userfield_details_data($table->field_id, $table->son_id, $sequence, $user->id);
                                        $page_settings = $page_data->where('page_key', 'son_input_settings');
                                        $page_settings = $page_settings->where('page_module', $table->son_id);

                                        $son_input_settings = $page_settings->first() ? $page_settings->first()->page_data : null;
                                        $son_input_settings = $son_input_settings != null ? json_decode($son_input_settings) : null;
                                        $rownum = $td + 1;
                                    @endphp
                                    @if ($table->field_type == 'dropdown' || $table->field_type == 'json' || $table->field_type == 'array')
                                        @php
                                            $has_son_data = $son_data->where('son_id', $table->son_id);
                                        @endphp
                                        <div class="row">
                                            <div class="col-12">
                                                <select class="form-control" data-id="son_entry_{{$td + 1}}_{{ $table->field_id }}_{{ $table->son_id }}"
                                                    name="son_entry[{{ $table->field_id }}][{{ $table->son_id }}][]"
                                                    required>
                                                    <option value="">Select
                                                        {{ strtolower($table->translation) }}...
                                                    </option>
                                                    @foreach ($has_son_data as $dropdown)
                                                        <option value="{{ $dropdown->data_id }}"
                                                            {{ $user_entry == $dropdown->data_id ? 'selected="selected"' : '' }}>
                                                            {{ $dropdown->data_value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @elseif($table->field_type == 'date')
                                        <input type="text" data-date-format="yyyy-mm"
                                            class="form-control bootstrap_datepicker" value="{{ $user_entry }}"
                                            data-id="son_entry_{{$td + 1}}_{{ $table->field_id }}_{{ $table->son_id }}"
                                            name="son_entry[{{ $table->field_id }}][{{ $table->son_id }}][]"
                                            required>
                                    @elseif($table->field_type == 'number')
                                        @php
                                            $field_settings = json_decode($table->field_settings);
                                        @endphp
                                        <input type="number"
                                            min="{{ $field_settings != null ? $field_settings->start_range : '' }}"
                                            max="{{ $field_settings != null ? $field_settings->end_range : '' }}"
                                            class="form-control"placeholder="{{ $table->field_type }}"
                                            value="{{ $user_entry }}" data-id="son_entry_{{$td + 1}}_{{ $table->field_id }}_{{ $table->son_id }}"
                                            name="son_entry[{{ $table->field_id }}][{{ $table->son_id }}][]"
                                            required>
                                    @elseif($table->field_type == 'widget')
                                        @php
                                            $field_settings = json_decode($table->field_settings);
                                            //admin.widgets.forms.parts.country-list [dropdown_type] => state-dropdown  [dropdown_type] => country-dropdown
                                            $dropdown_id = 'son_entry_'.$rownum.'_'.$table->field_id.'_' . $table->field_id . '_' . $table->son_id . '';
                                            $dropdown_name = 'son_entry[' . $table->field_id . '][' . $table->son_id . '][]';
                                            $all_countries = $countries->where('country_id', $field_settings->dropdown_value);
                                            $required_settings = $son_input_settings != null ? ($son_input_settings[4]->required == 1 ? 'required' : '') : '';
                                            $selected_option = $user_entry; //$field_settings->dropdown_value;
                                        @endphp
                                        @if ($field_settings != null && $field_settings->input_type == 'dropdown')
                                            @if ($field_settings->dropdown_type == 'country-dropdown')
                                                @include('profilehub::admin.widgets.forms.parts.country-list')
                                            @endif
                                            @php
                                                $all_states = $states->where('country_id', $field_settings->dropdown_value);
                                            @endphp
                                            @if ($field_settings->dropdown_type == 'state-dropdown')
                                                @include('profilehub::admin.widgets.forms.parts.state-list')
                                            @endif
                                        @else
                                            <input type="text"
                                                class="form-control"placeholder="{{ $table->field_type }}"
                                                data-id="son_entry_{{$td + 1}}_{{ $table->field_id }}_{{ $table->son_id }}"
                                                name="son_entry[{{ $table->field_id }}][{{ $table->son_id }}][]"
                                                required>
                                        @endif
                                    @else
                                        <input type="text"
                                            class="form-control"placeholder="{{ $table->field_type }}"
                                            value="{{ $user_entry }}" data-id="son_entry_{{$td + 1}}_{{ $table->field_id }}_{{ $table->son_id }}"
                                            name="son_entry[{{ $table->field_id }}][{{ $table->son_id }}][]"
                                            {{ $son_input_settings != null ? ($son_input_settings[1]->required == 1 ? 'required' : '') : '' }}>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-1">
            <a href="javascript:void(0)"
                onclick="popDelTable({{ $table->field_id }},{{ $sequence }},'{{ $field->translation }}')"
                data-toggle="modal" data-target="#delTableModal"><i class="fa fa-trash text-danger"></i></a>
        </div>
        <hr />
    </div>
    @php
        $sequence++;
    @endphp
@endfor
</div>
<div class="row dynamic-element pt-1">
    <div class="col-1 tablenum" data-tablerow="@php echo $sequence ; @endphp">@php echo $sequence ; @endphp</div>
    <div class="col-10">
        <div class="row">
            @foreach ($son_fields as $table)
                @php
                    $user_entry = $userdetails->one_userfield_details_data($table->field_id, $table->son_id, $sequence, $user->id);
                    $page_settings = $page_data->where('page_key', 'son_input_settings');
                    $page_settings = $page_settings->where('page_module', $table->son_id);

                    $son_input_settings = $page_settings->first() ? $page_settings->first()->page_data : null;
                    $son_input_settings = $son_input_settings != null ? json_decode($son_input_settings) : null;
                    $rownum = $td + 1;
                @endphp
                <div class="{{ $group_input }}">
                    <div class="card">
                        <div class="card-body text-left">
                            <div class="form-group">
                                <label for="son_entry_{{ $table->field_id }}_{{ $table->son_id }}">{{ $table->translation }}</label>
                                @if ($table->field_type == 'dropdown' || $table->field_type == 'json' || $table->field_type == 'array')
                                    @php
                                        $has_son_data = $son_data->where('son_id', $table->son_id);

                                    @endphp
                                    <div class="row">
                                        <div class="col-12">
                                            <select class="form-control" data-id="son_entry_{{$td + 1}}_{{ $table->field_id }}_{{ $table->son_id }}"
                                                name="son_entry[{{ $table->field_id }}][{{ $table->son_id }}][]"
                                                {{ $son_input_settings != null ? ($son_input_settings[2]->required == 1 ? 'required' : '') : '' }}>
                                                <option value="">Select
                                                    {{ strtolower($table->translation) }}...
                                                </option>
                                                @foreach ($has_son_data as $dropdown)
                                                    <option value="{{ $dropdown->data_id }}">
                                                        {{ $dropdown->data_value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @elseif($table->field_type == 'date')
                                    <input type="text" data-date-format="yyyy-mm"
                                        class="form-control bootstrap_datepicker" data-id="son_entry_{{$td + 1}}_{{ $table->field_id }}_{{ $table->son_id }}"
                                        name="son_entry[{{ $table->field_id }}][{{ $table->son_id }}][]"
                                        {{ $son_input_settings != null ? ($son_input_settings[2]->required == 1 ? 'required' : '') : '' }} >
                                @elseif($table->field_type == 'number')
                                    @php
                                        $field_settings = json_decode($table->field_settings);
                                    @endphp
                                    <input type="number"
                                        min="{{ $field_settings != null ? $field_settings->start_range : '' }}"
                                        max="{{ $field_settings != null ? $field_settings->end_range : '' }}"
                                        class="form-control" data-id="son_entry_{{$td + 1}}_{{ $table->field_id }}_{{ $table->son_id }}"
                                        name="son_entry[{{ $table->field_id }}][{{ $table->son_id }}][]"
                                        {{ $son_input_settings != null ? ($son_input_settings[1]->required == 1 ? 'required' : '') : '' }}>
                                @elseif($table->field_type == 'widget')
                                    @php
                                        $field_settings = json_decode($table->field_settings);

                                    @endphp
                                    @php
                                        $field_settings = json_decode($table->field_settings);
                                        $dropdown_id = 'son_entry_'.$rownum.'_' . $table->field_id . '_' . $table->son_id . '';
                                        $dropdown_name = 'son_entry[' . $table->field_id . '][' . $table->son_id . '][]';
                                        $all_countries = $countries->where('country_id', $field_settings->dropdown_value);
                                        $selected_option = $field_settings->dropdown_value;
                                        $required_settings = $son_input_settings != null ? ($son_input_settings[4]->required == 1 ? 'required' : '') : '';
                                    @endphp
                                    @if ($field_settings != null && $field_settings->input_type == 'dropdown')
                                        @if ($field_settings->dropdown_type == 'country-dropdown')
                                            @include('profilehub::admin.widgets.forms.parts.country-list')
                                        @endif
                                        @php
                                            $all_states = $states->where('country_id', $field_settings->dropdown_value);
                                            $selected_option = 0;
                                        @endphp
                                        @if ($field_settings->dropdown_type == 'state-dropdown')
                                            @include('profilehub::admin.widgets.forms.parts.state-list')
                                        @endif
                                    @else
                                        <input type="text"
                                            class="form-control"placeholder="{{ $table->field_type }}"
                                            data-id="son_entry_{{$td + 1}}_{{ $table->field_id }}_{{ $table->son_id }}"
                                            name="son_entry[{{ $table->field_id }}][{{ $table->son_id }}][]"
                                            {{ $son_input_settings != null ? ($son_input_settings[1]->required == 1 ? 'required' : '') : '' }} >
                                    @endif
                                @else
                                    <input type="text" class="form-control"placeholder="{{ $table->field_type }}"
                                        data-id="son_entry_{{$td + 1}}_{{ $table->field_id }}_{{ $table->son_id }}"
                                        name="son_entry[{{ $table->field_id }}][{{ $table->son_id }}][]"
                                        {{ $son_input_settings != null ? ($son_input_settings[1]->required == 1 ? 'required' : '') : '' }} >
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-1">
        <a href="javascript:void(0)"><i class="fa fa-plus clone-field mdi mdi-plus-circle-outline text-success"></i></a>
    </div>
    <hr />
</div>
<div class="cloned-data">
</div>
