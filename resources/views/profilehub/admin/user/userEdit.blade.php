@extends('profilehub::layouts.app')
@inject('userdetails', 'BabeRuka\ProfileHub\Models\UserFieldDetails')
@inject('UserFunctions', 'BabeRuka\ProfileHub\Repository\UserFunctions')
@php
use BabeRuka\ProfileHub\Repository\UserAdmin;
$default_cols = $UserFunctions->default_userprofile_cols();
$input_types = $UserFunctions->input_types();
$url_img = url('files/user');
$profile_pic = $user->profile_pic != '' ? $url_img . '/' . $user->profile_pic : '';
$page_layout = $page_data->where('page_module', 'page_layout');
$html_inputs = $UserFunctions->input_type_group('html');
$custom_inputs = $UserFunctions->input_type_group('custom');
@endphp
@section('css')
@endsection

@section('content')
    <form class="needs-validation" action="{{ route('profilehub::profile.createrecord') }}" method="POST" enctype="multipart/form-data"
        novalidate>
        @csrf
        @method('POST')
        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
        <input type="hidden" name="function" id="function" value="manage-user">
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">

                    @if ($page_layout->first())
                        @if ($page_layout->first()->page_data == 'full')
                            <!-- full start -->
                            <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12 col-md-8">
                                <div class="card full">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title text-uppercase fw-bold"><i class="fa fa-align-justify"></i> {{ __('Edit') }} {{ $user->name }}</h5>
                                    </div>
                                    <hr /> 
                                    <div class="card-body">

                                        <!--avatar.blade.php-->
                                        @include('profilehub::admin.user.parts.edit.avatar')
                                        <!--default-fields.blade.php-->
                                        @include('profilehub::admin.user.parts.edit.default-fields')
                                        <!--additional-fields.blade.php-->
                                        @include('profilehub::admin.user.parts.edit.additional-fields')

                                    </div>
                                </div>

                                <div class="mb-6">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                            <button class="btn btn-danger active float-right me-3" type="submit"
                                                id="saveProfile">{{ __('Save') }}</button>
                                             
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- full end -->
                        @elseif($page_layout->first()->page_data == 'two_cards_left')
                            <div class="col-xl-3 col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!--avatar.blade.php-->
                                        @include('profilehub::admin.user.parts.edit.avatar')

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 col-sm-12">

                                <div class="card two_cards_left">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title text-uppercase fw-bold"><i class="fa fa-align-justify"></i> {{ __('Edit') }} {{ $user->name }} 
                                    </div>
                                    <hr />
                                    <div class="card-body">
                                        <!--default-fields.blade.php-->
                                        @include('profilehub::admin.user.parts.edit.default-fields')
                                        <!--additional-fields.blade.php-->
                                        @include('profilehub::admin.user.parts.edit.additional-fields')

                                         
                                            <div class="row mb-6">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                                    <button class="btn btn-danger active float-right me-3" type="submit"
                                                        id="saveProfile">{{ __('Save') }}</button>
                                                     
                                                </div>
                                            </div>
                                         

                                    </div>
                                </div>

                            </div>
                        @elseif($page_layout->first()->page_data == 'two_cards_right')
                            <div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 col-sm-12">

                                <div class="card two_cards_right">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title text-uppercase fw-bold"><i class="fa fa-align-justify"></i> {{ __('Edit') }} {{ $user->name }}
                                    </div>
                                    <hr />
                                    <div class="card-body">
                                        <!--default-fields.blade.php-->
                                        @include('profilehub::admin.user.parts.edit.default-fields')
                                        <!--additional-fields.blade.php-->
                                        @include('profilehub::admin.user.parts.edit.additional-fields')

                                        <div class="mb-6">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                                    <button class="btn btn-danger active float-right me-3" type="submit"
                                                        id="saveProfile">{{ __('Save') }}</button>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!--avatar.blade.php-->
                                        @include('profilehub::admin.user.parts.edit.avatar')

                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 col-sm-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title text-uppercase fw-bold"><i class="fa fa-align-justify"></i> {{ __('Edit') }} {{ $user->name }}</h5>
                                </div>
                                <hr />
                                <div class="card-body">
                                    <!--default-fields.blade.php-->
                                    @include('profilehub::admin.user.parts.edit.default-fields')
                                    <!--additional-fields.blade.php-->
                                    @include('profilehub::admin.user.parts.edit.additional-fields')

                                    <div class="mb-6">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                                <button class="btn btn-danger active float-right me-3" type="submit"
                                                    id="saveProfile">{{ __('Save') }}</button>
                                                 
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-4 col-md-4 col-xs-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <!--avatar.blade.php-->
                                    @include('profilehub::admin.user.parts.edit.avatar')

                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="delTableModal" tabindex="-1" role="dialog" aria-labelledby="delTableModalModalLabel"
        aria-modal="true">
        <form action="{{ route('profilehub::admin.users.profile.userdetails.createrecord', ['id' => 0]) }}" id="delTableModalModalForm"
            method="POST" novalidate="">
            <input type="hidden" name="function" value="del-table-data" />
            <input type="hidden" name="page_row" id="page_row_del" value="0" />
            <input type="hidden" name="field_id" id="field_id_del" value="0" />
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            @csrf
            @method('POST')
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="container">
                            <h5 class="modal-title" id="title_del"><i class="fa fa-exclamation-circle text-danger"
                                    aria-hidden="true"></i>Confirm Table Row Delete</h5>
                        </div>
                        <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <hr />
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <label for="event_title" id="msg_del"></label>
                                    <div class="form-group">
                                        <div class="form-line">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="event_edit_settings">
                                    <button class="btn btn-danger float-right active ml-3" type="submit">delete</button>
                                    <button type="button" class="btn btn-secondary mr-3 float-right"
                                        data-dismiss="modal">Close </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
     
    <script src="{{ asset('addons/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('addons/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    </script>

    <script>
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
        function popDelTable(field_id, rowid, title) {
            //17,1,'Country','Education History'
            document.getElementById('title_del').innerHTML =
                '<i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i> Please confirm delete!';
            document.getElementById('msg_del').innerHTML = 'Please confirm if you want to delete row #' + rowid + ' of ' +
                title + ' user details table ';
            document.getElementById('page_row_del').value = rowid;
            document.getElementById('field_id_del').value = field_id;
        }
        $(function() {
            $(".bootstrap_datepicker").datepicker({
                format: "yyyy-mm",
                uiLibrary: 'bootstrap'
            });
            /*
            $('[data-dropdowns]').dynamicrows({
                animation: 'fade',
                copy_values: true,
                minrows: 2

            });
            */
        });

        $(document).ready(function() {
            $('.dropify').dropify({
                messages: {
                    'default': '',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong happended.'
                }
            });
            $('#datatables').DataTable();

            var clones = 1;
            // Clone element @ a max of 5
            $('.clone-field').click(function() {
                if (clones < 5) {
                    $('.dynamic-element').first().clone().appendTo('.cloned-data').show();
                    $('.dynamic-element .mdi').last().removeClass(
                        'mdi-plus-circle-outline text-success clone-field');
                    $('.dynamic-element .mdi').last().addClass(
                        'fa fa-minus mdi-minus-circle-outline text-danger remove-field');
                    attach_fileName();
                    attach_delete();
                    clones++;
                }
            });
            // Attach functionality to delete buttons
            function attach_delete() {
                $('.remove-field').off();
                $('.remove-field').click(function() {
                    $(this).closest('.dynamic-element').remove();
                    clones--;
                });
            }
            // Bootstrap custom file input file name
            function attach_fileName() {
                $(".custom-file-input").on("change", function() {
                    var fileName = $(this).val().split("\\").pop();
                    var label = $(this).siblings(".custom-file-label");
                    if (label.data("default-title") === undefined) {
                        label.data("default-title", label.html());
                    }
                    if (fileName === "") {
                        label.removeClass("selected").html(label.data("default-title"));
                    } else {
                        label.addClass("selected").html(fileName);
                    }
                });
            }
        });
  
        window.jQuery || document.write(
            '<script src="{{ asset('addons/material-design/js/jquery-3.3.1.slim.min.js') }}"><\/script>')
 
        // Example starter JavaScript for disabling form submissions if there are invalid fields
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
                                //event.preventDefault();
                                //event.stopPropagation();
                            }
                        });
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
     
    <script src="{{ asset('addons/tinymce/5.8.1/js/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        function stringify(x) {
            console.log(Object.prototype.toString.call(x));
        }
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
        tinymce.init({
            selector: 'textarea',
            toolbar_mode: 'floating',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullpage | ' +
                'forecolor backcolor emoticons | help',
            menu: {
                file: {
                    title: 'File',
                    items: 'newdocument restoredraft | preview | print '
                },
                edit: {
                    title: 'Edit',
                    items: 'undo redo | cut copy paste | selectall | searchreplace'
                },
                view: {
                    title: 'View',
                    items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen'
                },
                insert: {
                    title: 'Insert',
                    items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime'
                },
                format: {
                    title: 'Format',
                    items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat'
                },
                tools: {
                    title: 'Tools',
                    items: 'spellchecker spellcheckerlanguage | code wordcount'
                },
                table: {
                    title: 'Table',
                    items: 'inserttable | cell row column | tableprops deletetable'
                },
                help: {
                    title: 'Help',
                    items: 'help'
                }
            },
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });

        function routeGo(url) {
            location.href = url;
        }
        $(document).on("click", "#password_change", function(e) {
            if (e.target.checked) {
                //alert(e.target.value);
                $('#pwdId').prop('required', true);
                $('#cPwdId').prop('required', true);
            } else {
                $('#pwdId').prop('required', false);
                $('#cPwdId').prop('required', false);
            }
        });
        $(document).ready(function() {
            $('#assignRolestable').DataTable({
                "scrollX": false
            });
        });
    </script>
@endsection
