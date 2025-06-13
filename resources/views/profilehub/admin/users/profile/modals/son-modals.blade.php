@if($page_perm['delete'])
    <!-- Modal -->
    <div class="modal fade" id="delUserFieldSon" tabindex="-1" role="dialog" aria-labelledby="delUserFieldSonLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-full-height modal-bottom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container p-0 m-0">
                        <h5 class="modal-title"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i>
                            Confirm Delete!</h5>
                        <hr />
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="">
                        <div class="row">
                            <div class="col-12">
                                <form
                                    action="{{ route('profilehub.admin.users.groups.userdetails.createrecord') }}"
                                    method="POST">
                                    <input type="hidden" name="function" value="delete-user-field" />
                                    <input type="hidden" name="son_id" id="son_id_del" value="0" />
                                    <input type="hidden" name="field_id" id="field_id_del"
                                        value="{{ $field->field_id }}" />
                                    @method('POST')
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            Please confirm delete of the user field <span id="del_field"></span>
                                        </div>

                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-12">
                                            <button class="btn btn-danger active float-right"
                                                type="submit">Delete</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
@endif


<!-- Modal -->
<div class="modal fade" id="addUserFieldSonDropdownData" tabindex="-1" role="dialog"
    aria-labelledby="addUserFieldSonDropdownDataLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-full-height modal-bottom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container p-0 m-0">
                    <h5 class="modal-title" id="dropdown_title">Add Dropdown Field</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12	col-md-12 col-lg-12 col-md-8">
                            <h4 class="mb-3"></h4>
                            <form class="needs-validation" id="createrecord" name="createrecord"
                                action="{{ route('profilehub.admin.users.groups.userdetails.createrecord') }}"
                                method="POST" novalidate>
                                @csrf
                                @method('POST')
                                <input type="hidden" name="function" id="function_sondata"
                                    value="add-user-field-son-data" />
                                <input type="hidden" name="field_id" id="field_id_data"
                                    value="{{ $field->field_id ? $field->field_id : request('id') }}" />
                                <input type="hidden" name="son_id" id="son_id_data" value="0" />
                                <div class="table-responsive" id="son_data_div">
                                    <table data-dropdowns class="table table-striped table-hover table-active">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Dropdown Name</th>
                                                <th>Dropdown Value</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#</td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-sm"
                                                            name="dropdown_name[]" placeholder="Enter dropdown name..."
                                                            value="" required>
                                                        <div class="invalid-feedback">
                                                            Dropdown name is required.
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-sm"
                                                            name="dropdown_value[]"
                                                            placeholder="Enter dropdown value..." value="" required>
                                                        <div class="invalid-feedback">
                                                            Dropdown value is required.
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" data-remove><i
                                                            class="fa fa-minus"></i></a>
                                                    <a href="javascript:void(0)" data-add><i class="fa fa-plus"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-12">
                                        <button class="btn btn-primary active float-right" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>
<!-- Modal end -->

<!-- Modal -->
<div class="modal fade" id="addUserFieldSonDateData" tabindex="-1" role="dialog"
    aria-labelledby="addUserFieldSonDateDataLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-full-height modal-bottom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container p-0 m-0">
                    <h5 class="modal-title" id="dropdown_title">Date Settings</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12	col-md-12 col-lg-12 col-md-8">
                            <h4 class="mb-3"></h4>
                            <form class="needs-validation" id="createrecord" name="createrecord"
                                action="{{ route('profilehub.admin.users.groups.userdetails.createrecord') }}"
                                method="POST" novalidate>
                                @csrf
                                @method('POST')
                                <input type="hidden" name="function" value="add-user-field-son-date-data" />
                                <input type="hidden" name="field_id"
                                    value="{{ $field->field_id ? $field->field_id : request('id') }}" />
                                <input type="hidden" name="son_id" id="son_id_date_data" value="0" />
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-active">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date Format</th>
                                                <th>Date Format</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#</td>
                                                <td>
                                                    <div class="form-group">
                                                        <select name="date_plugin" id="date_plugin"
                                                            class="form-control input-sm">
                                                            <option selected="selected" value="bootstrap_datepicker">
                                                                Bootstrap Datepicker</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Dropdown name is required.
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <select name="date_plugin_format" id="date_plugin_format"
                                                            class="form-control input-sm">
                                                            <option value="yyyy">Year</option>
                                                            <option value="yyyy-mm">Year-Month</option>
                                                            <option value="yyyy-mm-dd">Year-Month-Day</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Dropdown value is required.
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-12">
                                        <button class="btn btn-primary active float-right" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>
