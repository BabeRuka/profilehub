@extends('vendor.profilehub.layouts.admin')

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
                                    <a class="btn btn-primary active float-right" data-bs-toggle="modal"
                                        data-bs-target="#manageModuleModal"><i class="fa fa-plus active"></i> Add Module</a>
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
                                                    <th class="text-center">Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($modules)
                                                    @foreach ($modules as $module)
                                                        @php
                                                            $added_menus = 0;
                                                            $status = '';
                                                            if ($module->module_active == '0') {
                                                                $status = '<span class="p-1 bg-danger">deleted</span>';
                                                            } elseif ($module->module_active == '1') {
                                                                $status =
                                                                    '<span class="p-1 bg-warning">in active</span>';
                                                            } elseif ($module->module_active == '2') {
                                                                $status = '<span class="p-1 bg-success">active</span>';
                                                            }
                                                            if ($request->input('group_id')) {
                                                                $group_name = $groups->group_name;
                                                            } else {
                                                                $group = $groups
                                                                    ->where('group_id', $module->group_id)
                                                                    ->first();
                                                                $group_name = $group->group_name;
                                                            }
                                                            $all_added = [];
                                                            $num = 1;
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center align-middle">{{ $num }} </td>
                                                            <td class="text-center align-middle">
                                                                <div class=""><input class="form-control"
                                                                        type="text"
                                                                        id="module_name_{{ $module->module_id }}"
                                                                        name="module_name"
                                                                        value="{{ $module->module_name }}" disabled=""
                                                                        readonly="" /></div>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <div class=""><input class="form-control"
                                                                        type="text"
                                                                        id="mudule_slug_{{ $module->module_id }}"
                                                                        name="mudule_slug"
                                                                        value="{{ $module->mudule_slug }}" disabled=""
                                                                        readonly="" /></div>
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
                                     
                                    <td class="text-center align-middle">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#manageModuleModal"
                                            data-key_title="manageModuleModalHeading" data-key_title_value="Edit Module :: {{ $module->module_name }}"
                                            data-key_values="4" data-tiny_id="module_desc"
                                            data-tiny_value="{{ $module->module_desc }}" data-key1="module_id"
                                            data-key_value1="{{ $module->module_id }}" data-key2="module_name"
                                            data-key_value2="{{ $module->module_name }}" data-key3="module_active"
                                            data-key_value3="{{ $module->module_active }}" data-key4="module_icon"
                                            data-key_value4="{{ $module->module_icon }}" class="upAnything">
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




            </div>
        </div>
    </div>
    </div>
    @include('profilehub::admin.modules.modals.manage-module-modal')
@endsection
@section('javascript')
    <script src="{{ asset('addons/tinymce/5.8.1/js/tinymce.min.js') }}" referrerpolicy="origin"></script>

    <script type="text/javascript">
        function checkLinkedItem(menus) {
            $('.checkbox_menus').prop("checked", false);
            if (menus) {
                const myArray = menus.split(',');
                for (var menu_id = 0; menu_id < myArray.length; menu_id++) {
                    console.log(myArray[menu_id]);
                    document.getElementById('menu_id_' + myArray[menu_id]).checked = true;
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
