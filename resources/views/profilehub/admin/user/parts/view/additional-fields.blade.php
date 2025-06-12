<i class="fa fa-address-book" aria-hidden="true"></i> <strong>Additional Fields</strong>
<hr />
<div class="row mb-6">
    <div class="col-12">
        @foreach ($userdetails->user_field_groups() as $group)
            @php
                $gs = $page_data->where('page_module', $group->group_id);
                $group_enabled = $gs->first() ? $gs->where('page_key', 'group_enabled') : null;
                $genabled = $group_enabled != null && $group_enabled->first() ? ($group_enabled->first()->page_data > 0 ? 1 : 0) : 0;

                $group_settings = $page_data->where('page_module', 'input_layout');
                $group_layout = $group_settings->first() ? $group_settings->where('page_key', 'group_layout') : null;
                $glayout = $group_layout != null && $group_layout->first() ? $group_layout->first()->page_data : '';

                $group_settings = $page_data->where('page_module', 'cols');
                $group_input = $group_settings->first() ? $group_settings->where('page_key', 'group_layout') : null;
                $ginput = $group_input != null && $group_input->first() ? $group_input->first()->page_data : null;

                $group_input = $gs->first() ? $gs->where('page_key', 'group_input') : null;
                $groupcard_class = $group_input != null && $group_input->first() ? $group_input->first()->page_data : null;

            @endphp
            <div class="card">
                <div class="card-header">
                    <i class="fa {{ $group->group_icon }}" aria-hidden="true"></i> {{ $group->group_name }}
                </div>
                <div class="card-body">
                    <div class="row">

                        @foreach ($userdetails->user_field(0, $group->group_id) as $field)
                            @php
                                $page_settings = $page_data->where('page_module', $field->field_id);
                                $input_enabled = $page_settings->first() ? $page_settings->where('page_key', 'page_input') : null;
                                $input_enabled = $input_enabled->first() ? $input_enabled->first()->page_data : 0;

                                $gc_settings = $page_settings->where('page_key', 'page_input');
                                $gc_settings = $gc_settings->first() ? $gc_settings->where('page_module', $field->field_id) : null;
                                //$groupcard_class = $gc_settings->first() ? $gc_settings->first()->page_data : 0;

                                $input_required = $page_settings->first() ? $page_settings->where('page_key', 'page_input_required') : null;
                                $input_required = $input_required->first() ? ($input_required->first()->page_data > 0 ? 'required' : '') : '';

                                $input_settings = $page_settings->first() ? $page_settings->where('page_key', 'page_input_settings') : null;
                                $input_settings = $input_settings->first() && $input_settings->first()->page_data ? json_decode($input_settings->first()->page_data) : null;
                                $input_type = $input_settings != null ? $input_settings->input : 'text';
                            @endphp
                            @if ($input_enabled > 0)
                                <div class="{{ $field->type_field == 'table' ? 'col-12' : $groupcard_class }} mb-3">

                                    @if ($field->type_field == 'table')
                                        @php
                                            $son_fields = $userdetails->user_field_son($field->field_id);
                                        @endphp
                                        @include('profilehub::admin.user.parts.table')
                                    @else
                                        <label
                                            class="label label-default"><strong>{{ $field->translation }}:</strong></label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <div class="form-control">
                                                    {{ $user_entry = $userdetails->one_user_field_details($field->field_id, $user->user_id) }}
                                                    <?php $num_filled += $user_entry ? 1 : 0; ?>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            @php
                                $num_rows++;
                            @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
