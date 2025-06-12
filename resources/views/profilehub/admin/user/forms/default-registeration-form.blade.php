<label for="username">Username</label>
<div class="form-group">
    <div class="form-line">
        <input type="text" id="username" name="username" value="" class="form-control un" placeholder="Enter your username..." minlength="8" required autocomplete="autocomplete_off_hack_xfr4!k">
    </div>
    <div class="invalid-feedback">
        username is required.
    </div>
    <div id="unValid" class="valid-feedback">Username is valid</div>
    <div id="unInvalid" class="invalid-feedback">a to z only (more than 6 letters)</div>
</div>

<label for="firstname">firstname</label>
<div class="form-group">
    <div class="form-line">
        <input type="text" id="firstname" name="firstname" value="" class="form-control" placeholder="Enter your firstname..." required autocomplete="autocomplete_off_hack_xfr4!k">
    </div>
    <div class="invalid-feedback">
        firstname is required.
    </div>
</div>

<label for="lastname">lastname</label>
<div class="form-group">
    <div class="form-line">
        <input type="text" id="lastname" name="lastname" value="" class="form-control" placeholder="Enter your lastname..." required autocomplete="autocomplete_off_hack_xfr4!k">
    </div>
    <div class="invalid-feedback">
        lastname is required.
    </div>

</div>


<label for="email">email</label>
<div class="form-group">
    <div class="form-line">
        <input type="email" id="email" name="email" value="" class="form-control em" placeholder="{{ __('E-Mail Address') }}" required autocomplete="autocomplete_off_hack_xfr4!k">
    </div>
    <div class="invalid-feedback">
        email is required.
    </div>
    <div id="emValid" class="valid-feedback">email is valid</div>
    <div id="emInvalid" class="invalid-feedback">invalid or used email</div>
</div>


<label for="pwdId">password</label>
<div class="form-group">
    <div class="form-line">
        <input class="form-control pwds" type="password" placeholder="{{ __('Password') }}" name="password" id="pwdId" required minlength="{{ $system_settings['password_lenght'] }}" autocomplete="autocomplete_off_hack_xfr4!k" readonly onfocus="this.removeAttribute('readonly');" onkeyup="pwdStrengthChecker(this)">
        <div class="valid-feedback">Valid</div>
        <div class="invalid-feedback">a to z only (more than 6 letters)</div>
        <div class="mt-1">
            <div class="badge badge-danger p-1" id="password-strength-weak" style="display:none;">Password Strenght: Weak!</div>
        </div>
        <div class="mt-1">
            <div class="badge badge-success p-1" id="password-strength-strong" style="display:none;">Password Strenght: Strong!</div>
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
        <input class="form-control pwds" type="password" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" id="cPwdId" required minlength="{{ $system_settings['password_lenght'] }}" autocomplete="autocomplete_off_hack_xfr4!k" readonly onfocus="this.removeAttribute('readonly');" onkeyup="comparePwds()" aria-describedby="passwordHelpInline">
    </div>

    <div id="cPwdValid" class="valid-feedback">Passwords match.</div>
    <div id="cPwdInvalid" class="invalid-feedback">Confirm password must match with
        password!</div>
</div>

@if ($system_settings['registration_type'] == 2)
@foreach ($userdetails->user_field() as $field)
@if ($field->type_field == 'dropdown')
<label for="user_entry_{{ $field->field_id }}">{{ strtoupper($field->translation) }}
</label>
<div class="form-group">
    <div class="form-line">
        <select class="form-control p-2" id="user_entry_{{ $field->field_id }}" name="user_entry[{{ $field->field_id }}]" required>
            <option value="">Select an option...</option>
            @foreach ($userdetails->user_field_son($field->field_id) as $son)
            <option value="{{ $son->son_id }}">
                {{ strtoupper($son->translation) }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="invalid-feedback">
        {{ $field->translation }} is required.
    </div>
</div>
@elseif ($field->type_field == 'date')
<label for="user_entry_{{ $field->field_id }}">{{ $field->translation }}</label>
<div class="form-group">
    <div class="form-line">
        <input type="text" id="user_entry_{{ $field->field_id }}" name="user_entry[{{ $field->field_id }}]" value="" class="form-control" placeholder="Enter {{ $field->translation }}" required autocomplete="autocomplete_off_hack_xfr4!k">
    </div>
    <div class="invalid-feedback">
        {{ $field->translation }} is required.
    </div>
</div>
@elseif ($field->type_field == 'country')
<label for="user_entry_{{ $field->field_id }}">{{ $field->translation }}</label>
<div class="form-group">
    <div class="form-line">
        <select class="form-control p-2 selectize-single" id="user_entry_{{ $field->field_id }}" name="user_entry[{{ $field->field_id }}]" required>
            <option value="">Select an option...</option>
            @foreach ($all_countries as $country)
            <option value="{{ $country->country_code }}">{{ strtoupper($country->country_name) }}</option>
            @endforeach
        </select>
    </div>
</div>
@else
<label for="user_entry_{{ $field->field_id }}">{{ $field->translation }}</label>
<div class="form-group">
    <div class="form-line">
        <input type="text" id="user_entry_{{ $field->field_id }}" name="user_entry[{{ $field->field_id }}]" value="" class="form-control" placeholder="Enter {{ $field->translation }}" required autocomplete="autocomplete_off_hack_xfr4!k">
    </div>
    <div class="invalid-feedback">
        {{ $field->translation }} is required.
    </div>
</div>
@endif
@endforeach
@endif
