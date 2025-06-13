@extends('vendor.profilehub.layouts.admin')
@inject('userdetails', 'BabeRuka\ProfileHub\Models\UserFieldDetails')
@section('content')
    <form class="needs-validation" action="{{ 'register' }}" method="POST" enctype="multipart/form-data" novalidate>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i> Add User
                            </div>
                            <div class="card-body">
                                <br>

                                @csrf
                                @method('POST')
                                <input type="hidden" name="function" id="function" value="manage-user">
                                <input type="hidden" name="user_bio" value="">

                                <div class="form-line">
                                    <div class="form-floating form-floating-outline mb-6">

                                        <input type="text" id="username" name="username" value=""
                                            class="form-control" placeholder="Enter your username..." required
                                            autocomplete="username" autofocus="">
                                        <label for="username" class="col-md-4 col-form-label">Username</label>
                                        <span class="valid-feedback" role="alert">
                                            <strong>Looks good!</strong>
                                        </span>
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Please enter the username...</strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-line">
                                    <div class="form-floating form-floating-outline mb-6">

                                        <input type="text" id="firstname" name="firstname" value=""
                                            class="form-control" placeholder="Enter your firstname..." required
                                            autocomplete="firstname" autofocus="">
                                        <label for="firstname" class="col-md-4 col-form-label">firstname</label>
                                        <span class="valid-feedback" role="alert">
                                            <strong>Looks good!</strong>
                                        </span>
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Please enter the user's firstname...</strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-line">
                                    <div class="form-floating form-floating-outline mb-6">

                                        <input type="text" id="lastname" name="lastname" value=""
                                            class="form-control" placeholder="Enter your lastname..." required
                                            autocomplete="lastname" autofocus="">
                                        <label for="lastname" class="col-md-4 col-form-label">lastname</label>
                                        <span class="valid-feedback" role="alert">
                                            <strong>Looks good!</strong>
                                        </span>
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Please enter the user's lastname...</strong>
                                        </span>
                                    </div>
                                </div>


                                <div class="form-line">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input type="text" id="email" name="email" value=""
                                            class="form-control" placeholder="{{ __('E-Mail Address') }}" required
                                            autocomplete="email" autofocus="">
                                        <label for="email" class="col-md-4 col-form-label">email</label>
                                        <span class="valid-feedback" role="alert">
                                            <strong>Looks good!</strong>
                                        </span>
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Please enter the user's email...</strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control pwds" type="password" placeholder="Password"
                                            name="password" id="pwdId" required minlength="7"
                                            autocomplete="autocomplete_off_hack_xfr4!k" required
                                            onkeyup="pwdStrengthChecker(this)">
                                        <label for="pwdId">Password</label>
                                        <div class="valid-feedback">Valid</div>
                                        <div class="invalid-feedback">a to z only (more than 6 letters)</div>
                                        <div class="mt-1">
                                            <div class="badge badge-danger p-1" id="password-strength-weak"
                                                style="display:none;">
                                                Password
                                                Strenght: Weak!</div>
                                        </div>
                                        <div class="mt-1">
                                            <div class="badge badge-success p-1" id="password-strength-strong"
                                                style="display:none;">
                                                Password Strenght: Strong!</div>
                                        </div>
                                    </div>
                                    <small id="passwordHelpInline" class="text-muted mt-1">
                                        <b>1. Pasword must have:</b><br />
                                        <b>2. One lowercase letter [a-z],</b><br />
                                        <b>3. One uppercase letter [A-Z]),</b><br />
                                        <b>4. One number [0-9],</b><br />
                                        <b>5. And must be least [7] characters
                                            long</b><br />.
                                    </small>
                                </div>



                                <div class="form-group mb-3">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control pwds" type="password" placeholder="Confirm Password"
                                            name="password_confirmation" id="cPwdId" required minlength="7"
                                            autocomplete="autocomplete_off_hack_xfr4!k" required onkeyup="comparePwds()"
                                            aria-describedby="passwordHelpInline">
                                        <label for="cPwdId">confirm password</label>
                                    </div>

                                    <div id="cPwdValid" class="valid-feedback">Passwords match.</div>
                                    <div id="cPwdInvalid" class="invalid-feedback">Confirm password must match with  password!</div>
                                </div>

                                <div class="form-line mt-3">
                                @foreach ($userdetails->user_field() as $field)
                                    @if ($field->type_field == 'dropdown')
                                        <div class="form-line">
                                            <div class="form-floating form-floating-outline mb-6">

                                                <select class="form-control p-2" id="user_entry_{{ $field->field_id }}"
                                                    name="user_entry[{{ $field->field_id }}]" required>
                                                    <option value="">Select an option...</option>
                                                    @foreach ($userdetails->user_field_son($field->field_id) as $son)
                                                        <option value="{{ $son->son_id }}">
                                                            {{ strtoupper($son->translation) }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="user_entry_{{ $field->field_id }}"
                                                    class="col-md-4 col-form-label">{{ strtoupper($field->translation) }}
                                                </label>
                                                <span class="valid-feedback" role="alert">
                                                    <strong>Looks good!</strong>
                                                </span>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Please enter the user's
                                                        {{ strtolower($field->translation) }}...</strong>
                                                </span>
                                            </div>
                                        </div>
                                    @elseif ($field->type_field == 'date')
                                        <div class="form-line">
                                            <div class="form-floating form-floating-outline mb-6">

                                                <input type="text" id="user_entry_{{ $field->field_id }}"
                                                    name="user_entry[{{ $field->field_id }}]" value=""
                                                    class="form-control" placeholder="Enter {{ $field->translation }}"
                                                    required>
                                                <label for="user_entry_{{ $field->field_id }}"
                                                    class="col-md-4 col-form-label">{{ $field->translation }}</label>
                                                <span class="valid-feedback" role="alert">
                                                    <strong>Looks good!</strong>
                                                </span>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Please enter the user's
                                                        {{ strtolower($field->translation) }}...</strong>
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <?php /* ?> ?>

                                        <div class="form-floating form-floating-outline mb-6">
                                            <div class="form-line">
                                                <input type="text" id="user_entry_{{ $field->field_id }}"
                                                    name="user_entry[{{ $field->field_id }}]" value=""
                                                    class="form-control" placeholder="Enter {{ $field->translation }}"
                                                    required>
                                                <label for="user_entry_{{ $field->field_id }}"
                                                    class="col-md-4 col-form-label">{{ $field->translation }}</label>
                                                <span class="valid-feedback" role="alert">
                                                    <strong>Looks good!</strong>
                                                </span>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Please enter the user's
                                                        {{ strtolower($field->translation) }}...</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <?php */ ?>
                                    @endif
                                @endforeach
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                        <button class="btn btn-danger active float-right ms-3" id="submitBtn"
                                            type="submit">{{ __('Save') }}</button>
                                        <a href="{{ route('profilehub.admin.users') }}"
                                            class="btn btn-primary active float-right ms-3">{{ __('Cancel') }}</a>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
    <script>
        (function() {
            $('.disable-autofill').focus(function() {
                $(this).attr('autocomplete', 'new-password');
            });
            $('.disable-autofill').blur(function() {
                $(this).removeAttr('autocomplete');
            });
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            if ($('input[type=checkbox]:checked').length > 0) {
                                $('input[type=checkbox]').prop('required', false);
                            } else {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        $('#pwdId, #cPwdId').on('keyup', function() {
                            var cPwdValid = document.getElementById('cPwdValid');
                            var cPwdInvalid = document.getElementById('cPwdInvalid');
                            if ($('#pwdId').val() != '' && $('#cPwdId').val() != '' &&
                                $('#pwdId').val() == $('#cPwdId').val()) {
                                $("#submitBtn").attr("disabled", false);
                                $('#cPwdValid').show();
                                $('#cPwdInvalid').hide();
                                cPwdValid.style.display = "block";
                                cPwdInvalid.style.display = "none";
                                cPwdValid.classList.add('was-validated');
                            } else {
                                $("#submitBtn").attr("disabled", true);
                                $('#cPwdValid').hide();
                                $('#cPwdInvalid').show();
                                cPwdInvalid.style.display = "block";
                                cPwdValid.style.display = "none";

                            }
                        });
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#username").keyup(function(e) {
                e.preventDefault();
                var username = document.getElementById('username').value;
                console.log(username);
                if (username === '') {
                    $("#submitBtn").attr("disabled", true);
                    $('#unValid').hide();
                    $('#unInvalid').show();
                    $('#unInvalid').html('Username [' + username + '] is invalid! Please try another one').css(
                        'color',
                        'red');
                    $('.un').addClass('is-invalid');
                    return false;
                }else{   
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('profilehub::ajax.userdetails.validate') }}",
                        async: false,
                        data: {
                            'username': username
                        },
                        success: function(data) {
                            result = data;
                            if (result === 'valid') {
                                $("#submitBtn").attr("disabled", false);
                                $('#valid_feedback_username').css("display", "block");
                                $('#invalid_feedback_username').css("display", "none");
                                $('#valid_feedback_username').html('Username [' + username + '] is valid').css('color','green');
                                $('.un').removeClass('is-invalid')
                                return true;
                            } else if (result === 'invalidlenght') {
                                $("#submitBtn").attr("disabled", true);
                                $('#valid_feedback_username').css("display", "none");
                                $('#invalid_feedback_username').css("display", "block");
                                $('#invalid_feedback_username').html('Username [' + username +
                                        '] is less than 8 characters!')
                                    .css('color', 'red');
                                $('.un').addClass('is-invalid');
                                return false;
                            } else if (result === 'username-found') {   
                                $("#submitBtn").attr("disabled", true);
                                $('#valid_feedback_username').css("display", "none");
                                $('#invalid_feedback_username').css("display", "block");
                                $('#invalid_feedback_username').html('Please enter another valid username. The username [' +username +'] is already registered!').css('color','red');
                                $('.un').addClass('is-invalid');
                                return false;
                            } else {
                                $("#submitBtn").attr("disabled", true);
                                $('#valid_feedback_username').css("display", "none");
                                $('#invalid_feedback_username').css("display", "block");
                                $('#invalid_feedback_username').html('Username [' + username +'] exists! Please try another one').css('color', 'red');
                                $('.un').addClass('is-invalid');
                                return false;
                            }
                        }
                    });
                }

            });
            $("#email").keyup(function(e) {
                //e.preventDefault();
                var username = document.getElementById('email').value;
                if (username === '') {
                    $("#submitBtn").attr("disabled", true);
                    $('#emValid').hide();
                    $('#emInvalid').show();
                    $('#emInvalid').html('Email [' + username + '] is invalid! Please try another one').css(
                        'color',
                        'red');
                    $('.un').addClass('is-invalid');
                    return false;
                }
                $.ajax({
                    type: 'POST',
                    url: "{{ route('profilehub::ajax.userdetails.validate') }}",
                    async: false,
                    data: {
                        'email': username
                    },
                    success: function(data) {
                        result = data;
                        if (result === 'valid') {
                            $("#submitBtn").attr("disabled", false);
                            $('#valid_feedback_email').css("display", "block");
                            $('#invalid_feedback_email').css("display", "none");
                            $('#emValid').html('Email [' + username + '] is valid').css('color','green');
                            $('.un').removeClass('is-invalid')
                            return true;
                        } else if (result === 'invalidlenght') {
                            $("#submitBtn").attr("disabled", true);
                            $('#valid_feedback_email').css("display", "none");
                            $('#invalid_feedback_email').css("display", "block");
                            $('#emInvalid').html('Email [' + username + '] is invalid!').css('color',  'red');
                            $('.un').addClass('is-invalid');
                            return false;
                        } else if (result === 'invalid-email') {
                            $("#submitBtn").attr("disabled", true);
                            $('#valid_feedback_email').css("display", "none");
                            $('#invalid_feedback_email').css("display", "block");
                            $('#invalid_feedback_email').html('Please enter a valid email address. Email [' + username + '] is invalid!').css('color', 'red');
                            $('.un').addClass('is-invalid');
                            return false;
                        } else if (result === 'email-found') {
                            $("#submitBtn").attr("disabled", true);
                            $('#valid_feedback_email').css("display", "none");
                            $('#invalid_feedback_email').css("display", "block");
                            $('#invalid_feedback_email').html('Please enter another valid email address. Email [' +username +'] is already registered!').css('color', 'red');
                            $('.un').addClass('is-invalid');
                            return false;
                        } else {
                            $("#submitBtn").attr("disabled", true);
                            $('#valid_feedback_email').css("display", "none");
                            $('#invalid_feedback_email').css("display", "block");
                            $('#emInvalid').html('Email [' + username + '] exists! Please try another one').css('color', 'red');
                            $('.un').addClass('is-invalid');
                            return false;
                        }
                    }
                });

            });
            $('.un').on('keyup', function(e) {
                $(this).val($(this).val().replace(/\s/g, ''));
            });
            $('.em').on('keyup', function(e) {
                $(this).val($(this).val().replace(/\s/g, ''));
            });

        })();

        function pwdStrengthChecker(usrPassword) {
            var strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})')
            var mediumPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})')
                        if (mediumPassword.test(usrPassword.value)) {
                return strongPwd();
            } else {
                return weakPwd();
            }
                                }

        function weakPwd() {
            var strongDiv = document.getElementById('password-strength-strong');
            var weakDiv = document.getElementById('password-strength-weak');
            strongDiv.style.display = "none";
            weakDiv.style.display = "block";
            $("#submitBtn").attr("disabled", true);
            $('#password-strength-weak').addClass('bg-danger');
            $('#password-strength-strong').removeClass('bg-success')
        }

        function strongPwd() {
            var strongDiv = document.getElementById('password-strength-strong');
            var weakDiv = document.getElementById('password-strength-weak');
            strongDiv.style.display = "block";
            weakDiv.style.display = "none";
            $("#submitBtn").attr("disabled", false);
            $('#password-strength-strong').addClass('bg-success');
            $('#password-strength-weak').removeClass('bg-danger');

        }

        function comparePwds() {
            var cPwdValid = document.getElementById('cPwdValid');
            var cPwdInvalid = document.getElementById('cPwdInvalid');
            if ($('#pwdId').val() != '' && $('#cPwdId').val() != '' && $('#pwdId').val() == $('#cPwdId').val()) {
                $("#submitBtn").attr("disabled", false);
                $('#cPwdValid').show();
                $('#cPwdInvalid').hide();
                cPwdValid.style.display = "block";
                cPwdInvalid.style.display = "none";
                cPwdValid.classList.add('was-validated');
            } else {
                $("#submitBtn").attr("disabled", true);
                $('#cPwdValid').hide();
                $('#cPwdInvalid').show();
                cPwdInvalid.style.display = "block";
                cPwdValid.style.display = "none";
            }
        }
    </script>
@endsection
