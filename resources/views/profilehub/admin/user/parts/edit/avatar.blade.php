@php
$group_settings = $page_data->where('page_module', 'password');
$pass_enabled = $group_settings->first() ? $group_settings->where('page_key', 'page_input') : null;
$penabled = $pass_enabled != null && $pass_enabled->first() ? ($pass_enabled->first()->page_data > 0 ? 1 : 0) : 0;

$pass_required = $group_settings->first() ? $group_settings->where('page_key', 'page_input_required') : null;
$prequired = $pass_required != null && $pass_required->first() ? $pass_required->first()->page_data : null;
@endphp
Profile Photo
<hr />
<div class="row">
    <div class="col-12 mb-2">
        <div class="form-group">
            <input type="file" name="profile_pic" id="profile_pic" data-show-loader="false"
                data-allowed-file-extensions="jpg png jpeg" class="dropify" data-default-file="{{ $profile_pic }}"
                {{ $profile_pic == '' ? 'required' : '' }} />
            <div class="invalid-feedback">
                Profile Picture is required.
            </div>
        </div>
    </div>
    @if ($penabled)
        <div class="col-12 mb-2">
            Password Management
            <hr />
        </div>
        @foreach ($page_profile as $default)
            @if ($default == 'password')
                <div class="col-12">
                    <label class="" for="pwdId">{{ ucwords($UserFunctions->userprofile_lang($default)) }}
                    </label>
                    <div class="form-group">
                        <input type="password" name="{{ $default }}" id="pwdId" class="form-control"
                            {{ $prequired > 0 ? 'required' : '' }} minlength="7"
                            autocomplete="autocomplete_off_hack_xfr4!k" readonly
                            onfocus="this.removeAttribute('readonly');" onkeyup="pwdStrengthChecker(this)" />
                        <div class="valid-feedback">Valid</div>
                        <div class="invalid-feedback">a to z only (more than 6 letters)</div>
                        <div class="mt-1">
                            <div class="badge badge-danger p-1" id="password-strength-weak" style="display:none;">
                                Password Strenght: Weak!</div>
                        </div>
                        <div class="mt-1">
                            <div class="badge badge-success p-1" id="password-strength-strong" style="display:none;">
                                Password Strenght: Strong!</div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <small id="passwordHelpInline" class="text-muted mt-1">
                        <b>1. Pasword must have:</b><br />
                        <b>2. One lowercase letter [a-z],</b><br />
                        <b>3. One uppercase letter [A-Z]),</b><br />
                        <b>4. One number [0-9],</b><br />
                        <b>5. And must be least [7] characters
                            long</b><br />.
                    </small>
                </div>
                <div class="col-12">
                    <label class="" for="cPwdId">Repeat
                        {{ ucwords($UserFunctions->userprofile_lang($default)) }}
                    </label>
                    <div class="form-group">
                        <input type="password" name="repeat_{{ $default }}" id="cPwdId"
                            class="form-control" {{ $prequired > 0 ? 'required' : '' }} minlength="7"
                            autocomplete="autocomplete_off_hack_xfr4!k" readonly
                            onfocus="this.removeAttribute('readonly');" onkeyup="comparePwds()"
                            aria-describedby="passwordHelpInline" />
                    </div>
                    <div id="cPwdValid" class="valid-feedback">Passwords match.</div>
                    <div id="cPwdInvalid" class="invalid-feedback">Confirm password must match with password!</div>
                </div>
            @endif
        @endforeach
    @endif
</div>