<!-- Modal end -->

<!-- Modal -->
<div class="modal fade" id="addUserFieldSonRangeData" tabindex="-1" role="dialog"
    aria-labelledby="addUserFieldSonRangeDataLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-full-height modal-bottom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container p-0 m-0">
                    <h5 class="modal-title" id="dropdown_title">Add Dropdown Field</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12	col-md-12 col-lg-12 col-md-8">
                            <h4 class="mb-3"></h4>
                            <form class="needs-validation" id="createrecord" name="createrecord"
                                action="{{ route('profilehub.admin.users.groups.userdetails.createrecord') }}"
                                method="POST" novalidate>
                                @csrf
                                @method('POST')
                                <input type="hidden" name="function" id="function_sondata"
                                    value="add-user-field-son-range-data" />
                                <input type="hidden" name="field_id" id="field_id_data"
                                    value="{{ $field->field_id ? $field->field_id : request('id') }}" />
                                <input type="hidden" name="son_id" id="son_id_range_data" value="0" />
                                <div class="table-responsive" id="">
                                    <table data-dropdowns class="table table-striped table-hover table-active">
                                        <thead>
                                            <tr>
                                                <th>Lowest Value</th>
                                                <th>Highest Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="number" class="form-control input-sm"
                                                            name="start_range" id="start_range"
                                                            placeholder="Enter lowest value..." value="0" required>
                                                        <div class="invalid-feedback">
                                                            Lowest Value is required.
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="number" class="form-control input-sm"
                                                            name="end_range" id="end_range"
                                                            placeholder="Enter highest value..." value="100" required>
                                                        <div class="invalid-feedback">
                                                            Highest value is required.
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-12">
                                        <button class="btn btn-primary active float-right" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>
<!-- Modal end -->

<!-- Modal -->
<div class="modal fade" id="addUserFieldSonWidget" tabindex="-1" role="dialog"
    aria-labelledby="addUserFieldSonWidgetLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-full-height modal-bottom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container p-0 m-0">
                    <h5 class="modal-title" id="dropdown_title">Add Dropdown Widgets</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12	col-md-12 col-lg-12 col-md-8">
                            <h4 class="mb-3"></h4>
                            <form class="needs-validation" id="createrecord" name="createrecord"
                                action="{{ route('profilehub.admin.users.groups.userdetails.createrecord') }}"
                                method="POST" novalidate>
                                @csrf
                                @method('POST')
                                <input type="hidden" name="function" id="function_sondata"
                                    value="add-user-field-son-widget-data" />
                                <input type="hidden" name="field_id" id="field_id_data"
                                    value="{{ $field->field_id ? $field->field_id : request('id') }}" />
                                <input type="hidden" name="son_id" id="son_id_widget_data" value="0" />
                                <div class="table-responsive" id="">
                                    <table data-dropdowns class="table table-striped table-hover table-active">
                                        <thead>
                                            <tr>
                                                <th style="width: 33%">Input Type</th>
                                                <th style="width: 33%">Input Value</th>
                                                <th style="width: 33%">Drodown Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <select class="form-control" id="input_type" name="input_type"
                                                            required>
                                                            <option value="text" selected="selected">Text Entry</option>
                                                            <option value="dropdown">Dropdown</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <select class="form-control" id="dropdown_type"
                                                            name="dropdown_type" required disabled>
                                                            <option value="">Select dropdown type...
                                                            </option>
                                                            <option value="city-dropdown">Town / City</option>
                                                            <option value="state-dropdown">State / Provice</option>
                                                            <option value="country-dropdown">Country</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Highest value is required.
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group" id="dropdown_value_data">
                                                        <select class="form-control" id="dropdown_value"
                                                            name="dropdown_value" required disabled>
                                                            <option value="">Select dropdown value...
                                                            </option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-12">
                                        <button class="btn btn-primary active float-right" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>
<!-- Modal end -->
