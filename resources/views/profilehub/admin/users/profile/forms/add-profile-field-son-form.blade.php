<input type="hidden" name="function" value="create-user-field-son" />
<input type="hidden" name="field_id" value="{{ $field->field_id ? $field->field_id : request('id') }}" />
<input type="hidden" name="son_id" value="0" />
<div class="row">
    <div class="col-md-12 mb-6 form-group">
        <label for="translation">Name </label>
        <input type="text" class="form-control" name="translation" placeholder="Enter field name..." value="" required>
        <div class="invalid-feedback">
            Valid field name is required.
        </div>
    </div>
</div>
@if(request(key: 'name') != 'dropdown')
    <div class="row">
        <div class="col-md-12 mb-6 form-group">
            <label for="field_type">Type</label>
            <select class="form-control" name="field_type" required>
                <option value="">Select option... </option>
                <option value="text">Text e.g. text</option>
                <option value="data">Data e.g. large format
                    of
                    text including html</option>
                <option value="json">Json e.g. ['language'
                    :'php', 'language' :'javascript' ]</option>
                <option value="number">Number e.g.
                    range [0-10]</option>
                <option value="string">String e.g. 1,2,3,4,5
                </option>
                <option value="dropdown">Dropdown e.g. option
                    1,option 2,option 3,option 4,option 5
                </option>
                <option value="date">Date e.g. date format
                </option>
                <option value="widget">Widget e.g. country,
                    state and city dropdwowns</option>
            </select>
            <div class="invalid-feedback">
                Valid field type is required.
            </div>
        </div>
    </div>
@else
    <input type="hidden" name="field_type" value="text" />

@endif