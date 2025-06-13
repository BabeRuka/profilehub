@extends('vendor.profilehub.layouts.admin')
@inject('userdetails', 'BabeRuka\ProfileHub\Models\UserFieldDetails')
@section('css')
 @endsection
<?php
$url_img = url('files/user');
$profile_pic = $user->profile_pic != '' ? $url_img . '/' . $user->profile_pic : '';
?>
@section('content')
    <form class="needs-validation" action="{{ route('profilehub::profile.createrecord') }}" method="POST" enctype="multipart/form-data"
        novalidate>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i> {{ __('Edit') }} {{ $user->name }}
                            </div>
                            <div class="card-body">

                                @csrf
                                @method('POST')
                                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                                <input type="hidden" name="function" id="function" value="manage-user">

                                Profile Photo
                                <hr />
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="file" name="profile_pic" id="profile_pic"
                                                    data-show-loader="false" data-allowed-file-extensions="jpg png jpeg"
                                                    class="dropify" data-default-file="{{ $profile_pic }}"
                                                    {{ $profile_pic == '' ? 'required' : '' }} />
                                                <div class="invalid-feedback">
                                                    Profile Picture is required.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                Personal Info
                                <hr />
                                <div class="card">
                                    <div class="card-body">

                                        <label for="email_address">Username</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="username" name="username"
                                                    value="{{ $user->username }}" class="form-control"
                                                    placeholder="Enter your username..." readonly disabled>
                                            </div>
                                        </div>

                                        <label for="email_address">firstname</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="firstname" name="firstname"
                                                    value="{{ $user->firstname }}" class="form-control"
                                                    placeholder="Enter your firstname..." required>
                                            </div>
                                        </div>

                                        <label for="email_address">lastname</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="lastname" name="lastname"
                                                    value="{{ $user->lastname }}" class="form-control"
                                                    placeholder="Enter your lastname..." required>
                                            </div>
                                        </div>


                                        <label for="email_address">email</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="email" name="email"
                                                    value="{{ $user->email }}" class="form-control"
                                                    placeholder="{{ __('E-Mail Address') }}" required>
                                            </div>
                                        </div>

                                        <label for="email_address">About me</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea id="user_bio" name="user_bio" class="form-control" placeholder="{{ __('About me') }}" required>{{ $user->user_bio }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                Password
                                <hr />
                                <div class="card">
                                    <div class="card-body">

                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" id="password_change"
                                                value="1">
                                            <label class="form-check-label" for="password_change">Require password
                                                change?</label>
                                        </div>

                                        <label for="pwdId">Password</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input class="form-control" type="text" id="pwdId"
                                                    name="user_password" value="" placeholder="enter password"
                                                    minlength="6">
                                            </div>
                                            <div class="valid-feedback">Valid</div>
                                            <div class="invalid-feedback">a to z only (more than 6 letters)</div>
                                        </div>

                                        <label for="cPwdId">Repeat Password</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input class="form-control" type="text" id="cPwdId"
                                                    name="user_password_repeat" value=""
                                                    placeholder="repeat password here..." minlength="6"
                                                    autocomplete="autocomplete_off_hack_xfr4!k"
                                                    onfocus="this.removeAttribute('readonly');">
                                            </div>
                                            <div id="cPwdValid" class="valid-feedback">confirm password must match with
                                                password.</div>
                                            <div id="cPwdInvalid" class="invalid-feedback">a to z only (more than 6
                                                letters)
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                Additional Fields
                                <hr />
                                @foreach ($userdetails->user_field_groups() as $group)
                                    <div class="card">
                                        <div class="card-header">
                                            {{ $group->group_name }}
                                        </div>
                                        <div class="card-body">

                                            @foreach ($userdetails->user_field(0, $group->group_id) as $field)
                                                @if ($field->type_field == 'table')
                                                    @php
                                                        $son_fields = $userdetails->user_field_son($field->field_id);
                                                    @endphp
                                                    @include('profilehub::admin.user.parts.table-edit')
                                                @elseif ($field->type_field == 'dropdown')
                                                    <label
                                                        for="user_entry_{{ $field->field_id }}">{{ strtoupper($field->translation) }}
                                                    </label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select class="form-control p-2"
                                                                id="user_entry_{{ $field->field_id }}"
                                                                name="user_entry[{{ $field->field_id }}]" required>
                                                                <option value="">Select an option...</option>
                                                                @foreach ($userdetails->user_field_son($field->field_id) as $son)
                                                                    <option value="{{ $son->son_id }}"
                                                                        {{ $son->translation == $userdetails->one_user_field_details($field->field_id, $user->id) ? 'selected="selected"' : '' }}>
                                                                        {{ strtoupper($son->translation) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @elseif ($field->type_field == 'date')
                                                    <label
                                                        for="user_entry_{{ $field->field_id }}">{{ $field->translation }}</label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="text"
                                                                id="user_entry_{{ $field->field_id }}"
                                                                name="user_entry[{{ $field->field_id }}]"
                                                                value="{{ $userdetails->one_user_field_details($field->field_id, $user->id) }}"
                                                                class="form-control"
                                                                placeholder="Enter {{ $field->translation }}" required>
                                                        </div>
                                                    </div>
                                                @elseif ($field->type_field == 'country')
                                                    <label
                                                        for="user_entry_{{ $field->field_id }}">{{ $field->translation }}</label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select class="form-control p-2"
                                                                id="user_entry_{{ $field->field_id }}"
                                                                name="user_entry[{{ $field->field_id }}]" required>
                                                                <option value="">Select an option...</option>
                                                                @foreach ($all_countries as $country)
                                                                    <option value="{{ $country->country_code }}"
                                                                        {{ $country->country_code == $userdetails->one_user_field_details($field->field_id, $user->id) ? 'selected="selected"' : '' }}>
                                                                        {{ strtoupper($country->country_name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @else
                                                    <label
                                                        for="user_entry_{{ $field->field_id }}">{{ $field->translation }}</label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="text"
                                                                id="user_entry_{{ $field->field_id }}"
                                                                name="user_entry[{{ $field->field_id }}]"
                                                                value="{{ $userdetails->one_user_field_details($field->field_id, $user->id) }}"
                                                                class="form-control"
                                                                placeholder="Enter {{ $field->translation }}" required>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                    <button class="btn btn-danger active float-right ml-3" type="submit"
                                        id="saveProfile">{{ __('Save') }}</button>
                                    <a href="{{ Route::currentRouteName() == 'profile.edit' ? route('profilehub::profile.index') : route('profilehub.admin.users') }}"
                                        class="btn btn-primary active float-right  ml-3">{{ __('Return') }}</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="delTableModal" tabindex="-1" role="dialog" aria-labelledby="delTableModalModalLabel"
    aria-modal="true">
    <form action="{{ action('AdminUserDetailsController@createrecord',['id'=>0]) }}" id="delTableModalModalForm" method="POST"
        novalidate="">
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
                        <h5 class="modal-title" id="title_del"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i>Confirm Table Row Delete</h5>
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
    <script src="{{ asset('addons/datatables/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('addons/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('addons/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('addons/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('addons/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('addons/jquery-dynamicrows/js/dynamicrows.js') }}"></script>
    <script>
        function popDelTable(field_id,rowid,title){
            //17,1,'Country','Education History'
            document.getElementById('title_del').innerHTML = '<i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i> Please confirm delete!';
            document.getElementById('msg_del').innerHTML = 'Please confirm if you want to delete row #'+rowid+' of '+title+' user details table ';
            document.getElementById('page_row_del').value = rowid;
            document.getElementById('field_id_del').value = field_id;
            //msg_del
            //page_row_del
            //field_id_del
        }
        $(function() {
            $(".bootstrap_datepicker").datepicker({
                format: "yyyy-mm",
                uiLibrary: 'bootstrap'
            });
            $('[data-dropdowns]').dynamicrows({
                animation: 'fade',
                copy_values: true,
                minrows: 2

            });
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
                    //var tablerow = $(this).data('tablerow');
                    //var tablenum = tablenum + tablerow;
                    //$(".tablenum").text(clones);
                    $('.dynamic-element').first().clone().appendTo('.cloned-data').show();
                    $('.dynamic-element .mdi').last().removeClass('mdi-plus-circle-outline text-success clone-field');
                    $('.dynamic-element .mdi').last().addClass('fa fa-minus mdi-minus-circle-outline text-danger remove-field');
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
    </script>
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
    <script src="{{ asset('addons/bootbox/bootbox.min.js') }}"></script>
    <script src="{{ asset('addons/bootbox/bootbox.locales.min.js') }}"></script>
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
