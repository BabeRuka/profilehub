<i class="fa fa-address-book" aria-hidden="true"></i> <strong>Personal Info</strong>
<hr />
<div class="row mb-6">
    @foreach ($page_defaults as $default)
        @php
            $gc_settings = $page_data->where('page_key', 'group_input');
            $gc_settings = $gc_settings->first() ? $gc_settings->where('page_module', 'default') : null;
            $groupcard_class = $gc_settings->first() ? $gc_settings->first()->page_data : 0;

            $page_settings = $page_data->where('page_module', $default);
            $input_enabled = $page_settings->first() ? $page_settings->where('page_key', 'page_input') : null;
            $show_input = $input_enabled->first() ? $input_enabled->first()->page_data : 0;

            $input_required = $page_settings->first() ? $page_settings->where('page_key', 'page_input_required') : null;
            $input_required = $input_required->first()
                ? ($input_required->first()->page_data > 0
                    ? 'required'
                    : '')
                : '';

            $input_settings = $page_settings->first() ? $page_settings->where('page_key', 'page_input_settings') : null;
            $input_settings =
                $input_settings->first() && $input_settings->first()->page_data
                    ? json_decode($input_settings->first()->page_data)
                    : null;
            $input_type = $input_settings != null ? $input_settings->input : 'text';
        @endphp
        @if ($show_input > 0)
            @if ($default == 'profile_pic')
            @elseif($default == 'password')
            @else
                <div class="{{ $default == 'user_bio' ? 'col-12' : $groupcard_class }}">
                    <label
                        class="label label-default"><strong>{{ ucwords($UserFunctions->userprofile_lang($default)) }}</strong></label>
                    <div class="form-group">
                        <div class="form-line">
                            <div class="form-control pb-3 mb-1">
                                @php
                                    if ($default == 'user_role') {
                                        $user_role = $user_roles->where('id', $user->$default);
                                        echo ucwords($user_role->first()->lang_name);
                                    } else {
                                        echo stripslashes($user->$default);
                                    }
                                @endphp
                                <?php $num_filled = $user->$default ? $num_filled + 1 : $num_filled + 0; ?>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endforeach
</div>

<i class="fa fa-address-book" aria-hidden="true"></i> <strong>Default Fields</strong>
<hr />
<div class="row mb-6">
    @foreach ($default_user_details as $detail)
        <div class="{{ $detail == 'user_bio' ? 'col-12' : $groupcard_class }}">
            <label
                class="label label-default"><strong>{{ ucwords($UserFunctions->userprofile_lang($detail)) }}</strong></label>
            <div class="form-group">
                <div class="form-line">
                    <div class="form-control pb-3 mb-3">
                        @php
                            if ($detail == 'profile_pic' || $detail == 'user_avatar') {
                                $url_img = url('files/user');
                                $profile_pic = $user_detail->$detail != '' ? $url_img . '/' . $user_detail->$detail : $url_img . '/blank-user.png';
                                echo '<img class="img-thumbnail" src="' . $profile_pic . '" alt="card image">';
                            } elseif ($detail == 'user_role') {
                                $user_role = $user_roles->where('id', $user_detail->$detail);
                                echo ucwords($user_role->first()->lang_name);
                            } else {
                                echo stripslashes($user_detail->$detail);
                            }
                        @endphp
                        <?php $num_filled = $user_detail->$detail ? $num_filled + 1 : $num_filled + 0; ?>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
