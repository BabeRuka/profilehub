@foreach ($page_groups as $group)
    @php
        $all_groupinputs = $userdetails->user_field(0, $group->group_id);
    @endphp
    <div class="row mb-3" id="sortable-grid">
        <div class="col-12">
            <p class="font-weight-bold"><i class="fa {{ $group->group_icon }}" aria-hidden="true"></i>
                {{ strtoupper($group->group_name) }} Group</p>
            <hr />
        </div>
        @php
            $num = 1;
        @endphp
        @foreach ($all_groupinputs as $field)
            @php
                $has_page_input = $page_input->where('page_module', $field->field_id);
                $pinput_required = $page_input_required->where('page_module', $field->field_id);
            @endphp
            <div class="col-xl-4 col-md-6 col-xxl-3 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card h-100  bg-light">
                            <div class="card-header">
                                <i class="fa"></i>
                                <small class="font-weight-bold">{{ ucwords($field->translation) }}</small>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col">

                                        <div class="row">
                                            <div class="col-1 center-middle-left">
                                                <span><i class="fa {{ $pinput_required->first() != null && $pinput_required->first()->page_data == 1 ? 'fa-chevron-circle-up text-success' : 'fa-chevron-circle-up text-danger' }} form-input-sm"></i></span>
                                            </div>
                                            <div class="col-10">
                                                <input name="page_input_sequence[{{ $field->field_id }}]"
                                                    class="form-control form-input-sm" type="text"
                                                    value="{{ $num }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-1 center-middle-left">
                                                <span><i class="fa {{ $pinput_required->first() != null && $pinput_required->first()->page_data == 1 ? 'fa-check-circle text-success' : 'fa-minus-circle text-danger' }}"></i></span>
                                            </div>
                                            <div class="col-10">
                                                <select name="page_input[{{ $field->field_id }}]"
                                                    id="page_input{{ $field->field_id }}"
                                                    class="form-control form-input-sm">
                                                    <option value="1" {{ $pinput_required->first() != null && $pinput_required->first()->page_data == 1 ? 'selected="selected"' : '' }}>
                                                        Enabled
                                                    </option>
                                                    <option value="0" {{ $pinput_required->first() != null && $pinput_required->first()->page_data == 0 ? 'selected="selected"' : '' }}>
                                                        Disabled
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-1 center-middle-left">
                                                <span><i class="fa {{ $pinput_required->first() != null && $pinput_required->first()->page_data == 1 ? 'fa-check-circle text-success' : 'fa-minus-circle text-danger' }}"></i></span>
                                            </div>
                                            <div class="col-10">
                                                <select name="page_input_required[{{ $field->field_id }}]"
                                                    class="form-control form-input-sm">
                                                    <option value="1" {{ $pinput_required->first() != null && $pinput_required->first()->page_data == 1 ? 'selected="selected"' : '' }}>
                                                        Compulsory
                                                    </option>
                                                    <option value="0" {{ $pinput_required->first() != null && $pinput_required->first()->page_data == 0 ? 'selected="selected"' : '' }}>
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
                </div>
            </div>
            @php
                $num++;
            @endphp
        @endforeach
    </div>
@endforeach
