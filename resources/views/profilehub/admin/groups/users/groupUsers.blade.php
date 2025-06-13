@extends('profilehub::layouts.default')
<?php
//dd($type_group);
?>
@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12">
                <form id="userGroupForm" class="needs-validations" action="{{ route('profilehub.admin.groups.createrecord') }}" method="POST" novalidate>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> {{ $group->group_name }} ({{ (count($users_in_group) ? count($users_in_group) : 0) }} Users)
                        </div>
                        <div class="card-body">
                        <div class="body">

                                @csrf
                                @method('POST')
                                <input type="hidden" name="function" id="add_users_group_function" value="add-user-to-group" />
                                <input type="hidden" name="group_id" id="add_course_group_id" value="{{ $group->group_id }}" />
                                <div class="table-responsive">
                                    <table class="table table-responsive-sm table-condensed table-striped js-exportable" id="datatables">
                                        <thead>
                                        <tr>
                                            <th>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" onClick="checkAll(this.checked,'user_id[]')">
                                                    </label>
                                                </div>
                                            </th>
                                            <th>Names </th>
                                            <th>Email </th>
                                            <th> </th>
                                            <th> </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($group_users) > 0)
                                                @foreach($group_users as $user)
                                                    <tr>
                                                        <td>
                                                            <div class="form-group form-check">
                                                                <label class="form-check-label">
                                                                <input class="form-check-input checkboxRequired" type="checkbox" name="user_id[]" value="{{ $user->user_id }}" {{ ($user->user_id == $user->grouped_id ? 'checked' : '') }}  required>
                                                                <div class="form-group-messages"></div>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $user->username }}</td>
                                                        <td>{{ $user->firstname.' '.$user->lastname }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>
                                                            @if($user->user_id == $user->grouped_id)
                                                                <button type="button"
                                                                    class="btn btn-danger deleteFunc" data-bb-example-key="confirm-options"
                                                                    data-key="dcgf" data-pidv="{{ $user->group_id }}" data-fidv="{{ $user->user_id }}" data-func="dynamic"
                                                                    data-formid="DeleteCourseGroupForm">
                                                                    <i class="c-icon c-icon-2xs cil-x-circle active"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary active float-right" type="submit">Save Users</button>
                        <button class="btn btn-danger active float-right mr-3" name="bulk-remove-groups" id="bulk-remove-groups" value="1" type="submit">Remove Users</button>
                    </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
        <form name="DeleteCourseGroupForm" id="DeleteCourseGroupForm" action="{{ route('profilehub.admin.groups.createrecord') }}" method="POST">
            <input type="hidden" name="function" id="function-cgd" value="del-user-group-user" />
            <input type="hidden" name="group_id" id="dcgf-pidv" value="" />
            <input type="hidden" name="user_id" id="dcgf-fidv" value="" />
            @method('POST')
            @csrf
        </form>



@endsection


@section('javascript')

@endsection

