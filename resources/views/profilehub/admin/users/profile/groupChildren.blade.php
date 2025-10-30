@extends('vendor.profilehub.layouts.admin')

@section('title', 'Manage Additional Fields')
@section('content')
<?php
//dd($children);
?>
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12 col-md-8">
                <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-uppercase fw-bold">
                            <i class="fa fa-solid fa-align-justify"></i> Additional Fields - {{ $group->group_name }}
                        </h5>

                        <a href="{{ route('profilehub.admin.users.profile.groups')}}"
                                    class="btn btn-primary text-light waves-effect waves-light">
                                    <i class="ri-add-circle-fill ms-1"></i>
                                    <span class="ms-1">Back to all groups</span>
                        </a>

                        <button type="button" class="btn btn-primary active float-right" id="addGroupChildrenModalBtn" data-bs-toggle="modal" data-bs-target="#addUserFieldSon">
                        <i class="ri-add-circle-fill ms-1"></i> Add User Group
                      </button>

                    </div>
                    <div class="card-body">
                        <form class="needs-validation" action="{{ route('profilehub.admin.users.profile.userdetails.manage') }}" method="POST" novalidate>
                            @csrf
                            @method('POST')
                            <input type="hidden" name="group_id" id="group_id"
                                value="{{ $group_id }}">
                            <input type="hidden" name="function" id="function" value="manage-group-children">
                            <div class="table-responsive">
                                <table class="table table-responsive-sm table-striped js-exportable" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>Additional Field Name</th>
                                            <th>Group Sequence</th>
                                            <th>Move Up</th>
                                            <th>Move Down</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($children) > 0)
                                            @foreach($children as $child)
                                                <tr>
                                                    <td>{{ $child->translation }}</td>
                                                    <td><input type="text" id="entry_{{ $child->field_id }}"
                                                            name="entry[{{ $child->field_id }}]"
                                                            value="{{ $child->group_sequence }}" class="form-control"
                                                            placeholder="Enter sequence" required></td>
                                                    @if($child->group_sequence != 1)
                                                        <td>
                                                            @if($page_perm['update'])
                                                                <a class=""
                                                                    href="{{ route('profilehub.admin.users.profile.userdetails.manage.move', ['id' => $child->field_id, 'group' => $child->group_id, 'seq' => ($child->group_sequence ? $child->group_sequence : $child->field_id), 'type' => 'field-child', 'dir' => 'up']) }}">
                                                                    <i class="ri-arrow-up-double-line"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    @if($child->group_sequence == count($children))
                                                        <td></td>
                                                    @else
                                                        <td>
                                                            @if($page_perm['update'])
                                                                <a class=""
                                                                    href="{{ route('profilehub.admin.users.profile.userdetails.manage.move', ['id' => $child->field_id, 'group' => $group_id, 'seq' => ($child->group_sequence ? $child->group_sequence : $child->field_id), 'type' => 'field-child', 'dir' => 'down']) }}">
                                                                    <i class="ri-arrow-down-double-line"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <br />
                            @if($page_perm['update'])
                                <div class="form-group">
                                    <button type="submit" id="addGroupBtnSubmit"
                                        class="btn btn-primary float-right d-grid w-30">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('vendor.profilehub.admin.users.profile.modals.add-user-profile-field-son-modal')
@include('vendor.profilehub.admin.users.profile.modals.edit-user-profile-field-son-modal')
@endsection

@section('javascript')
<script src="{{ asset('vendor/profilehub/addons/datatables/bootstrap5/js/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#datatables').DataTable({
                "order": [],
                "columnDefs": [{
                    "orderable": false,
                    "targets": [2, 3]
                }],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection
