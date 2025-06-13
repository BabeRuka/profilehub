@extends('vendor.profilehub.layouts.admin')
<?php
//dd($type_group);
$group_type = $type_group->where(['type_key' => 'user'])->get();
?>
@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <button type="button" class="btn btn-primary active float-right" data-toggle="modal" data-bs-toggle="modal" data-bs-target="#addGroupModal">
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
                                            <a data-groupid="{{ $group->group_id }}" href="{{ route('profilehub.admin.users.groups.groupusers',['group_id' => $group->group_id]) }}" class="btn btn-primary">
                                                <?php echo count($course_users) ?> Users <i class="fa fa-users"></i>
                                            </a>
                                        </td>
                                        <td>{{ $group->create_date }}</td>
                                       
                                        <td>
                                            <button class="btn btn-success" data-toggle="modal" data-target="#modGroup" data-group_description="{{ addslashes($group->group_description) }}" data-group_name="{{ $group->group_name }}" data-group_id="{{ $group->group_id }}"  data-group_key="{{ $group->group_key }}">
                                            <i class="c-icon cil-pencil active"></i>
                                            </button>
                                        </td>

                                        <td>
                                            @if( $you->id !== $group->group_admin )
                                            <form name="DeleteGroupForm{{ $group->group_id }}" id="DeleteGroupForm{{ $group->group_id }}" action="{{ route('profilehub.admin.groups.createrecord') }}" method="POST">
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

@include('profilehub::admin.groups.users.modals.add-group-modal')
@include('profilehub::admin.groups.users.modals.edit-group-modal')


<!-- Modal start-->
<div class="modal fade" id="addUserGroup" class="group-form" tabindex="-1" role="dialog" aria-labelledby="addUserGroupLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form id="userGroupForm" class="needs-validations" action="{{ route('profilehub.admin.groups.createrecord') }}" method="POST" novalidate>
          @csrf
          @method('POST')
          <input type="hidden" name="function" id="add_users_group_function" value="add-user-to-group" />
          <input type="hidden" name="users_group_id" id="users_group_id" value="0" />
          <input type="hidden" name="group_id" id="add_course_group_id" value="0" />
          <div class="modal-header">
            <div class="container">
              <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;
                </span>
              </button>
              <h5 class="modal-title" id=" addUserGroupTitle">Add user to group</h5>
            </div>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12 col-md-8">
                  <h4 class="mb-3">
                  </h4>
                  <div class="row">
                    <div class="table-responsive" id="UserGroupDiv"> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="container">
                <div class="row">
                  <div class="col-xs-12	col-sm-12 col-md-12	col-lg-12 col-md-8 ">
                    <button class="btn btn-primary active float-right" type="submit">Save</button>
                    <button class="btn btn-danger active float-right mr-3" name="bulk-remove-groups" id="bulk-remove-groups" value="1" type="submit">Remove</button>
                    <button type="submit" class="btn btn-secondary float-right mr-3" data-dismiss="modal">Close</button>
                  </div>
                </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal end -->
  <?php  ?>
  <form name="DeleteCourseGroupForm" id="DeleteCourseGroupForm" action="{{ route('profilehub.admin.groups.createrecord') }}" method="POST">
    <input type="hidden" name="function" id="function-cgd" value="del-user-group-user" />
    <input type="hidden" name="group_id" id="dcgf-pidv" value="" />
    <input type="hidden" name="user_id" id="dcgf-fidv" value="" />
    @method('POST')
    @csrf
    </form>
    <?php  ?>
@endsection


