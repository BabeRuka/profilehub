@extends('profilehub::layouts.app')
@inject('UserFunctions', 'BabeRuka\ProfileHub\Repository\UserFunctions')
@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-uppercase fw-bold">
                                <span class="card-title float-left"> <i class="fa fa-align-justify"></i> Module
                                    Adminstration</span>
                            </h5>
                            <div>
                                <a class="btn btn-primary active float-right" data-bs-toggle="modal"
                                    data-bs-target="#manageGroupModuleModal">
                                    <i class="fa fa-plus active ms-1"></i> <span class="ms-2">Add Module Group</span></a>
                            </div>
                        </div>
                        <hr />
                        <form class="needs-validation" action="{{ route('profilehub::admin.modules.createrecord') }}" method="POST"
                            enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="function" value="manage-group-settings" />
                            @csrf @method('POST')
                            <div class="card-body">
                                <div class="table-responsive">
                                    <!-- table start-->
                                    <div class="panel panel-default">
                                        <table class="table table-condensed table-striped js-exportable" id="datatables">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Slug</th>
                                                    <th>Icon</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Manage</th>
                                                    <th>Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num = 1; ?>
                                                @foreach ($groups as $group)
                                                    <?php
                                                    $status = '';
                                                    if ($group->group_active == '0') {
                                                        $status = '<span class="p-1 bg-danger">deleted</span>';
                                                    } elseif ($group->group_active == '1') {
                                                        $status = '<span class="p-1 bg-warning">in active</span>';
                                                    } elseif ($group->group_active == '2') {
                                                        $status = '<span class="p-1 bg-success">active</span>';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>{{ $num }}</td>
                                                        <td>
                                                            <div class="___class_+?15___"><input class="form-control"
                                                                    type="text" id="group_name_{{ $group->group_id }}"
                                                                    name="group_name" value="{{ $group->group_name }}"
                                                                    disabled="" readonly="" /></div>
                                                        </td>
                                                        <td>
                                                            <div class="___class_+?17___"><input class="form-control"
                                                                    type="text" id="goup_slug_{{ $group->group_id }}"
                                                                    name="goup_slug" value="{{ $group->goup_slug }}"
                                                                    disabled="" readonly="" /></div>
                                                        </td>
                                                        <td>
                                                            <i class="fa {{ $group->group_icon }}" aria-hidden="true"></i>
                                                        </td>
                                                        <td>
                                                            @php echo $group->group_desc @endphp
                                                        </td>
                                                        <td><?php echo $status; ?></td>
                                                        <td>
                                                            <a href="{{ route('profilehub::admin.modules', ['group_id' => $group->group_id]) }}"
                                                                class=""><i
                                                                    class="ri-cursor-fill active active"></i></a>
                                                        </td>
                                                        <td>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#manageGroupModuleModal" data-key_values="4"
                                                                data-tiny_id="group_desc"
                                                                data-tiny_value="{{ $group->group_desc }}"
                                                                data-key1="group_id"
                                                                data-key_value1="{{ $group->group_id }}"
                                                                data-key2="group_name"
                                                                data-key_value2="{{ $group->group_name }}"
                                                                data-key3="group_active"
                                                                data-key_value3="{{ $group->group_active }}"
                                                                data-key4="group_icon"
                                                                data-key_value4="{{ $group->group_icon }}"
                                                                class="upAnything">
                                                                <i class="ri-edit-circle-fill text-primary"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $num++; ?>
                                                @endforeach

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
    @include('profilehub::admin.modules.modals.manage-group-module-modal')
@endsection
@section('javascript')
    <script src="{{ asset('addons/tinymce/5.8.1/js/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
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
