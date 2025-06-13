@extends('vendor.profilehub.layouts.admin')
<?php
$num = 1;
//dd($modules);
?>
@section('content')

    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-uppercase fw-bold">
                                <span class="card-title float-left"> <i class="fa fa-align-justify"></i> Module Adminstration:
                                    {{ $request->input('group_id') ? $groups->group_name . ' Module' : '' }} </span>
                            </h5>
                            <div>
                                @if ($request->input('group_id') > 0)
                                    <a class="btn btn-primary active float-right" data-toggle="modal"
                                        data-target="#addModuleModal"><i class="fa fa-plus active"></i> Add Module</a>
                                @endif
                            </div>
                        </div>
                        <hr />
                        <form class="needs-validation" action="{{ route('profilehub.admin.modules.createrecord') }}" method="POST"
                            enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="function" id="function" value="manage-role-types" />
                            @csrf @method('POST')
                            <div class="card-body">
                                <div class="table-responsive">
                                    <!-- table start-->
                                    <div class="panel panel-default">
                                        <table class="table table-condensed table-striped js-exportable" id="datatables">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Slug</th>
                                                    <th class="text-center">Icon</th>
                                                    <th class="text-center">Group</th>
                                                    <th class="text-center">Description</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Placement</th>
                                                    <th class="text-center">Links</th>
                                                    <th class="text-center">Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($all_modules)
                                                    @foreach ($all_modules as $module)
                                                        @php
                                                            $status = '';
                                                            if ($module->has_widget == '0') {
                                                                $status =
                                                                    '<span class="p-1 bg-warning">Disabled</span>';
                                                            } elseif ($module->has_widget == '1') {
                                                                $status =
                                                                    '<span class="p-1 bg-warning">Disabled</span>';
                                                            } elseif ($module->has_widget == '2') {
                                                                $status = '<span class="p-1 bg-success">Active</span>';
                                                            }
                                                            if ($request->input('group_id')) {
                                                                $group_name = $groups->group_name;
                                                            } else {
                                                                $group = $groups
                                                                    ->where('group_id', $module->group_id)
                                                                    ->first();
                                                                $group_name = $group->group_name;
                                                            }

                                                            $added_widgets = $page_widgets->where(
                                                                'widget_key',
                                                                $module->mudule_slug,
                                                            );
                                                            $all_added = [];
                                                            foreach ($added_widgets as $widget) {
                                                                $all_added[] = $widget->page_id;
                                                            }
                                                            if ($all_added) {
                                                                $all_added = implode(',', $all_added);
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center align-middle">{{ $num }} </td>
                                                            <td class="text-center align-middle">
                                                                <div class="">{{ $module->module_name }}</div>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <div class="">{{ $module->mudule_slug }}</div>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <div class=""><i class="fa {{ $module->module_icon }}"
                                                                        aria-hidden="true"></i></div>
                                                            </td>
                                                            <td><?php echo $group_name; ?></td>
                                                            <td class="text-center align-middle">
                                                                <div class="">
                                                                    @php echo $module->module_desc @endphp</div>
                                    </div>
                                    </td>
                                    <td class="text-center align-middle"><?php echo $status; ?></td>
                                    <td class="text-center align-middle"><span>
                                            {{ $module->widget_type == 'lms' ? strtoupper($module->widget_type) : ucwords($module->widget_type) }}
                                            Widget</span></td>
                                    <td class="text-center align-middle">
                                        <a href="#" onclick="checkLinkedItem('{{ $all_added ? $all_added : '' }}')"
                                            class="upAnything" data-bs-toggle="modal" data-bs-target="#linkMenuModuleModal"
                                            data-key_title="link_modal_title"
                                            data-key_title_value="Link Menu to {{ $module->module_name }} Module"
                                            data-key_values="2" data-key1="link_module_id"
                                            data-key_value1="{{ $module->module_id }}" data-key2="link_group_id"
                                            data-key_value2="{{ $module->group_id }}">
                                            <i class="fa fa-link"></i>
                                        </a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#manageWidgetModal"
                                            data-key_title="manageWidgetModalTitle" data-key_title_value="Manage Widget"
                                            data-key_values="5" data-key1="module_id"
                                            data-key_value1="{{ $module->module_id }}" data-key2="module_name"
                                            data-key_value2="{{ $module->module_name }}" data-key3="module_active"
                                            data-key_value3="{{ $module->has_widget }}" data-key4="module_icon"
                                            data-key_value4="{{ $module->module_icon }}" data-key5="widget_type"
                                            data-key_value5="{{ $module->widget_type }}" class="upAnything">
                                            <i class="ri-edit-circle-fill text-primary"></i>
                                        </a>
                                    </td>
                                    </tr>
                                    <?php $num++; ?>
                                    @endforeach
                                    @endif
                                    </tbody>
                                    </table>
                                </div>

                                <!-- table end-->

                            </div>

                    </div>
                    </form>
                </div>




                <!-- Modal -->
                <div class="modal fade" id="linkMenuModuleModal" tabindex="-1" role="dialog"
                    aria-labelledby="linkMenuModuleLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form class="needs-validation" action="{{ route('profilehub.admin.modules.createrecord') }}"
                                method="POST" novalidate>
                                <div class="modal-header">
                                    <div class="container">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h5 class="modal-title" id="link_modal_title">Link Menu to Module</h5>

                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        @php  @endphp
                                        <input type="hidden" name="function" value="link-menu-to-module" />
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="group_id" id="link_group_id" value="0" />
                                        <input type="hidden" name="module_id" id="link_module_id" value="0" />
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-responsive-sm table-condensed table-striped js-exportable"
                                                        id="datatables1">
                                                        <thead>
                                                            <tr>
                                                                <th>

                                                                </th>
                                                                <th>Name</th>
                                                                <th>Description</th>
                                                                <th>Type</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($all_pages as $page)
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-check-inline">
                                                                            <label class="form-check-label">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input checkbox_pages"
                                                                                    id="page_id_{{ $page->page_id }}"
                                                                                    name="menu_id[{{ $page->page_id }}]"
                                                                                    value="{{ $page->page_id }}"
                                                                                    required="">
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        {{ $page->page_name }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $page->page_desc }}
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            if ($page->page_type == 1) {
                                                                                echo 'LMS';
                                                                            } elseif ($page->page_type == 2) {
                                                                                echo 'Course';
                                                                            } elseif ($page->page_type == 3) {
                                                                                echo 'Public';
                                                                            }
                                                                        @endphp
                                                                    </td>


                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="col-12">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal end -->

            </div>
        </div>
    </div> 

    @include('profilehub::admin.pages.modals.manage-widget-modal')