@section('javascript')

    <script src="{{ asset('addons/datatables/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('addons/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('addons/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('addons/dropify/js/dropify.min.js') }}"></script>
	
    <script src="{{ asset('addons/gijgo/gijgo-master/dist/combined/js/gijgo.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('addons/gijgo/gijgo-master/dist/combined/css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
    <script>window.jQuery || document.write('<script src="{{ asset('addons/material-design/js/jquery-3.3.1.slim.min.js') }}"><\/script>')</script>
    <script src="{{ asset('addons/material-design/js/popper.min.js') }}"></script>
    <script src="{{ asset('addons/material-design/js/bootstrap-material-design.min.js') }}"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('addons/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('addons/material-design/js/holder.min.js') }}"></script>
    <!-- Jquery Validation Plugin Css -->
    <script src="{{ asset('addons/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('addons/material-design/js/pages/forms/form-validation.js') }}"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';
        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');
          // Loop over them and prevent submission
          // forms.attr('name')
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

      function addGroup(group_id,group_key){
          document.getElementById(''+group_key+'').value = group_id;
      }
      function removeReq(group_id){
          return true;
          var ckbxLen = $('[name="course_id[]"]:checked').length;
          alert(ckbxLen);
          if(ckbxLen < 0) {
                $(".checkboxRequired").prop('required',true);
                alert('aaa');
          }
          $(".checkboxRequired").removeAttr("required");
      }
      $('#courseGroupForm').validate({
        rules:{
            'course_id[]':{
                required:true,
                minlength:1,
                maxlength:200
            }
        },
        messages:{
            'course_id[]':{
                required:"Please check at least 1 option.",
                minlength:"Please check at least {0} option."
            }
        },
        highlight:function(element){
		    $(element).closest('.form-group-messages').removeClass('was-validated').addClass('invalid-feedback');
        },
        unhighlight:function(element){
            $(element).closest('.form-group-messages').removeClass('invalid-feedback').addClass('was-validated');
        },
        errorClass:'invalid-feedback',
        errorPlacement:function(error,element){
            if(element.parent('.form-group-messages').length){
                error.insertAfter(element.parent());
            }else{
                error.insertAfter(element.parent());
            }
            if(element.attr('name')=='course_id[]'){
                error.insertAfter('#checkboxGroup');
            }else{
                error.appendTo(element.parent().next());
            }
        }
      });

      $('#userGroupForm').validate({
        rules:{
            'user_id[]':{
                required:true,
                minlength:1,
                maxlength:200
            }
        },
        messages:{
            'user_id[]':{
                required:"Please check at least 1 option.",
                minlength:"Please check at least {0} option."
            }
        },
        highlight:function(element){
		    $(element).closest('.form-group-messages').removeClass('was-validated').addClass('invalid-feedback');
        },
        unhighlight:function(element){
            $(element).closest('.form-group-messages').removeClass('invalid-feedback').addClass('was-validated');
        },
        errorClass:'invalid-feedback',
        errorPlacement:function(error,element){
            if(element.parent('.form-group-messages').length){
                error.insertAfter(element.parent());
            }else{
                error.insertAfter(element.parent());
            }
            if(element.attr('name')=='course_id[]'){
                error.insertAfter('#checkboxGroup');
            }else{
                error.appendTo(element.parent().next());
            }
        }
      });
      $('#modGroup').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var group_description = button.data('group_description');
        var group_name = button.data('group_name');
        var group_key = button.data('group_key');
        var group_id = button.data('group_id');
        document.getElementById('group_id').value = ( group_id === undefined ||  group_id === null ) ? '' :  group_id;
        document.getElementById('group_name').value = (group_name === undefined || group_name === null ) ? '' : group_name;
        group_description = (group_description === undefined || group_description === null ) ? '' : group_description;
        document.getElementById('group_description').value = group_description;
        //$('#group_description').val(group_description);
       tinymce.get('group_description').setContent(''+group_description+'');
        document.getElementById('group_key').value = (group_key === undefined || group_key === null ) ? '' : group_key;
        var modal = $(this);
        var title_msg = (group_name === undefined || group_name === null ) ? 'Add User Group' : 'Editing ' + group_name+'' ;
        document.getElementById('modGroupTitle').innerHTML = title_msg;
      });
      //
</script>
<script src="{{ asset('addons/bootbox/bootbox.min.js') }}"></script>
<script src="{{ asset('addons/bootbox/bootbox.locales.min.js') }}"></script>
<script>
  $('#all_user_id').click(function(event) {
      if(this.checked) {
          // Iterate each checkbox
          $(':checkbox').each(function() {
              this.checked = true;
          });
      } else {
          $(':checkbox').each(function() {
              this.checked = false;
          });
      }
    });
    $(document).on("click", ".routeGo", function(e) {
          var button = $(e.relatedTarget);
          var url = $(this).data('url');
          var msg = $(this).data('msg');
          bootbox.confirm({
              message: (msg ? ''+msg+'' : 'Please confirm delete!') ,
              centerVertical: true,
              buttons: { confirm: { label: 'Yes', className: 'btn-success active ml-3' },
              cancel: { label: 'No', className: 'btn-danger active' } },
              callback: function (result) {
                console.log(result);
                if(result==true){
                  routeGo(''+url+'');
                }
              }
          });
    });
    $(document).on("click", ".deleteFunc", function(e) {
          var button = $(e.relatedTarget);
          var formid = $(this).data('formid');
          var pid = $(this).data('pidv');
          var fid = $(this).data('fidv');
          var key = $(this).data('key');
          var msg = $(this).data('msg');
          var func = $(this).data('func');
          if(func=='dynamic'){
            document.getElementById(''+key+'-pidv').value = pid;
            document.getElementById(''+key+'-fidv').value = fid;
          }
          bootbox.confirm({
              message: (msg ? ''+msg+'' : 'Please confirm delete!') ,
              centerVertical: true,
              buttons: { confirm: { label: 'Yes', className: 'btn-success active ml-3' },
              cancel: { label: 'No', className: 'btn-danger active' } },
              callback: function (result) {
                console.log(result);
                if(result==true){
                  document.getElementById(''+formid+'').submit();
                }
              }
          });
    });
    $('#course_id_all').click(function() {
        var checkedStatus = this.checked;
        $('#groupCourseTable tbody tr').find('td:first :checkbox').each(function() {
            $(this).prop('checked', checkedStatus);
        });
    });
    function stringify (x) {
          console.log(Object.prototype.toString.call(x));
    }
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    tinymce.init({
        selector: 'textarea',
        toolbar_mode: 'floating',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullpage | ' +
      'forecolor backcolor emoticons | help',
      menu: {
          file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
          edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
          view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
          insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
          format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' },
          tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
          table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
          help: { title: 'Help', items: 'help' }
        },
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
    });
    function routeGo(url){
    	location.href = url;
    }
 	function checkAll(isChecked,fieldname) {
        //var fieldname = 'course_id[]';
		if(isChecked) {
			$('input[name="'+fieldname+'"]').each(function() {
					this.checked = true;
			});
		} else {
			$('input[name="'+fieldname+'"]').each(function() {
					this.checked = false;
			});
		}
    }
   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
    
   $(".addUserGroupBtn").click(function(e){
       e.preventDefault();
       var group_id =  $(this).data('groupid');
       console.log(group_id);
       $.ajax({
          type:'POST',
          url:"{{ route('profilehub.admin.ajax.groups.users') }}",
          async: false,
          data:{ 'group_id' : group_id},
          success:function(data) {
              result = data;
          }
       });
       document.getElementById('UserGroupDiv').innerHTML = result;
       //alert(result);
   });

</script>

@endsection

