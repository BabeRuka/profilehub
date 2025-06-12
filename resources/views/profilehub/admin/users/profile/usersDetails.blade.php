@extends('profilehub::layouts.app')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-uppercase fw-bold">
                            <i class="fa fa-solid fa-align-justify"></i> Additional Profile Fields
                        </h5>
                        <div>
                            @if($page_perm['create'])
                                <button type="button" class="btn btn-primary text-light waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#addUserField">
                                    <i class="ri-add-circle-fill ms-1"></i>
                                    <span class="ms-1">Add User Field</span>
                                </button>
                            @endif
                        </div>
                    </div>
                    <hr />
                    <div class="card-body">


                        <!-- Button trigger modal -->

                        
                        <!-- Modal end -->

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        <table class="table table-responsive-sm table-striped" id="datatables">
                        <thead>
                          <tr>
                            <th>User Field Name </th>
                            <th>Type Field</th>
                            <th>Group Name</th>
                            <th>Sequence</th>
                            <th>Children</th>
                            <th>Create Date</th>
                            <th>Move Up</th>
                            <th>Move Down</th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($user_fields as $field)
                            <tr>
                              <td>{{ $field->translation }}</td>
                              <td>{{ $field->type_field }}</td>
                              <td>{{ $field->group_name }}</td>
                              <td>{{ $field->sequence }}</td>
                              <td>{{ $field->num_sons }}</td>
                              <td>{{ $field->create_date }}</td>
                              @if($field->sequence != 1)
                                <td>
                                    @if($page_perm['update'])
                                        <a class="" href="{{route('profilehub::admin.users.profile.userdetails.manage.move',['id'=> $field->field_id, 'seq'=>  ($field->sequence ? $field->sequence : $field->field_id), 'type'=> 'field-parent', 'dir'=> 'up']) }}">
                                        <i class="ri-arrow-up-double-line"></i>
                                        </a>
                                    @endif
                              </td>
                            @else
                              <td></td>
                            @endif

                            @if($field->sequence == count($user_fields))
                                <td></td>
                            @else
                              <td>
                                  @if($page_perm['update'])
                                    <a class="" href="{{route('profilehub::admin.users.profile.userdetails.manage.move',['id'=> $field->field_id, 'seq'=>  ($field->sequence ? $field->sequence : $field->field_id), 'type'=> 'field-parent', 'dir'=> 'down', 'group'=> $field->group_id, ])}}">
                                    <i class="ri-arrow-down-double-line"></i>
                                    </a>
                                  @endif
                              </td>
                            @endif
                            <td>
                              @if($field->type_field =='dropdown' || $field->type_field =='yesno' || $field->type_field =='table')
                                <a href="{{ route('profilehub::admin.users.profile.field', ['id' => $field->field_id, 'name' => $field->type_field]) }}" class="">
                                  <i class="ri-cursor-fill"></i>
                                </a>
                              @endif
                            </td>
                              <td>
                                @if($page_perm['view'])
                                    <a href="#editUserField" data-bs-toggle="modal"
                                    onclick="editField('{{ $field->field_id }}','{{ $field->group_id }}','{{ $field->type_field }}', '{{ $field->translation }}')"
                                      data-bs-target="#editUserField" data-groupname="{{ $field->group_id }}" data-typefield="{{ $field->type_field }}" data-fieldid="{{ $field->field_id }}"  data-fieldname="{{ $field->translation }}"  >
                                      <i class="ri-edit-circle-fill text-primary"></i>
                                    </a>
                                @endif
                              </td>
                              <td>
                                @if($page_perm['delete'])
                                    
                                         
                                        <a href="#deleteModal"
                                        onclick="updateDeleteModal('Delete User Field {{ $field->translation }}', 'Are you sure you want to delete this user profile field?','{{ route('profilehub::admin.users.profile.userdetails.destroy') }}','field_id','{{ $field->field_id }}','back_url','{{ route('profilehub::admin.users.profile.fields') }}')"
                                        data-bs-target="#deleteModal" data-bs-toggle="modal" type="button" class="DeleteUserField" data-bb-example-key="confirm-options" data-fieldid="DeleteUserFieldForm{{ $field->field_id }}" >
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
        @if($page_perm['create'])
          @include('profilehub::admin.users.profile.modals.add-user-profile-field-modal')
        @endif
        @if($page_perm['update'])
          @include('profilehub::admin.users.profile.modals.edit-user-profile-field-modal')
        @endif
@endsection


@section('javascript')
<script>
$(document).ready(function() {
    $('#datatables').DataTable();
});

function editField(field_id, group_id, type_field, translation) {
        //document.getElementById('addUserGroupTitle').innerHTML = 'Edit Group';
        document.getElementById('field_id').value = field_id;
        document.getElementById('group_id').value = group_id;
        document.getElementById('type_field').value = type_field;
        document.getElementById('translation').value = translation;
    }
</script>
@endsection


