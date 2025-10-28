@extends('vendor.profilehub.layouts.admin')
@inject('userdetails', 'BabeRuka\ProfileHub\Models\UserFieldDetails')
@section('css')
    <style>
        .table td.fit,
        .table th.fit {
            white-space: nowrap;
            width: 1%;
        }
    </style>
@endsection
@section('content')
    <?php
    $url_img = url('files/user');
    $profile_pic = $user->profile_pic != '' ? $url_img . '/' . $user->profile_pic : $url_img . '/blank-user.png';
    $num_rows = 5;
    $num_filled = 0;
    ?>

    <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> {{ __('Profile') }}</div>

                        <div class="card-body">
                            <div class="body">

                                <div class="row">
                                    <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <p><img class="img-fluid rounded-circle" src="<?php echo $profile_pic; ?>"
                                                                alt="card image"></p>
                                                        <h4 class="card-title">{{ $user->name }}</h4>

                                                        <a href="{{ route('profilehub::profile.edit', ['id' => $user->id]) }}"
                                                            class="btn btn-primary">
                                                            <i class="c-icon cil-pencil active"></i>
                                                        </a>

                                                        <a href="#" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#forceModal" data-placement="top" title="Roles">
                                                            <i class="c-icon cil-lock-locked active"></i>
                                                        </a>

                                                        <a data-toggle="modal" href="#" data-target="#permModal"
                                                            class="btn btn-primary" data-placement="top"
                                                            title="Permissions">
                                                            <i class="c-icon cil-lock-unlocked active"></i>
                                                        </a>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="card">
                                                    <div class="card-header bg-light-green">
                                                        <a class="card-title text-black"><strong>Names</strong></a>
                                                    </div>
                                                    <div class="card-body text-left text-left">
                                                    <div class="row">
                                                        <div class=""><strong>Username:</strong>
                                                            {{ $user->username }}
                                                            <?php $num_filled = $user->username ? $num_filled + 1 : $num_filled + 0; ?>
                                                        </div>
                                                        <hr />
                                                        <div class=""><strong>Firstname:</strong>
                                                            {{ $user->firstname }}
                                                            <?php $num_filled = $user->firstname ? $num_filled + 1 : $num_filled + 0; ?>
                                                        </div>
                                                        <hr />
                                                        <div class=""><strong>Lastname:</strong>
                                                            {{ $user->lastname }}
                                                            <?php $num_filled = $user->lastname ? $num_filled + 1 : $num_filled + 0; ?>
                                                        </div>
                                                        <hr />
                                                        <div class=""><strong>Email:</strong>
                                                            {{ $user->email }}
                                                            <?php $num_filled = $user->email ? $num_filled + 1 : $num_filled + 0; ?>
                                                        </div>
                                                        <hr />
                                                    </div>
                                                    <div class="row">
                                                        <strong>Bio:</strong>
                                                        <div class="card-text"><?php echo $user->user_bio; ?></div>
                                                        <?php $num_filled = $user->user_bio ? $num_filled + 1 : $num_filled + 0; ?>
                                                        <hr />
                                                    </div>
                                                    </div>
                                                </div>

                                                @foreach ($userdetails->user_field_groups() as $group)
                                                    <div class="card">

                                                        <div class="card-header bg-light-green">
                                                            <a
                                                                class="card-title text-black"><strong>{{ $group->group_name }}</strong></a>
                                                        </div>
                                                        <div class="card-body text-left">
                                                            @foreach ($userdetails->user_field(0, $group->group_id) as $field)
                                                                <div class="">
                                                                    @if ($field->type_field == 'table')
                                                                        @php
                                                                            $son_fields = $userdetails->user_field_son($field->field_id);
                                                                        @endphp
                                                                        @include('profilehub::admin.user.parts.table')
                                                                    @else
                                                                        <strong>{{ $field->translation }}:</strong>
                                                                        {{ $user_entry = $userdetails->one_user_field_details($field->field_id, $user->user_id) }}
                                                                        <?php $num_filled += $user_entry ? 1 : 0; ?>
                                                                    @endif
                                                                </div>
                                                                <hr />
                                                                @php
                                                                    $num_rows++;
                                                                @endphp
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- permission Modal start-->
    <div class="modal fade" id="forceModal" tabindex="-1" role="dialog" aria-labelledby="forceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="needs-validation" action="{{ action('AdminUsersController@createrecord') }}" id="forceform"
                    method="POST" enctype="multipart/form-data" novalidate>
                    @method('POST')
                    @csrf
                    <input type="hidden" name="function" value="force-profile-update" />
                    <input type="hidden" name="user_id" value="{{ $user->id }}" />
                    <input type="hidden" name="num_rows" id="num_rows" value="{{ $num_rows }}" />
                    <input type="hidden" name="num_filled" id="num_filled" value="{{ $num_filled }}" />
                    <div class="modal-header">
                        <div class="container">
                            <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times; </span>
                            </button>
                            <div id="confirmChangePermTitle">Force Profile Update</div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                    <h4 class="mb-3"></h4>
                                    <div class="row">
                                        <div class="col-form-label ml-3">
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input" type="radio" id="pforce" name="pforce"
                                                    value="1" @php echo ($force != null && $force->pforce==1 ? 'checked="checked"' : '') @endphp>
                                                <label class="form-check-label" for="pforce">Force
                                                    {{ $user->firstname }} {{ $user->lastname }} to update all profile
                                                    fields</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                    <button class="btn btn-danger active float-right" type="submit">Save</button>
                                    <button type="button" class="btn btn-secondary mr-3 float-right"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal end -->

    <!-- permission Modal start-->
    <div class="modal fade" id="permModal" tabindex="-1" role="dialog" aria-labelledby="permLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="needs-validation" action="{{ route('profilehub.admin.users.createrecord') }}" id="permForm" mult
                    method="POST" enctype="multipart/form-data" novalidate>
                    @method('POST')
                    @csrf
                    <input type="hidden" name="function" value="update-password" />
                    <input type="hidden" name="user" value="{{ $user->id }}" />
                    <div class="modal-header">
                        <div class="container">
                            <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times; </span>
                            </button>
                            <div id="confirmChangePermTitle">Change Password</div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                    <h4 class="mb-3"></h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="pwdId">Password</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input class="form-control" type="password" id="pwdId"
                                                        name="user_password" value="" placeholder="enter password"
                                                        minlength="6" required>
                                                </div>
                                                <div class="valid-feedback">Valid</div>
                                                <div class="invalid-feedback">a to z only (more than 6 letters)</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="cPwdId">Repeat Password</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input class="form-control" type="password" id="cPwdId"
                                                        name="user_password_repeat" value=""
                                                        placeholder="repeat password here..." minlength="6"
                                                        autocomplete="autocomplete_off_hack_xfr4!k"
                                                        onfocus="this.removeAttribute('readonly');" required>
                                                </div>
                                                <div id="cPwdValid" class="valid-feedback">confirm password must match
                                                    with password.</div>
                                                <div id="cPwdInvalid" class="invalid-feedback">a to z only (more than 6
                                                    letters)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                    <button class="btn btn-danger active float-right" type="submit">Save</button>
                                    <button type="button" class="btn btn-secondary mr-3 float-right"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal end -->
