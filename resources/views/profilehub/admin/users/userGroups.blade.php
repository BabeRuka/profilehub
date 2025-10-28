@extends('vendor.profilehub.layouts.admin')
<?php 
?>
@section('css')
<style>
.dt-search {
    width: max-content;
}
.dt-length {
    width: 30% !important; 
    float: right !important;
}
</style>
@endsection
@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <button type="button" class="btn btn-primary active float-right" id="showAddGroupModalBtn" >
                        Add User Group
                      </button>
                    </div>
                    <div class="card-body">
                      <div class="body">
                        <div class="table-responsive">
                            <table class="table table-responsive-sm table-condensed table-striped js-exportable" id="datatables">
                                <thead>
                                <tr>
                                    <th>Group Name</th>
                                    <th>Group Author</th>
                                    <th># of Users</th>
                                    <th>Create Date</th>
                                    <?php /* ?><th></th><?php */ ?>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($groups as $group)
                                    <?php
                                    $admin = $users->find($group->group_admin);
                                    $course_group = $courses->where(['group_id' => $group->group_id])->get();
                                    $course_users = $group_users->where(['group_id' => $group->group_id])->get();
                                    ?>
                                    <tr>
                                        <td>{{ $group->group_name }}</td>
                                        <td><?php echo $admin->firstname ?> <?php echo $admin->lastname  ?></td>
                                        <td>
                                            <a data-groupid="{{ $group->group_id }}" href="{{ route('admin.users.groups.groupusers',['group_id' => $group->group_id]) }}" class="btn btn-primary">
                                                <?php echo count($course_users) ?> Users <i class="fa fa-users"></i>
                                            </a>
                                        </td>
                                        <td>{{ $group->create_date }}</td>
                                        <?php /* ?>
                                        <td>
                                            <a href="{{ route('admin.users.groups.group',['group_id'=>$group->group_id]) }}" class="btn btn-primary">
                                            <i class="c-icon cil-touch-app active active"></i>
                                            </a>
                                        </td>
                                        <?php */ ?>
                                        <td>
                                            <button class="btn btn-success" data-toggle="modal" data-target="#modGroup" data-group_description="{{ addslashes($group->group_description) }}" data-group_name="{{ $group->group_name }}" data-group_id="{{ $group->group_id }}"  data-group_key="{{ $group->group_key }}">
                                            <i class="c-icon cil-pencil active"></i>
                                            </button>
                                        </td>

                                        <td>
                                            @if( $you->id !== $group->group_admin )
                                            <form name="DeleteGroupForm{{ $group->group_id }}" id="DeleteGroupForm{{ $group->group_id }}" action="{{ route('profilehub.admin.users.groups.createrecord') }}" method="POST">
                                                <input type="hidden" name="function" id="function{{ $group->group_id }}" value="del-group" />
                                                <input type="hidden" name="group_admin" id="group_admin{{ $group->group_id }}" value="{{ $group->group_admin }}" />
                                                <input type="hidden" name="group_id" id="group_id{{ $group->group_id }}" value="{{ $group->group_id }}" />
                                                @method('POST')
                                                @csrf
                                                <button type="button" class="btn btn-danger deleteFunc"
                                                data-key="dgf" data-pidv="{{ $group->group_id }}" data-fidv="{{ $group->group_id }}"
                                                data-bb-example-key="confirm-options" data-func="manual"
                                                data-formid="DeleteGroupForm{{ $group->group_id }}">
                                                <i class="c-icon c-icon-2xs cil-x-circle active"></i>
                                                </button>
                                            </form>
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
        </div>



@include('vendor.profilehub.admin.groups.users.modals.add-group-modal')
@include('vendor.profilehub.admin.groups.users.modals.edit-group-modal')
  <?php  ?>
  <form name="DeleteCourseGroupForm" id="DeleteCourseGroupForm" action="{{ route('profilehub.admin.users.groups.createrecord') }}" method="POST">
    <input type="hidden" name="function" id="function-cgd" value="del-user-group-user" />
    <input type="hidden" name="group_id" id="dcgf-pidv" value="" />
    <input type="hidden" name="user_id" id="dcgf-fidv" value="" />
    @method('POST')
    @csrf
    </form>
    <?php  ?>
@endsection


@section('javascript')

  <script src="{{ asset('vendor/profilehub/addons/datatables/bootstrap5/js/datatables.min.js') }}"></script>
 
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
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

    $(document).ready(function() {

      function showAddUserGroupModal() {
        if (
          typeof jQuery === 'undefined' ||
          typeof bootstrap === 'undefined' ||
          typeof bootstrap.Modal === 'undefined'
        ) {
          console.error("jQuery or Bootstrap Modal JS is not loaded correctly.");
          return;
        }
        var myModalEl = document.getElementById('addUserGroupModal');
        if (myModalEl) {
          var myModal = new bootstrap.Modal(myModalEl);
          myModal.show();
          console.log("Attempted to show addUserGroupModal programmatically.");
        } else {
          console.error("Modal element with ID 'addUserGroupModal' not found.");
        }
      }

      $('#showAddGroupModalBtn').on('click', function() {
        showAddUserGroupModal();
      });

      $('#datatables').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: 'Blfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
      });
      function addGroup(group_id, group_key) {
        document.getElementById(group_key).value = group_id;
      }

      function removeReq(group_id) {
        return true;
        var ckbxLen = $('[name="course_id[]"]:checked').length;
        alert(ckbxLen);
        if (ckbxLen < 0) {
          $(".checkboxRequired").prop('required', true);
          alert('aaa');
        }
        $(".checkboxRequired").removeAttr("required");
      }

        

      $('#all_user_id').click(function(event) {
        if (this.checked) {
          $(':checkbox').each(function() {
            this.checked = true;
          });
        } else {
          $(':checkbox').each(function() {
            this.checked = false;
          });
        }
      });

       
      

      function stringify(x) {
        console.log(Object.prototype.toString.call(x));
      }

      $(function() {
        $('[data-toggle="tooltip"]').tooltip();
      });

       

      function routeGo(url) {
        location.href = url;
      }

      function checkAll(isChecked, fieldname) {
        if (isChecked) {
          $('input[name="' + fieldname + '"]').each(function() {
            this.checked = true;
          });
        } else {
          $('input[name="' + fieldname + '"]').each(function() {
            this.checked = false;
          });
        }
      }

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $(".addUserGroupBtn").click(function(e) {
        e.preventDefault();
        var group_id = $(this).data('groupid');
        var result = '';
        $.ajax({
          type: 'POST',
          url: "{{ route('profilehub.admin.admin.group.users') }}",
          async: false,
          data: { 'group_id': group_id },
          success: function(data) {
            result = data;
          }
        });
        document.getElementById('UserGroupDiv').innerHTML = result;
      });
    });
  </script>

@endsection

