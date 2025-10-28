@php
$group_settings = $page_data->where('page_module', 'password');
$pass_enabled = $group_settings->first() ? $group_settings->where('page_key', 'page_input') : null;
$penabled = $pass_enabled != null && $pass_enabled->first() ? ($pass_enabled->first()->page_data > 0 ? 1 : 0) : 0;

$pass_required = $group_settings->first() ? $group_settings->where('page_key', 'page_input_required') : null;
$prequired = $pass_required != null && $pass_required->first() ? $pass_required->first()->page_data : null;
//'page_profile' => $page_profile,
@endphp
<div class="mt-3 mb-3">
    @if ($penabled)
        <strong><i class="fa fa-lock" aria-hidden="true"></i> Password Management</strong>
        <hr />
        @foreach ($page_profile as $default)
            @if ($default == 'password')
                <label for="pwdId">Password</label>
                <div class="form-group">
                    <div class="form-line">
                        <input class="form-control pwds" type="password" placeholder="{{ __('Password') }}"
                            name="password" id="pwdId" required
                            minlength="{{ $system_settings['password_lenght'] }}"
                            autocomplete="autocomplete_off_hack_xfr4!k" required onkeyup="pwdStrengthChecker(this)">
                        <div class="valid-feedback">Valid</div>
                        <div class="invalid-feedback">a to z only (more than 6 letters)</div>
                        <div class="mt-1">
                            <div class="badge badge-danger p-1" id="password-strength-weak" style="display:none;">
                                Password
                                Strenght: Weak!</div>
                        </div>
                        <div class="mt-1">
                            <div class="badge badge-success p-1" id="password-strength-strong" style="display:none;">
                                Password Strenght: Strong!</div>
                        </div>
                    </div>
                    @if ($system_settings['password_strenght'] == 2)
                        <small id="passwordHelpInline" class="text-muted mt-1">
                            <b>1. Pasword must have:</b><br />
                            <b>2. One lowercase letter [a-z],</b><br />
                            <b>3. One uppercase letter [A-Z]),</b><br />
                            <b>4. One number [0-9],</b><br />
                            <b>5. And must be least [{{ $system_settings['password_lenght'] }}] characters
                                long</b><br />.
                        </small>
                    @endif
                    @if ($system_settings['password_strenght'] == 3)
                        <small id="passwordHelpInline" class="text-muted mt-1">
                            <b>1. Pasword must have:</b><br />
                            <b>2. One lowercase letter [a-z],</b><br />
                            <b>3. One uppercase letter [A-Z]),</b><br />
                            <b>4. One number [0-9],</b><br />
                            <b>5. One special character (?=.*[^A-Za-z0-9]),</b><br />
                            <b>5. And must be least [{{ $system_settings['password_lenght'] }}] characters
                                long</b><br />.
                        </small>
                    @endif
                </div>


                <label for="cPwdId">confirm password</label>
                <div class="form-group">
                    <div class="form-line">
                        <input class="form-control pwds" type="password" placeholder="{{ __('Confirm Password') }}"
                            name="password_confirmation" id="cPwdId" required
                            minlength="{{ $system_settings['password_lenght'] }}"
                            autocomplete="autocomplete_off_hack_xfr4!k" required onkeyup="comparePwds()"
                            aria-describedby="passwordHelpInline">
                    </div>

                    <div id="cPwdValid" class="valid-feedback">Passwords match.</div>
                    <div id="cPwdInvalid" class="invalid-feedback">Confirm password must match with
                        password!</div>
                </div>
            @endif
        @endforeach
    @endif
</div>
