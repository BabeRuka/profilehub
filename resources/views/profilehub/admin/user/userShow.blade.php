@extends('vendor.profilehub.layouts.admin')
@inject('userdetails', 'BabeRuka\ProfileHub\Models\UserFieldDetails')
    @inject('UserFunctions', 'BabeRuka\ProfileHub\Repository\UserFunctions')
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
    $profile_pic = $user_detail->profile_pic != '' ? $url_img . '/' . $user_detail->profile_pic : $url_img . '/blank-user.png';
    $num_rows = 5;
    $num_filled = 0;
    $page_layout = $page_data->where('page_module', 'page_layout');
    ?>
        <div class="card">
            <div class="card-body">

            <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="row">

                    @if ($page_layout->first())
                        @if ($page_layout->first()->page_data == 'full')
                            <!-- full start -->
                            <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12 col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-align-justify"></i> {{ __('Edit') }} {{ $user->name }}
                                    </div>
                                    <div class="card-body">

                                        <!--avatar.blade.php-->
                                        @include('profilehub::admin.user.parts.view.avatar')
                                        <!--default-fields.blade.php-->
                                        @include('profilehub::admin.user.parts.view.default-fields')
                                        <!--additional-fields.blade.php-->
                                        @include('profilehub::admin.user.parts.view.additional-fields')

                                    </div>
                                </div>


                            </div>
                            <!-- full end -->
                        @elseif($page_layout->first()->page_data == 'two_cards_left')
                            <div class="col-xl-3 col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!--avatar.blade.php-->
                                        @include('profilehub::admin.user.parts.view.avatar')

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 col-sm-12">

                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-align-justify"></i> {{ __('Edit') }} {{ $user->name }}
                                    </div>
                                    <div class="card-body">
                                        <!--default-fields.blade.php-->
                                        @include('profilehub::admin.user.parts.view.default-fields')
                                        <!--additional-fields.blade.php-->
                                        @include('profilehub::admin.user.parts.view.additional-fields')



                                    </div>
                                </div>

                            </div>
                        @elseif($page_layout->first()->page_data == 'two_cards_right')
                            <div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 col-sm-12">

                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-align-justify"></i> {{ __('Edit') }} {{ $user->name }}
                                    </div>
                                    <div class="card-body">
                                        <!--default-fields.blade.php-->
                                        @include('profilehub::admin.user.parts.view.default-fields')
                                        <!--additional-fields.blade.php-->
                                        @include('profilehub::admin.user.parts.view.additional-fields')



                                    </div>
                                </div>

                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!--avatar.blade.php-->
                                        @include('profilehub::admin.user.parts.view.avatar')

                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> {{ __('Edit') }} {{ $user->name }}
                                </div>
                                <div class="card-body">
                                    <!--default-fields.blade.php-->
                                    @include('profilehub::admin.user.parts.view.default-fields')
                                    <!--additional-fields.blade.php-->
                                    @include('profilehub::admin.user.parts.view.additional-fields')



                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-4 col-md-4 col-xs-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <!--avatar.blade.php-->
                                    @include('profilehub::admin.user.parts.view.avatar')

                                </div>
                            </div>
                        </div>
                    @endif



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
                    <form class="needs-validation"
                        action="{{ route('profilehub.admin.users.createrecord') }}" id="forceform"
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
                                                    <input class="form-check-input" type="radio" id="pforce"
                                                        name="pforce" value="1"
                                                        <?php echo ($force != null && $force->pforce==1 ? 'checked="checked"' : '') ?>
                                                        <label class="form-check-label" for="pforce">Force
                                                    {{ $user->firstname }} {{ $user->lastname }} to update all
                                                    profile fields</label>
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

         
        @include('profilehub::admin.users.modals.edit-user-password-modal')
        @endsection


        @section('javascript')


        @section('javascript')

         
        <script>
            (function () {
                'use strict';
                window.addEventListener('load', function () {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener('submit', function (event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            $('#pwdId, #cPwdId').on('keyup', function () {
                                if ($('#pwdId').val() != '' && $('#cPwdId').val() !=
                                    '' &&
                                    $('#pwdId').val() == $('#cPwdId').val()) {
                                    $("#saveProfile").attr("disabled", false);
                                    $('#cPwdValid').show();
                                    $('#cPwdInvalid').hide();
                                    $('#cPwdValid').html('Valid').css('color',
                                        'green');
                                    $('.pwds').removeClass('is-invalid')
                                } else {
                                    $("#saveProfile").attr("disabled", true);
                                    $('#cPwdValid').hide();
                                    $('#cPwdInvalid').show();
                                    $('#cPwdInvalid').html('Not Matching').css(
                                        'color',
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