@endsection


@section('javascript')


@section('javascript')

    <script>
        window.jQuery || document.write(
            '<script src="{{ asset('addons/material-design/js/jquery-3.3.1.slim.min.js') }}"><\/script>')
    </script>
    <script src="{{ asset('addons/material-design/js/popper.min.js') }}"></script>
    <script src="{{ asset('addons/material-design/js/bootstrap-material-design.min.js') }}"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('addons/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('addons/material-design/js/holder.min.js') }}"></script>
    <!-- Jquery Validation Plugin Css -->
    <script src="{{ asset('addons/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('addons/material-design/js/pages/forms/form-validation.js') }}"></script>
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        $('#pwdId, #cPwdId').on('keyup', function() {
                            if ($('#pwdId').val() != '' && $('#cPwdId').val() != '' &&
                                $('#pwdId').val() == $('#cPwdId').val()) {
                                $("#saveProfile").attr("disabled", false);
                                $('#cPwdValid').show();
                                $('#cPwdInvalid').hide();
                                $('#cPwdValid').html('Valid').css('color', 'green');
                                $('.pwds').removeClass('is-invalid')
                            } else {
                                $("#saveProfile").attr("disabled", true);
                                $('#cPwdValid').hide();
                                $('#cPwdInvalid').show();
                                $('#cPwdInvalid').html('Not Matching').css('color',
                                    'red');
                                $('.pwds').addClass('is-invalid');
                            }
                        });
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

@endsection
