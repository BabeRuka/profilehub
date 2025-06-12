@extends('profilehub::layouts.app')
@php
use BabeRuka\ProfileHub\Repository\UserAdmin;
use BabeRuka\ProfileHub\Repository\UserFunctions;
$functions = new UserFunctions();
@endphp
@section('css')
    <style>
        td {
            vertical-align: middle;
        }

        .select-extended-element {
            margin-bottom: .5rem;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('addons/bootstrap-select/bootstrap-select.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-uppercase fw-bold">
                            <i class="fa fa-solid fa-align-justify"></i> Additional Profile Fields  [{{ strtoupper(request('name')) }}]
                        </h5>
                        <div>
                             <!-- Button trigger modal -->
                            @if ($page_perm['update'])
                                <button type="submit" class="btn btn-success active ml-3"
                                    onClick="document.getElementById('fixSeqeunce').submit()">
                                    <i class="ri-arrow-up-down-line"></i> 
                                    <span class="ms-1"> Fix Sequence </span>
                                </button>
                            @endif

                            @if ($page_perm['create'])
                                <button type="button" onclick="addField()" class="btn btn-primary active"
                                    data-bs-toggle="modal" data-bs-target="#addUserFieldSon">
                                    <i class="ri-add-circle-fill ms-1"></i>
                                    <span class="ms-1"> Add Field</span>
                                </button>
                            @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="overflow-auto">
                                @if ($field->type_field == 'table')
                                    <table data-dynamicrows
                                        class="table table-responsive table-striped table-hover table-active">
                                        <thead>
                                            <tr>
                                                @foreach ($son_fields as $table)
                                                    <th scope="col">{{ $table->translation }}</th>
                                                @endforeach
                                            </tr>

                                            @foreach ($son_fields as $table)
                                                <th scope="col">
                                                    <div class="row justify-content-md-center">
                                                        <div class="col-md-auto">
                                                            @if ($table->field_type == 'dropdown' || $table->field_type == 'json' || $table->field_type == 'array')
                                                                @php
                                                                    $has_son_data = $son_data->where('son_id', $table->son_id);
                                                                @endphp
                                                                <a href="javascript:void(0)"
                                                                    class="{{ $has_son_data->first() ? 'getSonFieldData' : '' }}"
                                                                    data-son_id="{{ $table->son_id }}"
                                                                    onclick="addFieldSonData({{ $table->son_id }},'son_id_data')"
                                                                    data-toggle="modal"
                                                                    data-target="#addUserFieldSonDropdownData"><i
                                                                        class="fa fa-plus-circle text-success"
                                                                        aria-hidden="true"></i></a>
                                                            @elseif($table->field_type == 'number')
                                                                @php
                                                                    $field_settings = json_decode($table->field_settings);
                                                                @endphp
                                                                <a href="javascript:void(0)"
                                                                    class="{{ $field_settings != null ? 'getSonFieldSettingsData' : '' }}"
                                                                    data-start_range="{{ $field_settings != null ? $field_settings->start_range : '' }}"
                                                                    data-end_range="{{ $field_settings != null ? $field_settings->end_range : '' }}"
                                                                    data-toggle="modal"
                                                                    onclick="addFieldSonData({{ $table->son_id }},'son_id_range_data'),popRangeData({{ $field_settings->start_range }},{{ $field_settings->end_range }})"
                                                                    data-target="#addUserFieldSonRangeData"><i
                                                                        class="fa fa-cogs text-success"
                                                                        aria-hidden="true"></i></a>
                                                            @elseif($table->field_type == 'date')
                                                                @php
                                                                    $field_settings = json_decode($table->field_settings);
                                                                @endphp
                                                                <a href="javascript:void(0)"
                                                                    class="{{ $field_settings != null ? 'getSonFieldSettingsData' : '' }}"
                                                                    data-date_picker="{{ $field_settings != null ? $field_settings->date_plugin : '' }}"
                                                                    data-date_format="{{ $field_settings != null ? $field_settings->date_plugin_format : '' }}"
                                                                    data-toggle="modal"
                                                                    onclick="addFieldSonData({{ $table->son_id }},'son_id_date_data')"
                                                                    data-target="#addUserFieldSonDateData"><i
                                                                        class="fa fa-cogs text-success"
                                                                        aria-hidden="true"></i></a>
                                                            @elseif($table->field_type == 'widget')
                                                                @php
                                                                    $field_settings = json_decode($table->field_settings);
                                                                    //{"input_type":"dropdown","dropdown_type":"country-dropdown","dropdown_value":"201"}
                                                                @endphp
                                                                <a href="javascript:void(0)"
                                                                    class="{{ $field_settings != null ? 'getSonFieldSettingsData' : '' }}"
                                                                    data-input_type="{{ $input_type = ($field_settings != null ? $field_settings->input_type : '') }}"
                                                                    data-dropdown_type="{{ $dropdown_type = ($field_settings != null ? $field_settings->dropdown_type : '') }}"
                                                                    data-dropdown_value="{{ $dropdown_value = ($field_settings != null ? $field_settings->dropdown_value : '') }}"
                                                                    data-toggle="modal"
                                                                    onclick="addFieldSonData({{ $table->son_id }},'son_id_widget_data'),getWidgetData('{{ $input_type }}', '{{ $dropdown_type }}', '{{ $dropdown_value }}')"
                                                                    data-target="#addUserFieldSonWidget"><i
                                                                        class="fa fa-code text-success"
                                                                        aria-hidden="true"></i></a>
                                                            @else
                                                            @endif
                                                        </div>
                                                    </div>
                                                </th>
                                            @endforeach
                                        </thead>
                                        <tbody>
                                            @foreach ($son_fields as $table)
                                                <td class="text-center">
                                                    <div class="form-group">
                                                        @if ($table->field_type == 'dropdown' || $table->field_type == 'json' || $table->field_type == 'array')
                                                            @php
                                                                $has_son_data = $son_data->where('son_id', $table->son_id);
                                                            @endphp
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <select class="form-control">
                                                                        <option value="">Select
                                                                            {{ strtolower($table->translation) }}...
                                                                        </option>
                                                                        @foreach ($has_son_data as $dropdown)
                                                                            <option value="{{ $dropdown->data_key }}">
                                                                                {{ $dropdown->data_value }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @elseif($table->field_type == 'date')
                                                            <input type="text"
                                                                class="form-control"placeholder="{{ $table->field_type }}">
                                                        @else
                                                            <input type="text"
                                                                class="form-control"placeholder="{{ $table->field_type }}">
                                                        @endif
                                                    </div>
                                                </td>
                                            @endforeach

                                        </tbody>

                                    </table>
                                @endif
                            </div>
                            @if ($page_perm['create'])
                                
                            @endif

                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif


                            <table class="table table-responsive-sm table-striped" id="datatables">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Parent</th>
                                        <th>Group</th>
                                        <th>Sequence</th>
                                        <th>Create Date</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($son_fields as $son)
                                        <tr>
                                            <td>{{ $son->translation }}</td>
                                            <td>{{ strtoupper($son->field_type) }}</td>
                                            <td>{{ $field->translation }}</td>
                                            <td>{{ $group->group_name }}</td>
                                            <td>{{ $son->sequence }}</td>
                                            <td>{{ $son->create_date }}</td>
                                            <td>
                                                @if ($page_perm['update'])
                                                    <a href="#editUserFieldSon" data-bs-toggle="modal" data-bs-target="#editUserFieldSon"
                                                        onclick="editFieldSon('{{ $field->field_id ? $field->field_id : request('id') }}','{{ $son->son_id }}','{{ $son->field_type }}','{{ $son->translation }}')"
                                                        data-fieldid="{{ $son->field_id }}"
                                                        data-fieldname="{{ $son->translation }}"
                                                        data-fieldtype="{{ $son->field_type }}"
                                                        data-sonid="{{ $son->son_id }}" class="upBtn">
                                                        <i class="ri-edit-circle-fill text-primary"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($page_perm['delete'])
                                                    <a href="#deleteModal" type="button"
                                                        onclick="updateDeleteModal('Delete Profile Field {{ $son->translation }}', 'Are you sure you want to delete this Profile field?','{{ route('profilehub::admin.users.profile.userdetails.createrecord') }}','son_id','{{ $son->son_id }}','back_url','{{ route('profilehub::admin.users.profile.fields') }}','POST','delete-user-field-son')"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        class="DeleteUserField">
                                                        <i class="ri-delete-bin-5-line text-danger"></i>
                                                    </a>
                                                @endif
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
    </div> 
    @include('profilehub::admin.modals.delete-modal')
    @include('profilehub::admin.users.profile.modals.add-user-profile-field-son-modal')
    @include('profilehub::admin.users.profile.modals.edit-user-profile-field-son-modal')
    @if ($page_perm['update'])
        <form id="fixSeqeunce" action="{{ route('profilehub::admin.users.profile.userdetails.createrecord') }}" method="POST" novalidate>
            @csrf
            @method('POST')
            <input type="hidden" name="function" value="fix-son-sequence" />
            <input type="hidden" name="field_id" value="{{ request('id') }}" />
        </form>
    @endif

@endsection
@section('javascript')
     
    <script src="{{ asset('addons/jquery-dynamicrows/js/dynamicrows.js') }}"></script>
    <script src="{{ asset('addons/bootstrap-select/bootstrap-select.min.js') }}"></script>


    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields jquery-dropdown
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
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        $(function() {
            $('.selectpicker').selectpicker();
        });
         
    function editFieldSon(field_id, son_id, field_type, translation) {
        //document.getElementById('addUserGroupTitle').innerHTML = 'Edit Group';
        document.getElementById('field_id').value = field_id;
        document.getElementById('son_id').value = son_id;
        document.getElementById('field_type').value = field_type;
        document.getElementById('translation').value = translation;
    }
    </script>
    
@endsection
