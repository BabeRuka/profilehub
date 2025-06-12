@foreach ($page_groups as $group)
    @php
        $all_groups = $userdetails->user_field(0, $group->group_id);
        $page_row = '';

        $group_settings = $all_page_data->where('page_module', $group->group_id);
        $group_enabled = $group_settings->first() ? $group_settings->where('page_key', 'group_enabled') : null;
        $genabled = $group_enabled != null && $group_enabled->first() ? ($group_enabled->first()->page_data > 0 ? 1 : 0) : 0;

        $group_settings = $all_page_data->where('page_module', 'input_layout');
        $group_layout = $group_settings->first() ? $group_settings->where('page_key', 'group_layout') : null;
        $glayout = $group_layout != null && $group_layout->first() ? $group_layout->first()->page_data : '';

        $group_settings = $all_page_data->where('page_module', 'cols');
        $group_input = $group_settings->first() ? $group_settings->where('page_key', 'group_layout') : null;
        $ginput = $group_input != null && $group_input->first() ? $group_input->first()->page_data : null;

        $group_input = $group_settings->first() ? $group_settings->where('page_key', 'group_input') : null;
        $group_input = $group_input != null && $group_input->first() ? $group_input->first()->page_data : null;
    @endphp
    <div class="row mb-3 card-group" id="sortable-grid">
        <div class="col-12">
            <p class="font-weight-bold"><i class="fa {{ $group->group_icon }}" aria-hidden="true"></i>
                {{ strtoupper($group->group_name) }} Group</p>
            <hr />
        </div>
        @php
            $num = 1;
        @endphp
        <div class="col-xl-4 col-md-6 col-xxl-3 mb-3 group_{{ $group->group_id }}">
            <div class="card h-100 bg-light {{ $genabled == 1 ? 'border-success' : 'border-secondary' }}">
                <div class="card-header">
                    <i class="fa"></i>
                    <small class="font-weight-bold">{{ strtoupper($group->group_name) }} Settings</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">

                            <div class="row">
                                <div class="col-1 center-middle-left">
                                    <span class="group_icon_{{ $group->group_id }}"><i
                                            class="fa {{ $genabled == 1 ? 'fa-check-circle text-success' : 'fa-check-circle text-danger text-muted' }}"></i></span>
                                    <input type="hidden" value="{{ $genabled }}"
                                        id="group_enabled_{{ $group->group_id }}" />
                                </div>
                                <div class="col-10 center-middle-left">
                                    <select name="group_enabled[{{ $group->group_id }}]"
                                        class="form-control form-input-sm group_enabled_input_{{ $group->group_id }}">
                                        <option value="1" {{ $genabled == 1 ? 'selected="selected"' : '' }}>
                                            Enabled
                                        </option>
                                        <option value="0" {{ $genabled == 0 ? 'selected="selected"' : '' }}>
                                            Disabled
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-1 center-middle-left">
                                    <span class="group_icon_{{ $group->group_id }}"><i
                                            class="fa {{ $genabled == 1 ? 'fa-check-circle text-success' : 'fa-check-circle text-danger text-muted' }}"></i></span>
                                    <input type="hidden" value="{{ $genabled }}"
                                        id="group_enabled_{{ $group->group_id }}" />
                                </div>
                                <div class="col-10 center-middle-left">
                                    <select name="group_input[{{ $group->group_id }}]" class="form-control form-input-sm ">
                                        <option value="col-xl-12 col-lg-12" <?php
                                        if ($group_input) {
                                            echo $group_input == 'col-xl-12 col-lg-12' ? 'selected="selected"' : '';
                                        }
                                        ?>>
                                            One input field per row</option>
                                        <option value="col-xl-6 col-lg-6 col-md-6 col-sm-12" <?php
                                        if ($group_input) {
                                            echo $group_input == 'col-xl-6 col-lg-6 col-md-6 col-sm-12' ? 'selected="selected"' : '';
                                        }
                                        ?>>
                                            Two input fields per row</option>
                                        <option value="col-xl-4 col-lg-4 col-md-4 col-sm-4" <?php
                                        if ($group_input) {
                                            echo $group_input == 'col-xl-4 col-lg-4 col-md-4 col-sm-4' ? 'selected="selected"' : '';
                                        }
                                        ?>>
                                            Three input fields per row</option>
                                        <option value="col-xl-3 col-lg-3 col-md-3 col-sm-3" <?php
                                        if ($group_input) {
                                            echo $group_input == 'col-xl-3 col-lg-3 col-md-3 col-sm-3' ? 'selected="selected"' : '';
                                        }
                                        ?>>
                                            Four input fields per row</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        @foreach ($all_groups as $field)
            @php
                $has_page_input = $page_input->where('page_module', $field->field_id);
                $pinput_required = $page_input_required->where('page_module', $field->field_id);
            @endphp
            <div
                class="{{ $field->type_field == 'table' ? 'col-12 mb-3' : 'col-xl-4 col-md-6 col-xxl-3 col-xs-12 col-sm-12 mb-3' }}">
                <div class="row">

                    <div class="col-12">
                        <div class="card {{ $field->type_field == 'table' ? '' : 'bg-light' }}">
                            <div class="card-header">
                                <i class="fa"></i>
                                <small class="font-weight-bold">{{ ucwords($field->translation) }}</small>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    @if ($field->type_field == 'table')
                                        @php
                                            $field_sons = $all_field_sons->where('field_id', $field->field_id);

                                        @endphp
                                        <input name="page_input_sequence[{{ $field->field_id }}]" type="hidden"
                                            value="{{ $num }}" />
                                        @foreach ($field_sons as $table)
                                            <div class="col-xl-4 col-md-6 col-xxl-3 col-sm-12 col-xs-12">
                                                <div class="card  bg-light mb-3">
                                                    <div class="card-header">
                                                        <i class="fa"></i>
                                                        <small
                                                            class="font-weight-bold">{{ ucwords($table->translation) }}</small>
                                                    </div>
                                                    <div class="card-body text-left">
                                                        <div class="form-group input-group-sm">
                                                            @php
                                                                $has_son_data = $son_data->where('son_id', $table->son_id);
                                                                $input_settings = $all_page_data->where('page_key', 'son_input_settings');
                                                                $son_input_settings = $input_settings->first() ? $input_settings->where('page_module', $table->son_id) : [];
                                                                $son_page_data = $son_input_settings != null && $son_input_settings->first() ? json_decode($son_input_settings->first()->page_data) : [];
                                                            @endphp
                                                            @if ($table->field_type == 'dropdown' || $table->field_type == 'json' || $table->field_type == 'array')
                                                                @php
                                                                    $multiple_select = $son_page_data != null && $son_page_data[0]->multiple_select ? $son_page_data[0]->multiple_select : 0;
                                                                    $pinput = $son_page_data != null && $son_page_data[1]->input ? $son_page_data[1]->input : 0;
                                                                    $prequired = $son_page_data != null && $son_page_data[2]->required ? $son_page_data[2]->required : 0;
                                                                @endphp
                                                                <div class="row">
                                                                    <div class="col-12 mb-1">
                                                                        @foreach ($has_son_data as $dropdown)
                                                                            <span class="badge badge-primary bg-primary mb-1">{{ $dropdown->data_value }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-12">

                                                                        <div class="row">
                                                                            <div class="col-1 center-middle-left">
                                                                                <span
                                                                                    class="group_icon_{{ $group->group_id }}"><i
                                                                                        class="fa {{ $multiple_select != null && $genabled == 1 ? 'fa-list-ol text-success' : 'fa-list-ol text-danger text-muted' }}"></i></span>
                                                                            </div>
                                                                            <div class="col-9 center-middle-left">

                                                                                <select
                                                                                    class="form-control form-input-sm group_enabled_input_{{ $group->group_id }}"
                                                                                    name="son_input_settings[{{ $table->son_id }}][multiple-select]"
                                                                                    {{ $prequired == 'required' ? 'required' : '' }}>
                                                                                    <option value="2"
                                                                                        {{ $multiple_select == 2 ? 'selected="selected"' : '' }}>
                                                                                        Multiple options
                                                                                    </option>
                                                                                    <option value="1"
                                                                                        {{ $multiple_select == 1 ? 'selected="selected"' : '' }}>
                                                                                        Single option
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden"
                                                                        name="son_input_settings[{{ $table->son_id }}][input]"
                                                                        value="dropdown" required>
                                                                </div>
                                                            @elseif($table->field_type == 'date')
                                                                @php
                                                                    $data_date_format = $son_page_data != null && $son_page_data[0]->data_date_format ? $son_page_data[0]->data_date_format : '';
                                                                    $pinput = $son_page_data != null && $son_page_data[1]->input ? $son_page_data[1]->input : 0;
                                                                    $prequired = $son_page_data != null && $son_page_data[2]->required ? $son_page_data[2]->required : 0;
                                                                @endphp

                                                                <div class="row">
                                                                    <div class="col-1 center-middle-left">
                                                                        <span
                                                                            class="group_icon_{{ $group->group_id }}"><i
                                                                                class="fa {{ $data_date_format != '' && $genabled == 1 ? 'fa-calendar text-success' : 'fa-calendar text-danger text-muted' }}"></i></span>
                                                                    </div>
                                                                    <div class="col-9 center-middle-left">
                                                                        <select
                                                                            class="form-control form-input-sm group_enabled_input_{{ $group->group_id }}"
                                                                            name="son_input_settings[{{ $table->son_id }}][data-date-format]"
                                                                            {{ $prequired == 'required' ? 'required' : '' }}>
                                                                            <option value="">Select format...
                                                                            </option>
                                                                            <option value="YYYY-MM-DD"
                                                                                {{ $data_date_format == 'YYYY-MM-DD' ? 'selected="selected"' : '' }}>
                                                                                YYYY-MM-DD</option>
                                                                            <option value="YYYY-MM"
                                                                                {{ $data_date_format == 'YYYY-MM' ? 'selected="selected"' : '' }}>
                                                                                YYYY-MM</option>
                                                                            <option value="YYYY"
                                                                                {{ $data_date_format == 'YYYY' ? 'selected="selected"' : '' }}>
                                                                                YYYY</option>
                                                                        </select>
                                                                        <input type="hidden"
                                                                            name="son_input_settings[{{ $table->son_id }}][input]"
                                                                            value="date" required>
                                                                    </div>
                                                                </div>
                                                            @elseif($table->field_type == 'number')
                                                                @php
                                                                    $field_settings = json_decode($table->field_settings);
                                                                    $prequired = $son_page_data != null && $son_page_data[1]->required ? $son_page_data[1]->required : 0;
                                                                @endphp
                                                                <span
                                                                    class="badge badge-primary bg-primary mb-1">{{ $field_settings != null ? $field_settings->start_range : '' }}</span>
                                                                to <span
                                                                    class="badge badge-primary bg-primary mb-1">{{ $field_settings != null ? $field_settings->end_range : '' }}</span>
                                                                <div class="row">
                                                                    <div class="col-1 center-middle-left">
                                                                        <span
                                                                            class="group_icon_{{ $group->group_id }}"><i
                                                                                class="fa {{ $field_settings != null && $genabled == 1 ? 'fa-calculator text-success' : 'fas fa-calculator text-danger text-muted' }}"></i></span>
                                                                    </div>
                                                                    <div class="col-9 center-middle-left">
                                                                        <input type="text"
                                                                            class="form-control form-input-sm group_enabled_input_{{ $group->group_id }}"
                                                                            name="son_input_settings[{{ $table->son_id }}][input]"
                                                                            value="min='{{ $field_settings != null ? $field_settings->start_range : '' }}',max='{{ $field_settings != null ? $field_settings->end_range : '' }}'">
                                                                        <input type="hidden"
                                                                            name="son_input_settings[{{ $table->son_id }}][input]"
                                                                            value="number" required>
                                                                    </div>
                                                                </div>
                                                            @elseif($table->field_type == 'widget')
                                                                @php
                                                                    $field_settings = json_decode($table->field_settings);
                                                                    $prequired = $son_page_data != null && $son_page_data[4]->required ? $son_page_data[4]->required : 0;
                                                                    $country = $countries->where('country_id', $field_settings->dropdown_value);
                                                                    $dropdown_value = $field_settings != null ? $field_settings->dropdown_value : '';
                                                                @endphp
                                                                <span
                                                                    class="badge badge-primary bg-primary mb-1">{{ $input_type = $field_settings != null ? $field_settings->input_type : '' }}</span>
                                                                <span
                                                                    class="badge badge-primary bg-primary mb-1">{{ $dropdown_type = $field_settings != null ? $field_settings->dropdown_type : '' }}</span>
                                                                <span
                                                                    class="badge badge-primary bg-primary mb-1">{{ $country_name = $country->first() ? $country->first()->country_name : '' }}</span>

                                                                <input type="hidden"
                                                                    name="son_input_settings[{{ $table->son_id }}][input]"
                                                                    value="widget">
                                                                <input type="hidden"
                                                                    name="son_input_settings[{{ $table->son_id }}][widget]"
                                                                    value="dropdown">
                                                                <input type="hidden"
                                                                    name="son_input_settings[{{ $table->son_id }}][dropdown_value]"
                                                                    value="{{ $dropdown_value . '|' . $country_name }}">

                                                                <div class="row">
                                                                    <div class="col-1 center-middle-left">
                                                                        <span
                                                                            class="group_icon_{{ $group->group_id }}"><i
                                                                                class="fa {{ $field_settings == null && $genabled == 1 ? 'fa-code text-success' : 'fa-code text-danger text-muted' }}"></i></span>
                                                                    </div>
                                                                    <div class="col-9 center-middle-left">
                                                                        <input type="text"
                                                                            class="form-control form-input-sm group_enabled_input_{{ $group->group_id }}"
                                                                            name="son_input_settings[{{ $table->son_id }}][dropdown_type]"
                                                                            value="{{ $dropdown_type }}"
                                                                            {{ $prequired == 'required' ? 'required' : '' }}>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                @php
                                                                    $son_settings = json_decode($table->field_settings); //[{"input":"text"},{"required":"1"}]
                                                                    $soninput = $son_settings != null && $son_settings[0]->input ? $son_settings[4]->input : '';
                                                                @endphp

                                                                <div class="row">
                                                                    <div class="col-1 center-middle-left">
                                                                        <span
                                                                            class="group_icon_{{ $group->group_id }}"><i
                                                                                class="fa {{ $soninput != null && $genabled == 1 ? 'fa-text-width text-success' : 'fa-text-width text-danger text-muted' }}"></i></span>
                                                                    </div>
                                                                    <div class="col-9 center-middle-left">
                                                                        <select
                                                                            name="son_input_settings[{{ $table->son_id }}][input]"
                                                                            class="form-control form-input-sm group_enabled_input_{{ $group->group_id }}">
                                                                            <option value="text"
                                                                                {{ $soninput == 'text' ? 'selected="selected" class="enabled"' : '' }}>
                                                                                Text
                                                                            </option>
                                                                            <option value="textarea"
                                                                                {{ $soninput == 'textarea' ? 'selected="selected"' : '' }}>
                                                                                Textarea
                                                                            </option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <div class="row">
                                                                <div class="col-1 center-middle-left">
                                                                    <span class="group_icon_{{ $group->group_id }}"><i
                                                                            class="fa {{ $has_page_input->first() != null && $genabled == 1 && $has_page_input->first()->page_data == 1 ? 'fa-check-circle text-success' : 'fa-check-circle text-danger text-muted' }} form-form-input-sm"></i></span>
                                                                </div>
                                                                <div class="col-9">

                                                                    <select
                                                                        name="page_input[{{ $field->field_id }}]"
                                                                        class="form-control form-input-sm group_enabled_input_{{ $group->group_id }}">
                                                                        <option value="1"
                                                                            {{ $has_page_input->first() != null && $has_page_input->first()->page_data == 1 ? 'selected="selected" class="enabled"' : '' }}>
                                                                            Enabled
                                                                        </option>
                                                                        <option value="0"
                                                                            {{ $has_page_input->first() != null && $has_page_input->first()->page_data == 0 ? 'selected="selected"' : '' }}?>

                                                                            Disabled
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-1 center-middle-left">
                                                                    <span class="group_icon_{{ $group->group_id }}"><i
                                                                            class="fa {{ $prequired == 1 && $genabled == 1 ? 'fa-check-circle text-success' : 'fa-check-circle text-danger text-muted' }} form-form-input-sm"></i></span>
                                                                </div>
                                                                <div class="col-9">
                                                                    <select
                                                                        name="son_input_settings[{{ $table->son_id }}][required]"
                                                                        class="form-control form-input-sm group_enabled_input_{{ $group->group_id }}">
                                                                        <option value="1"
                                                                            {{ $prequired == 1 ? 'selected="selected" class="enabled"' : '' }}>
                                                                            Compulsory
                                                                        </option>
                                                                        <option value="0"
                                                                            {{ $prequired == 0 ? 'selected="selected" class="disabled"' : '' }}>
                                                                            Not Compulsory
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col">
                                            <div class="form-group input-group-sm">

                                                <div class="row">
                                                    <div class="col-1 center-middle-left">
                                                        <span class="group_icon_{{ $group->group_id }}"><i
                                                                class="fa {{ $pinput_required->first() != null && $genabled == 1 && $pinput_required->first()->page_data == 1 ? 'fa-chevron-circle-up text-success' : 'fa-chevron-circle-up text-danger text-muted' }} form-form-input-sm"></i></span>
                                                    </div>
                                                    <div class="col-10">

                                                        <input name="page_input_sequence[{{ $field->field_id }}]"
                                                            class="form-control form-input-sm group_enabled_input_{{ $group->group_id }}"
                                                            type="text" value="{{ $num }}" />
                                                    </div>
                                                </div>



                                                @php
                                                    $isettings = $all_page_data->where('page_module', $field->field_id);
                                                    $isettings = $isettings->first() ? $isettings->where('page_key', 'page_input_settings') : '';
                                                    $ipdata = $isettings != null && $isettings->first() ? json_decode($isettings->first()->page_data) : [];
                                                    $input_pdata = $ipdata != null ? $ipdata->input : '';
                                                @endphp
                                                <div class="row">
                                                    <div class="col-1 center-middle-left">
                                                        <span class="group_icon_{{ $group->group_id }}"><i
                                                                class="fa {{ $input_pdata != null && $genabled == 1 ? 'fa-text-width text-success' : 'fa-text-width text-danger text-muted' }}"></i></span>
                                                    </div>
                                                    <div class="col-9 center-middle-left">
                                                        <select
                                                            name="page_input_settings[{{ $field->field_id }}][input]"
                                                            class="form-control form-input-sm group_enabled_input_{{ $group->group_id }}">
                                                            @if ($field->type_field == 'date')
                                                                <option value="date" selected="selected">
                                                                    Date
                                                                </option>
                                                            @elseif($field->type_field == 'dropdown')
                                                                <option value="dropdown" selected="selected">
                                                                    Dropdown
                                                                </option>
                                                            @elseif($field->type_field == 'country')
                                                                <option value="date" selected="selected">
                                                                    Country
                                                                </option>
                                                            @elseif($field->type_field == 'upload')
                                                                <option value="upload" selected="selected">
                                                                    Upload
                                                                </option>
                                                            @else
                                                                @foreach ($user_inputs as $input)
                                                                    <option value="{{ $input->input_value }}"
                                                                        {{ $input_pdata == $input->input_value ? 'selected="selected"' : '' }}>
                                                                        {{ $input->input_name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <div class="col-1 center-middle-left">
                                                        <span class="group_icon_{{ $group->group_id }}"><i
                                                                class="fa  {{ $has_page_input->first() != null && $genabled == 1 && $has_page_input->first()->page_data == 1 ? 'fa-check-circle text-success' : 'fa-check-circle text-danger text-muted' }}"></i></span>
                                                    </div>
                                                    <div class="col-10 center-middle-left">
                                                        <select name="page_input[{{ $field->field_id }}]"
                                                            id="page_input{{ $field->field_id }}"
                                                            class="form-control form-input-sm group_enabled_input_{{ $group->group_id }}">
                                                            <option value="1"
                                                                {{ $pinput_required->first() != null && $has_page_input->first()->page_data == 1 ? 'selected="selected" class="enabled"' : '' }}>
                                                                Enabled
                                                            </option>
                                                            <option value="0"
                                                                {{ $pinput_required->first() != null && $has_page_input->first()->page_data == 0 ? 'selected="selected"' : '' }}>
                                                                Disabled
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-1 center-middle-left">
                                                        <span class="group_icon_{{ $group->group_id }}"><i
                                                                class="fa  {{ $has_page_input->first() != null && $genabled == 1 && $has_page_input->first()->page_data == 1 ? 'fa-check-circle text-success' : 'fa-check-circle text-danger text-muted' }}"></i></span>
                                                    </div>

                                                    <div class="col-10 center-middle-left">
                                                        <select name="page_input_required[{{ $field->field_id }}]"
                                                            id="page_input_required{{ $field->field_id }}"
                                                            class="form-control form-input-sm group_enabled_input_{{ $group->group_id }}">
                                                            <option value="1"
                                                                {{ $pinput_required->first() != null && $pinput_required->first()->page_data == 1 ? 'selected="selected" class="enabled"' : '' }}>
                                                                
                                                                Compulsory
                                                            </option>
                                                            <option value="0"
                                                                {{ $pinput_required->first() != null && $pinput_required->first()->page_data == 0 ? 'selected="selected" class="disabled"' : '' }}>

                                                                Not Compulsory
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
            @php
                $num++;
            @endphp
        @endforeach
    </div>
@endforeach
