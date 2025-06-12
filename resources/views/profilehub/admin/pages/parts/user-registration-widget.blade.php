@php
$group_settings = $all_page_data->where('page_module', 'input_layout');
$group_layout = $group_settings->first() ? $group_settings->where('page_key', 'group_layout') : null;
$glayout = $group_layout != null && $group_layout->first() ? $group_layout->first()->page_data : '';

$group_settings = $all_page_data->where('page_module', 'cols');
$group_input = $group_settings->first() ? $group_settings->where('page_key', 'group_layout') : null;
$ginput = $group_input != null && $group_input->first() ? $group_input->first()->page_data : null;
@endphp
<h1 class="display-page">Page Input Settings</h1>
<hr />

<div class="row mb-3">
    <div class="col-xl-6 col-md-6 col-xxl-6 col-xs-12 col-sm-12">
        <label>Registeration type</label>
        <div class="form-group">
            <select class="form-control" name="page_input_settings[registration_type]" 
                required>
                <option value="">Please select the defualt registration type of the lMS...</option>
                @foreach($all_roles as $role)
                <option value="{{ $role->id }}" {{ $registration_type == $role->id ? 'selected="selected"' : '' }}>
                    {{ ucwords($role->name) }}
                </option>
                @endforeach

            </select>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 col-xxl-6 col-xs-12 col-sm-12">
        <label>Groups</label>
        <div class="form-group">
            <select class="form-control" name="page_input_settings[group_settings]" onchange="disableGroups(this)"
                required>
                <option value="">Please select collumn group settings...</option>
                <option value="0" {{ $group_setting == 0 ? 'selected="selected"' : '' }}>
                    Disable groups
                </option>
                <option value="1" {{ $group_setting == 1 ? 'selected="selected"' : '' }}>
                    Use Groups
                </option>

            </select>
        </div>
    </div>


    <div class="col-xl-6 col-md-6 col-xxl-6 col-xs-12 col-sm-12">
        <label>Group Ordering</label>
        <div class="form-group">
            <select class="form-control" name="page_input_settings[sort_order]" id="page_input_settings_" required>
                <option value="">Please select...</option>
                <option value="ascending_order" {{ $sort_order == 'ascending_order' ? 'selected' : '' }}>
                    Ascending order
                </option>
                <option value="descending_order" {{ $sort_order == 'descending_order' ? 'selected' : '' }}>
                    Descending order
                </option>
                <option value="random_order" {{ $sort_order == 'random_order' ? 'selected' : '' }}>
                    Random order
                </option>

            </select>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-xxl-6 col-xs-12 col-sm-12">
        <label>Input Layout</label>

        <select name="group_layout[input_layout]" class="form-control">
            <option value="cards" {{ $glayout == 'cards' ? 'selected="selected"' : '' }}>
                Use cards
            </option>
            <option value="form-group" {{ $glayout == 'form-group' ? 'selected="selected"' : '' }}>
                Use Input Groups
            </option>
        </select>
    </div>
    <div class="col-xl-6 col-md-6 col-xxl-6 col-xs-12 col-sm-12">
        <label>Input Layout</label>
        <select name="group_input[cols]" class="form-control">
            <option value="col-xl-12 col-lg-12" <?php
            if ($ginput) {
                echo $ginput == 'col-xl-12 col-lg-12' ? 'selected="selected"' : '';
            }
            ?>>
                One input field per row</option>
            <option value="col-xl-6 col-lg-6 col-md-6 col-sm-12" <?php
            if ($ginput) {
                echo $ginput == 'col-xl-6 col-lg-6 col-md-6 col-sm-12' ? 'selected="selected"' : '';
            }
            ?>>
                Two input fields per row</option>
            <option value="col-xl-4 col-lg-4 col-md-4 col-sm-4" <?php
            if ($ginput) {
                echo $ginput == 'col-xl-4 col-lg-4 col-md-4 col-sm-4' ? 'selected="selected"' : '';
            }
            ?>>
                Three input fields per row</option>
            <option value="col-xl-3 col-lg-3 col-md-3 col-sm-3" <?php
            if ($ginput) {
                echo $ginput == 'col-xl-3 col-lg-3 col-md-3 col-sm-3' ? 'selected="selected"' : '';
            }
            ?>>
                Four input fields per row</option>
        </select>
    </div>

</div>
<label class="font-weight-bold">Required Fields</label>
<hr />

@include('profilehub::admin.pages.parts.default-inputs')
@include('profilehub::admin.pages.parts.all-additional-field-inputs')