@endsection
@section('javascript')
    <script type="text/javascript">
        function checkLinkedItem(pages) {
            $('.checkbox_pages').prop("checked", false);
            if (pages) {
                const myArray = pages.split(',');
                for (var page_id = 0; page_id < myArray.length; page_id++) {
                    document.getElementById('page_id_' + myArray[page_id]).checked = true;
                }
            }
        }
        $('#datatables').DataTable();
        $('#datatables1').DataTable({
            "lengthMenu": [
                [-1],
                ["All"]
            ]
        });
        $(document).on("click", ".upAnything", function(e) {
            var button = $(e.relatedTarget);
            var key_values = $(this).data('key_values');
            var tiny_id = $(this).data('tiny_id');
            var tiny_value = $(this).data('tiny_value');
            if (tiny_id) {
                tinymce.get('' + tiny_id + '').setContent('' + tiny_value + '');
            }
            var file1 = $(this).data('file1');
            var file2 = $(this).data('file2');
            var tiny_id = $(this).data('tiny_id');
            if (file1) {
                var defaultFile1 = $(this).data('file_value1');
                var drEvent = $('#' + file1 + '').dropify({
                    defaultFile: defaultFile1
                });
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                drEvent.settings.defaultFile = defaultFile1;
                drEvent.destroy();
                drEvent.init();
            }
            if (file2) {
                var defaultFile2 = $(this).data('file_value2');
                var drEvent = $('#' + file2 + '').dropify({
                    defaultFile: defaultFile2
                });
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                drEvent.settings.defaultFile = defaultFile2;
                drEvent.destroy();
                drEvent.init();
            }
            var key_title = $(this).data('key_title');
            if (key_title) {
                document.getElementById('' + key_title + '').innerHTML = '<h5 class="modal-title" >' + $(this).data(
                    'key_title_value') + '</h5>';
            }
            for (var index = 1; index <= key_values; index++) {
                var key = $(this).data('key' + index);
                var key_value = $(this).data('key_value' + index);
                document.getElementById('' + key + '').value = key_value;
            }
        });
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
    </script>
@endsection
