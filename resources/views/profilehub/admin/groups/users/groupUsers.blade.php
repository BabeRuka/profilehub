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
                <form id="userGroupForm" class="needs-validations" action="{{ route('profilehub.admin.users.groups.createrecord') }}" method="POST" novalidate>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-uppercase fw-bold">
                                <i class="fa fa-align-justify"></i> {{ $group_name }} 
                            </h5>
                        </div>
                        <div class="card-body">
                        <div class="body">

                                @csrf
                                @method('POST')
                                <input type="hidden" name="function" value="add-user-to-group" />
                                <input type="hidden" name="group_id" value="{{ $group->group_id }}" />
                                <input type="hidden" name="group_name" value="{{ $group_name ? $group_name : $group->group_name }}" />
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
                                            <th>ID</th> 
                                            <th>Names </th>
                                            <th>Email </th>
                                            <th>Register Date</th>
                                            <th></th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($users) > 0)
                                                @foreach($users as $user)   
                                                    
                                                    @php
                                                        $group_user = $group_users->where('user_id', $user->id)->first();
                                                        $found_user = $group_user ? $group_user->user_id : 0;
                                                    @endphp

                                                    <tr>
                                                        <td>
                                                            <div class="form-group form-check">
                                                                <label class="form-check-label">
                                                                <input class="form-check-input checkboxRequired" type="checkbox" name="user_id[]" value="{{ $user->id }}" {{ $user->id == $found_user ? 'checked' : '' }}  required>
                                                                <div class="form-group-messages"></div>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $user->id }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->created_at }}</td>
                                                        <td>
                                                            <a class="btn btn-danger active float-right me-2 btn-sm"  data-bs-toggle="modal" data-bs-target="#deleteModal"  onClick="updateDeleteModal('Remove User from Group', 'Are you sure youn want to remove {{ $user->name }} from this group - {{ $group->group_name }}?', '{{ route('profilehub.admin.users.groups.createrecord', ['group_id' => $group->group_id]) }}', 'user_id', '{{ $user-> id }}', 'function', 'del-group-user', 'POST', null)">
                                                                <i class="fas fa-user-minus me-1"></i> Remove User
                                                            </a>
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
                        <!-- Save Users Button -->
                        <button class="btn btn-primary active float-right me-2" type="submit">
                            <i class="fas fa-save me-1"></i> Save Users
                        </button>

                         
                    </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
        <form name="DeleteCourseGroupForm" id="DeleteCourseGroupForm" action="{{ route('profilehub.admin.users.groups.createrecord') }}" method="POST">
            <input type="hidden" name="function" id="function-cgd" value="del-user-group-user" />
            <input type="hidden" name="group_id" id="dcgf-pidv" value="" />
            <input type="hidden" name="user_id" id="dcgf-fidv" value="" />
            @method('POST')
            @csrf
        </form>
@include('vendor.profilehub.admin.modals.delete-modal')
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
          url: "{{ route('profilehub.admin.group.users') }}",
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

