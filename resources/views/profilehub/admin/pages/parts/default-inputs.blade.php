@php
$group_settings = $all_page_data->where('page_module', 'default');
$group_enabled = $group_settings->first() ? $group_settings->where('page_key', 'group_enabled') : null;
$genabled = $group_enabled != null && $group_enabled->first() ? ($group_enabled->first()->page_data > 0 ? 1 : 0) : 0;

$group_settings = $all_page_data->where('page_module', 'input_layout');
$group_layout = $group_settings->first() ? $group_settings->where('page_key', 'group_layout') : null;
$glayout = $group_layout != null && $group_layout->first() ? $group_layout->first()->page_data : '';

$group_settings = $all_page_data->where('page_module', 'cols');
$group_input = $group_settings->first() ? $group_settings->where('page_key', 'group_layout') : null;
$ginput = $group_input != null && $group_input->first() ? $group_input->first()->page_data : null;

$group_settings = $all_page_data->where('page_module', 'default');
$group_input = $group_settings->first() ? $group_settings->where('page_key', 'group_input') : null;
$group_input = $group_input != null && $group_input->first() ? $group_input->first()->page_data : null;
@endphp
<div class="row mb-3" id="sortable-grid">
    <div class="col-12">
        <p class="font-weight-bold"><i class="fa fa-address-book" aria-hidden="true"></i>
            Defualt
        </p>
        <hr />

        <div class="row">

            <div class="col-xl-3 col-xxl-3 col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="card h-100 bg-light {{ $genabled == 1 ? 'border-success' : 'border-secondary' }}">
                    <div class="card-header">
                        <i class="fa"></i>
                        <small class="font-weight-bold">Default Settings</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                                <div class="row">
                                    <div class="col-1 center-middle-left">
                                        <span class="group_icon_default"><i
                                                class="fa {{ $genabled == 1 && $genabled == 1 ? 'fa-check-circle text-success' : 'fa-check-circle text-danger text-muted' }}"></i></span>
                                        <input type="hidden" value="{{ $genabled }}" id="group_enabled_default" />
                                    </div>
                                    <div class="col-10 center-middle-left">
                                        <select name="group_enabled[default]"
                                            class="form-control form-input-sm group_enabled_input_default">
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
                                        <span class="group_icon_default"><i
                                                class="fa {{ $genabled == 1 && $genabled == 1 ? 'fa-check-circle text-success' : 'fa-check-circle text-danger text-muted' }}"></i></span>
                                        <input type="hidden" value="{{ $genabled }}" id="group_enabled_default" />
                                    </div>
                                    <div class="col-10 center-middle-left">
                                        <select name="group_input[default]" class="form-control form-input-sm ">
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
            @foreach ($default_cols as $defID => $def_lang)
                @php
                    $has_page_input = $page_input->where('page_module', $def_lang);
                    $pinput_required = $page_input_required->where('page_module', $def_lang);
                @endphp
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 mb-3">
                    <div class="card h-100 bg-light">
                        <div class="card-header">
                            <i class="fa"></i>
                            <small
                                class="font-weight-bold">{{ ucwords($UserFunctions->userprofile_lang($def_lang)) }}</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @php
                                        $isettings = $all_page_data->where('page_module', $def_lang);
                                        $isettings = $isettings != null && $isettings->first() ? $isettings->where('page_key', 'page_input_settings') : '';
                                        $isettings = $isettings != null && $isettings->first() ? $isettings->where('page_id', $page->page_id ) : '';
                                        $ipdata = $isettings != null && $isettings->first() ? json_decode($isettings->first()->page_data) : [];
                                        $input_pdata = $ipdata != null ? $ipdata->input : '';
                                        if($isettings != null && $isettings->first()){
                                            $input_pdata = 1;
                                            $genabled = 1;
                                        }else{
                                            $genabled = 0;
                                            $input_pdata = 0;
                                        }
                                    @endphp
                                    <div class="row">
                                        <div class="col-1 center-middle-left">
                                            <span><i
                                                    class="fa {{ $input_pdata != null && $input_pdata != null && $genabled == 1 ? 'fa-text-width text-success' : 'fa-text-width text-danger text-muted' }}"></i></span>
                                        </div>
                                        <div class="col-9 center-middle-left">

                                            <select name="page_input_settings[{{ $def_lang }}][input]"
                                                class="form-control form-input-sm">
                                                @foreach ($user_inputs as $input)
                                                    <option value="{{ $input->input_value }}"
                                                        {{ $input_pdata == $input->input_value ? 'selected="selected"' : '' }}>
                                                        {{ $input->input_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    @php
                                        $penabled = $page_input->first() ? $page_input->where('page_key', 'page_input') : '';
                                    @endphp
                                    <div class="row">
                                        <div class="col-1 center-middle-left">
                                            <span><i
                                                    class="fa {{ $has_page_input->first() != null && $has_page_input->first()->page_data > 0 && $genabled == 1 ? 'fa-check-circle text-success' : 'fa-check-circle text-danger text-muted' }}"></i></span>
                                        </div>
                                        <div class="col-10 center-middle-left">
                                            <select name="page_input[{{ $def_lang }}]"
                                                class="form-control form-input-sm">
                                                <option value="1"
                                                    {{ $has_page_input->first() != null && $has_page_input->first()->page_data != '' && $has_page_input->first()->page_data == 1 ? 'selected="selected" class="enabled"' : '' }}>
                                                    Enabled  
                                                </option>
                                                <option value="0"
                                                    {{ $has_page_input->first() != null && $has_page_input->first()->page_data == 0 ? 'selected="selected"' : '' }}>
                                                    Disabled
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    @php
                                        $prequired = $pinput_required != null && $pinput_required->first() ? $pinput_required->where('page_key', 'page_input_required') : '';
                                    @endphp
                                    <div class="row">
                                        <div class="col-1 center-middle-left">
                                            <span><i
                                                    class="fa  {{ $prequired != null && $prequired->first() != null && $prequired->first()->page_data == 1 && $genabled == 1 ? 'fa-check-circle text-success' : 'fa-check-circle text-danger text-muted' }}"></i></span>
                                        </div>
                                        <div class="col-10 center-middle-left">
                                            <select name="page_input_required[{{ $def_lang }}]"
                                                class="form-control form-input-sm">
                                                <option value="1"
                                                    {{ $prequired != null && $prequired->first() != null && $prequired->first()->page_data == 1 ? 'selected="selected"' : '' }}>
                                                    Compulsory
                                                </option>
                                                <option value="0"
                                                    {{ $prequired != null && $prequired->first() != null && $prequired->first()->page_data == 0 ? 'selected="selected"' : '' }}>
                                                    Not Compulsory
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach


            @foreach ($default_userdetails_cols as $defID => $def_lang)
                @php
                    $has_page_input = $page_input->where('page_module', $def_lang);
                    $pinput_required = $page_input_required->where('page_module', $def_lang);
                @endphp
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 mb-3">
                    <div class="card h-100 bg-light">
                        <div class="card-header">
                            <i class="fa"></i>
                            <small
                                class="font-weight-bold">{{ ucwords($UserFunctions->userdetails_lang($def_lang)) }}</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @php
                                        $isettings = $all_page_data->where('page_module', $def_lang);
                                        $isettings = $isettings->first() ? $isettings->where('page_key', 'page_input_settings') : '';
                                        $isettings = $isettings != null && $isettings->first() ? $isettings->where('page_id', $page->page_id ) : '';
                                        $ipdata = $isettings != null && $isettings->first() ? json_decode($isettings->first()->page_data) : [];
                                        $input_pdata = $ipdata != null ? $ipdata->input : '';
                                        if ($isettings != null && $isettings->first()) {
                                            $input_pdata = 1;
                                            $genabled = 1;
                                        } else {
                                            $input_pdata = 0;
                                            $genabled = 0;
                                        }
                                    @endphp
                                    <div class="row">
                                        <div class="col-1 center-middle-left">
                                            <span><i class="fa {{ $input_pdata != null && $input_pdata != null && $genabled == 1 ? 'fa-text-width text-success' : 'fa-text-width text-danger text-muted' }}"></i></span>
                                        </div>
                                        <div class="col-9 center-middle-left">

                                            <select name="page_input_settings[{{ $def_lang }}][input]"
                                                class="form-control form-input-sm">
                                                @foreach ($user_inputs as $input)
                                                    <option value="{{ $input->input_value }}"
                                                        {{ $input_pdata == $input->input_value ? 'selected="selected"' : '' }}>
                                                        {{ $input->input_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    @php
                                        $penabled = $page_input->first() ? $page_input->where('page_key', 'page_input') : '';
                                    @endphp
                                    <div class="row">
                                        <div class="col-1 center-middle-left">
                                            <span><i
                                                    class="fa {{ $has_page_input->first() != null && $has_page_input->first()->page_data > 0 && $genabled == 1 ? 'fa-check-circle text-success' : 'fa-check-circle text-danger text-muted' }}"></i></span>
                                        </div>
                                        <div class="col-10 center-middle-left">
                                            <select name="page_input[{{ $def_lang }}]"
                                                class="form-control form-input-sm">
                                                <option value="1"
                                                    {{ $has_page_input->first() != null && $has_page_input->first()->page_data != '' && $has_page_input->first()->page_data == 1 ? 'selected="selected" class="enabled"' : '' }}> Enabled
                                                </option>
                                                <option value="0"
                                                    {{ $has_page_input->first() != null && $has_page_input->first()->page_data == 0 ? 'selected="selected"' : '' }}>
                                                    Disabled
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    @php
                                        $prequired = $pinput_required != null && $pinput_required->first() ? $pinput_required->where('page_key', 'page_input_required') : '';
                                    @endphp
                                    <div class="row">
                                        <div class="col-1 center-middle-left">
                                            <span><i
                                                    class="fa  {{ $prequired != null && $prequired->first() != null && $prequired->first()->page_data == 1 && $genabled == 1 ? 'fa-check-circle text-success' : 'fa-check-circle text-danger text-muted' }}"></i></span>
                                        </div>
                                        <div class="col-10 center-middle-left">
                                            <select name="page_input_required[{{ $def_lang }}]"
                                                class="form-control form-input-sm">
                                                <option value="1"
                                                    {{ $prequired != null && $prequired->first() != null && $prequired->first()->page_data == 1 ? 'selected="selected"' : '' }}>
                                                    Compulsory
                                                </option>
                                                <option value="0"
                                                    {{ $prequired != null && $prequired->first() != null && $prequired->first()->page_data == 0 ? 'selected="selected"' : '' }}>
                                                    Not Compulsory
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
