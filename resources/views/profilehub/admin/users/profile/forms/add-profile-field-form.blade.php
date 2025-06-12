<input type="hidden" name="function" value="create-user-file" />
<input type="hidden" name="field_id" value="0" />
<div class="row">
    <div class="col-md-12 mb-6 form-group">
        <label for="translation">Field name</label>
        <input type="text" class="form-control" name="translation" placeholder="Enter field name..."
            value="" required>
        <div class="invalid-feedback">
            Valid field name is required.
        </div>
    </div>

    <div class="col-md-12 mb-6 form-group">
        <label for="type_field">Type of Field</label>
        <select class="selectpicker form-control" name="type_field" required>
            <option value="" selected>Select an option...</option>
            @foreach($user_field_type as $type)
                <option value="{{ $type->type_field }}">{{ strtoupper($type->type_field) }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            Valid language code is required.
        </div>
    </div>


    <div class="col-md-12 mb-6 form-group">
        <label for="type_field">Group Name</label>
        <select class="selectpicker form-control" name="group_id" required>
            <option value="" selected>Select an option...</option>
            @foreach($user_groups as $group)
                <option value="{{ $group->group_id }}">{{ strtoupper($group->group_name) }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            Valid language code is required.
        </div>
    </div>

    <div class="col-md-12 mb-6 form-group">
        <label for="type_field">Sequence</label>
        <label for="translation">Field name</label>
        <input type="text" class="form-control" name="sequence" placeholder="Enter sequence..."
            value="{{ $group->sequence }}" required>
        <div class="invalid-feedback">
            Valid language code is required.
        </div>
    </div>
</div>