@extends('profilehub::layouts.app')
@inject('userdetails', 'BabeRuka\ProfileHub\Models\UserDetails')
@inject('UserFunctions', 'BabeRuka\ProfileHub\Repository\UserFunctions')
@inject('UserAdmin', 'BabeRuka\ProfileHub\Repository\UserAdmin')
@php
    $default_cols = $UserFunctions->default_userprofile_cols();
    $default_userdetails_cols = $UserFunctions->default_userdetails_cols();
    $input_types = $UserFunctions->input_types();
    $settings_arr = $UserAdmin->admin_pages();
    $url_img = url('files/pages/banners/');
    $page_image = $all_page_data->where('page_key', 'page_image');
    $banner_image = $page_image != '' && $page_image->first() ? $url_img . '/' . $page_image->first()->page_data : '';
    $num_rows = 5;
    $num_filled = 0;
@endphp
@section('css')
    <style>
         

        .enabled {
            color: green !important; 
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title text-uppercase fw-bold"><i class="fa fa-align-justify"></i> Edit Page
                        [{{ request('page_name') }}]</h5>
                    <div>
                        <a href="{{ route('profilehub::admin.layout.pages') }}" class="btn btn-primary float-right"><i
                                class="fa fa-solid fa-backward me-2"></i> Back to all pages</a>
                    </div>
                </div>
                <hr />
                <form class="needs-validation" method="POST" action="{{ route('profilehub::admin.layout.pages.createrecord') }}"
                    method="POST" enctype="multipart/form-data" novalidate>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @if (Session::has('success'))
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ Session::get('success') }}</strong>
                                    </div>
                                @endif
                                @if (Session::has('error'))
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ Session::get('error') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="{{ $page->page_type == 3 ? 'col-xl-8 col-md-8 col-xxl-8 col-xs-12 col-sm-12' : 'col-12' }}">
                                <div class="">
                                    <div class="card-body">


                                        <input type="hidden" name="page_id" id="page_id" value="{{ $page->page_id }}" />
                                        <input type="hidden" name="function" value="edit-page">
                                        @csrf

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <h1 class="display-page h4"><strong>Default</strong></h1>
                                                <hr />
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-xxl-6 col-xs-12 col-sm-12">
                                                <label>Page Type</label>
                                                <div class="form-group">
                                                    <select class="form-control" name="page_type" id="page_type"
                                                        onchange="changeSubMethod(this)" required>
                                                        <option value="">Please select a page type...</option>
                                                        <option value="1"
                                                            {{ $page->page_type == 1 ? 'selected="selected"' : '' }}>
                                                            LMS Page
                                                        </option>
                                                        <option value="2"
                                                            {{ $page->page_type == 2 ? 'selected="selected"' : '' }}>
                                                            Course
                                                            Page
                                                        </option>
                                                        <option value="3"
                                                            {{ $page->page_type == 3 ? 'selected="selected"' : '' }}>
                                                            Public
                                                            Page
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-md-6 col-xxl-6 col-xs-12 col-sm-12">
                                                <label>Page Settings</label>
                                                <div class="form-group">
                                                    <select class="form-control" name="page_settings" id="page_settings"
                                                        onchange="controlContent(this)" required>
                                                        <option value="">Please select...</option>
                                                        @foreach ($settings_arr as $setting_name => $setting_key)
                                                            <option value="{{ $setting_key }}"
                                                                {{ $page->page_settings == $setting_key ? 'selected' : '' }}>
                                                                {{ $setting_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label>Title</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text"
                                                        placeholder="{{ __('Title') }}" name="page_name"
                                                        value="{{ $page->page_name }}" required />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mb-3" id="content_sub_div"
                                            style="{{ $page->page_type == 3 ? 'display:block' : 'display:none' }}">
                                            <div class="col">
                                                <label>Short Description</label>
                                                <div class="form-group">
                                                    <textarea class="form-control ignoreTm" id="page_desc" name="page_desc" rows="4"
                                                        placeholder="{{ __('Short Description..') }}">{{ $page->page_desc }}</textarea>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row mb-3" id="content_div"
                                            style="{{ $page->page_type == 3 ? 'display:block' : 'display:none' }}">
                                            <div class="col">
                                                <label>Content</label>
                                                <div class="form-group">
                                                    <textarea class="form-control" id="page_content" name="page_content" rows="9"
                                                        placeholder="{{ __('Content..') }}">{{ $page->page_content }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $page_layout_1 = $all_page_data->where('page_data', 'full');
                                        $page_layout_2 = $all_page_data->where('page_data', 'two_cards_left');
                                        $page_layout_3 = $all_page_data->where('page_data', 'two_cards_right');
                                        $group_settings = $all_page_data->where('page_module', 'group_settings');
                                        $registration_types = $all_page_data->where('page_module', 'registration_type');
                                        $page_input_required = $all_page_data->where('page_key', 'page_input_required');
                                        $page_input = $all_page_data->where('page_key', 'page_input');
                                        if ($group_settings->first()) {
                                            $has_group_setting = $group_settings->first();
                                            $group_setting = $has_group_setting->page_data;
                                        } else {
                                            $group_setting = 0;
                                        }
                                        if ($registration_types->first()) {
                                            $has_registration_type = $registration_types->first();
                                            $registration_type = $has_registration_type->page_data;
                                        } else {
                                            $registration_type = 4;
                                        }
                                        $sort_order = $all_page_data->where('page_module', 'sort_order');
                                        if ($sort_order->first()) {
                                            $has_sort_order = $sort_order->first();
                                            $sort_order = $has_sort_order->page_data;
                                        } else {
                                            $sort_order = 0;
                                        }
                                        ?>

                                        <!--layout start-->
                                        <div class="row mb-3">
                                            <div class="col-12 mb-3">
                                                <h1 class="display-page h4"><strong>Page Layout</strong></h1>
                                                <hr />
                                                <div class="">
                                                    <div class="row">
                                                        <!--first layout start [card-12]-->
                                                        <div class="col-xl-4 col-md-6 col-xxl-3 col-xs-12 col-sm-12">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card h-100 bg-secondary">
                                                                        <div class="card-body">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr />
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div
                                                                        class="custom-control custom-radio custom-control-inline">
                                                                        <input onclick="selWidget('One card')"
                                                                            class="custom-control-input radio-inline"
                                                                            {{ $page_layout_1->first() ? 'checked="checked"' : '' }}
                                                                            type="radio" name="page_data[page_layout]"
                                                                            id="page_layout_one_card" value="full">
                                                                        <label class="custom-control-label"
                                                                            for="page_layout_one_card">
                                                                            One card
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--first layout end-->

                                                        <!--second layout start [col-3-left col-9-right]-->
                                                        <div class="col-xl-4 col-md-6 col-xxl-3 col-xs-12 col-sm-12">

                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <div class="card h-100 bg-secondary">
                                                                        <div class="card-body">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-9">
                                                                    <div class="card h-100 bg-secondary">
                                                                        <div class="card-body"> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr />
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div
                                                                        class="custom-control custom-radio custom-control-inline">
                                                                        <input onclick="selWidget('Left Column')"
                                                                            class="custom-control-input radio-inline"
                                                                            {{ $page_layout_2->first() ? 'checked="checked"' : '' }}
                                                                            type="radio" name="page_data[page_layout]"
                                                                            id="page_layout_two_cards_left"
                                                                            value="two_cards_left">
                                                                        <label class="custom-control-label"
                                                                            for="page_layout_two_cards_left">
                                                                            Two cards (left Column)
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!--second layout end -->

                                                        <!--third layout start [col-9-left col-3-right]-->
                                                        <div class="col-xl-4 col-md-6 col-xxl-3 col-xs-12 col-sm-12">
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    <div class="card h-100 bg-secondary">
                                                                        <div class="card-body"> </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="card h-100 bg-secondary">
                                                                        <div class="card-body"> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr />
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div
                                                                        class="custom-control custom-radio custom-control-inline">
                                                                        <input onclick="selWidget('Right Column')"
                                                                            class="custom-control-input radio-inline"
                                                                            {{ $page_layout_3->first() ? 'checked="checked"' : '' }}
                                                                            type="radio" name="page_data[page_layout]"
                                                                            id="page_layout_two_cards_right"
                                                                            value="two_cards_right">
                                                                        <label class="custom-control-label"
                                                                            for="page_layout_two_cards_right">
                                                                            Two cards (right Column)
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--third layout end-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--layout end start-->

                                        <!--widget start-->
                                        @if ($page->page_settings == 'user_dashboard')
                                            @include('profilehub::admin.pages.parts.user-dashboard-widget')
                                        @elseif ($page->page_settings == 'user_registration')
                                            @include('profilehub::admin.pages.parts.user-registration-widget')
                                        @elseif ($page->page_settings == 'force_profile')
                                            @include('profilehub::admin.pages.parts.force-profile-widget')
                                        @elseif ($page->page_settings == 'course_dashboard')
                                            @include('profilehub::admin.pages.parts.course-dashboard-widget')
                                        @elseif ($page->page_settings == 'course_dashboard')
                                            @include('profilehub::admin.pages.parts.course-dashboard-widget')
                                        @elseif ($page->page_settings == 'profile_dashboard')
                                            @include('profilehub::admin.pages.parts.profile-dashboard-widget')
                                        @elseif ($page->page_settings == 'profile_management')
                                            @include('profilehub::admin.pages.parts.profile-management-widget')
                                        @elseif ($page->page_settings == 'admin_dashboard')
                                            @include('profilehub::admin.pages.parts.admin-dashboard-widget')
                                        @else
                                            @include('profilehub::admin.pages.parts.admin-pages-widget')
                                        @endif
                                        <!--widgets end-->

                                    </div>

                                </div>
                            </div>


                            <div class="col-xl-4 col-md-4 col-xxl-4 col-xs-12 col-sm-12"
                                style="{{ $page->page_type == 3 ? 'display:block' : 'display:none' }}">
                                <div class="card">

                                    <div class="card-body">

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label>Page Banner</label>
                                                <div class="form-group">
                                                    <input class="form-control dropify" type="file"
                                                        data-max-file-size="5mb" accept=".jpg, .jpeg, .png"
                                                        data-show-errors="true"
                                                        data-allowed-file-extensions="jpg jpeg png"
                                                        data-default-file="{{ $banner_image }}"
                                                        placeholder="{{ __('Page Banner') }}" name="banner_image"
                                                        value="{{ $page->page_name }}" />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                <button
                                    class="btn btn-primary d-grid w-30 waves-effect waves-light active float-right ml-3"
                                    type="submit" id="saveProfile">{{ __('Save') }}</button>

                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection


@section('javascript')
    <script src="{{ asset('addons/tinymce/5.8.1/js/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script src="{{ asset('addons/sortable/Sortable.min.js') }}"></script>
    <script src="{{ asset('addons/dropify/js/dropify.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.dropify').dropify({
                messages: {
                    'default': '',
                    'remove': 'Remove',
                    error: {
                        'fileSize': 'The file size is too big ( max).',
                        'minWidth': 'The image width is too small (px min).',
                        'maxWidth': 'The image width is too big ( px max).',
                        'minHeight': 'The image height is too small ( px min).',
                        'maxHeight': 'The image height is too big ( px max).',
                        'imageFormat': 'The image format is not allowed ( only).'
                    }
                }

            });
            $('#datatables').DataTable();
            window.addEventListener('load', function() {
                @foreach ($page_groups as $group)
                    var enabled_status = document.getElementById('group_enabled_{{ $group->group_id }}')
                        .value;
                    if (enabled_status == '1') {
                        //$(".group_icon_{{ $group->group_id }}").addClass("text-success");
                        $(".group_icon_{{ $group->group_id }}").removeClass("text-muted");
                        //$(".group_enabled_input_{{ $group->group_id }}").addClass("text-success");
                        $(".group_enabled_input_{{ $group->group_id }}").removeClass("text-muted");
                    } else if (enabled_status == '0') {

                        //$(".group_icon_{{ $group->group_id }}").addClass("text-muted");
                        $(".group_icon_{{ $group->group_id }}").removeClass("text-success");
                        //$(".group_enabled_input_{{ $group->group_id }}").addClass("text-muted");
                        $(".group_enabled_input_{{ $group->group_id }}").removeClass("text-success");
                    }
                @endforeach
            })
        });



        function changeSubMethod(div) {
            //'course','system'
            return;
        }

        function selWidget(val) {
            $('#default_widget_title').html(val.value)
        }

        function controlContent(val) {
            //page_desc page_content

            if (val.value == 'user_dashboard' || val.value == 'course_dashboard') {
                $('#content_div').css('display', 'none');
                $('#content_sub_div').css('display', 'none');
            } else {
                $('#content_div').css('display', 'block');
                $('#content_sub_div').css('display', 'block');
            }

            return;
        }
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
                            if ($('input[type=checkbox]:checked').length > 0) {
                                $('input[type=checkbox]').prop('required', false);
                            } else {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        tinymce.init({
            selector: "textarea",
            selector: "textarea:not(.ignoreTm)",
            plugins: 'link code',
            toolbar_mode: 'floating',
            toolbar: 'code',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullpage | ' +
                'forecolor backcolor emoticons | help',
            menubar: 'file edit insert view format table tools help',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
        var el = document.getElementById('sortable-grid');
        Sortable.create(el, {
            sort: true,
            delay: 0,
            delayOnTouchOnly: false,
            touchStartThreshold: 0,
            disabled: false,
        });
    </script>
@endsection
