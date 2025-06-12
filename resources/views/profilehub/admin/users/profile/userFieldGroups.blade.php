@extends('profilehub::layouts.app')
@section('css')
    <style>


    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12">
                    <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-uppercase fw-bold">
                            <i class="fa fa-solid fa-align-justify"></i> Profile Field Groups
                        </h5>
                        <div>
                            @if($page_perm['create'])
                                <button type="button" class="btn btn-primary text-light waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#addUserGroup">
                                    <i class="ri-add-circle-fill ms-1"></i>
                                    <span class="ms-1">Add Profile Group</span>
                                </button>
                            @endif
                        </div>
                    </div>
                    <hr />
 
                        <div class="card-body">


                            <!-- Button trigger modal -->

                           
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif

                            <table class="table table-responsive-sm table-striped" id="datatables">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Create Date</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user_groups as $group)
                                        <tr>
                                            <td scope="col">{{ $group->group_name }}</td>
                                            <td scope="col">{{ $group->type_group }}</td>
                                            <td scope="col" class="text-center"><i class="fa {{ $group->group_icon }}"
                                                    aria-hidden="true"></i></td>
                                            <td scope="col">{{ $group->create_date }}</td>
                                            <td scope="col" class="">
                                                @if ($page_perm['view'])
                                                    <a href="{{ route('profilehub::admin.users.profile.groups.children', ['id' => $group->group_id]) }}"
                                                        class="">
                                                        <i class="ri-cursor-fill text-primary"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td scope="col">
                                                @if ($page_perm['update'])
                                                    <a href="#editUserGroup" data-bs-toggle="modal" data-bs-target="#editUserGroup"
                                                        onclick="editGroup({{ $group->group_id }},'{{ $group->group_icon }}','{{ $group->group_name }}')"
                                                        data-typefield="{{ $group->type_group }}"
                                                        data-fieldid="{{ $group->group_id }}"
                                                        data-fieldname="{{ $group->group_name }}"
                                                        class="">
                                                        <i class="ri-edit-circle-fill text-primary"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td scope="col">
                                                @if ($page_perm['delete'])
                                                    <a href="#deleteModal" data-bs-target="#deleteModal" data-bs-toggle="modal"
                                                            data-fieldid="DeleteUserGroupForm{{ $group->group_id }}"
                                                            onclick="updateDeleteModal('Delete Profile Group {{ $group->group_name }}', 'Are you sure you want to delete this Profile Group?','{{ route('profilehub::admin.users.profile.userdetails.destroyGroup') }}','group_id','{{ $group->group_id }}','back_url','{{ route('profilehub::admin.users.profile.groups') }}')"
                                                            class="DeleteUserField">
                                                            <i class="ri-delete-bin-5-fill text-danger"></i>
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
    @if ($page_perm['create'] || $page_perm['update'])
        @include('profilehub::admin.users.profile.modals.add-user-profile-group-modal')
        @include('profilehub::admin.users.profile.modals.edit-user-profile-group-modal')
    @endif
@endsection
@section('javascript')

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    $(function () {
        $('#datatables').DataTable();
    });

    function editGroup(id, icon, name) {
        document.getElementById('addUserGroupTitle').innerHTML = 'Edit Group';
        document.getElementById('group_id').value = id;
        document.getElementById('group_icon').value = icon;
        document.getElementById('group_name').value = name;
    }
</script>
@endsection
