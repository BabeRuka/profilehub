@extends('vendor.profilehub.layouts.admin')
@inject('userdetails', 'BabeRuka\ProfileHub\Models\UserFieldDetails')

<?php //{{ dd($userdetails_body) }} ?>
@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i>{{ __('Users') }}
                      @if($page_perm['update'] || $page_perm['create'])
                        <a class="btn btn-primary active float-right" data-toggle="modal" data-target="#bulkImportModal" >
                            Bulk Import
                        </a>
                        <a class="btn btn-primary active float-right mr-3" href="{{ route('profilehub.admin.users.createrecord') }}">
                            Add User
                        </a>
                      @endif
                    </div>
                    <div class="card-body">
                      <div class="body">
                        <div class="table-responsive">
                        <table class="table table-responsive-sm table-condensed table-striped js-exportable" id="datatables">
                        <thead>
                          <tr>
                            <th>Username</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>E-mail</th>
                            @foreach($userdetails_headers as $header)
                              <td>{{ $header->translation }}</td>
                            @endforeach
                            <th>Email verified at</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($users as $user)
                            <tr>
                              <td>{{ $user->username }}</td>
                              <td>{{ $user->firstname }}</td>
                              <td>{{ $user->lastname }}</td>
                              <td>{{ $user->email }}</td>
                                  @foreach($userdetails_headers as $header)
                                    <td>{{ $userdetails->one_user_field_details($header->field_id, $user->id) }}</td>
                                  @endforeach
                              <td>{{ $user->email_verified_at }}</td>
                              <td>
                                <a href="{{ url('/users/' . $user->id) }}" class="btn btn-primary">
                                  <i class="c-icon cil-touch-app active active"></i>
                                </a>
                              </td>
                              <td>
                                <a href="{{ route('profilehub.admin.users.manage.roles', ['user_id' => $user->id]) }}" class="btn btn-primary">
                                    <i class="c-icon cil-key active"></i>
                                </a>
                              </td>
                              <td>
                                <a href="{{ route('profilehub.admin.users.manage.roles', ['user_id' => $user->id]) }}" class="btn btn-primary">
                                    <i class="c-icon cil-lock-locked active"></i>
                                </a>
                              </td>
                              <td>
                                @if($page_perm['update'] || $page_perm['create'])
                                    <a href="{{ url('/users/' . $user->id . '/edit') }}" class="btn btn-success">
                                    <i class="c-icon cil-pencil active"></i>
                                    </a>
                                @endif
                              </td>
                              <td>
                                  @if($page_perm['delete'])
                                    @if( $user->id > 1 )
                                        <button type="button" class="btn btn-danger DeleteAnything" data-formid="del_user" data-fieldid="{{ $user->id }}" data-rowid="del_user_id" data-msg="Are you sure you want to delete this user {{ $user->username }} [{{ $user->firstname }} {{ $user->lastname }}]?" >
                                        <i class="c-icon c-icon-2xs cil-x-circle active"></i>
                                        </button>
                                    @endif
                                  @endif
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @if($page_perm['delete'])
            <form action="{{ route('profilehub.admin.users.destroy') }}" name="del_user" id="del_user" method="POST">
                <input type="hidden" name="id" id="del_user_id" value="0" />
                @method('DELETE')
                @csrf
            </form>
        @endif
        @if($page_perm['update'] || $page_perm['create'])
            <!-- create Modal start-->
            <div class="modal fade" id="bulkImportModal" tabindex="-1" role="dialog" aria-labelledby="bulkImportLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="needs-validation" action="{{ route('profilehub.admin.users.import.parse') }}" id="bulkImportForm" mult method="POST" enctype="multipart/form-data" novalidate>
                            @method('POST')
                            @csrf
                            <div class="modal-header">
                                <div class="container">
                                    <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times; </span>
                                    </button>
                                    <div id="confirmDelTitle"></div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                            <h4 class="mb-3"></h4>
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                                        <label for="csv_file" class="control-label">CSV file to import</label>
                                                        <input id="csv_file" type="file" class="form-control dropify" name="csv_file" required>
                                                        @if ($errors->has('csv_file'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('csv_file') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="header" >File contains header row?
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="modal-footer">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-8">
                                                <button class="btn btn-danger active float-right" type="submit">Parse CSV</button>
                                                <button type="button" class="btn btn-secondary mr-3 float-right" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal end -->
        @endif

@endsection


@section('javascript')
    <script src="{{ asset('addons/tinymce/5.8.1/js/tinymce.min.js') }}"></script>
    <script src="{{ asset('addons/datatables/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('addons/datatables/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('addons/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('addons/datatables/js/jszip.min.js') }}"></script>
    <script src="{{ asset('addons/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('addons/datatables/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('addons/datatables/js/buttons.html5.min.js') }}"></script>

    <script src="{{ asset('addons/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('addons/dropify/js/dropify.min.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $('#datatables').DataTable({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                ajax: ({
                    type: "POST",
                    url: '{{ route('profilehub.admin.users.userdata') }}'
                }),
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: 'Blfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                serverSide: true,
                processing: true,
                orderable: false,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'username', name: 'username'},
                    {data: 'firstname', name: 'firstname'},
                    {data: 'lastname', name: 'lastname'},
                    {data: 'email', name: 'email'},
                    <?php foreach($userdetails_cols as $header){ ?>
                        {data: '<?php echo $header['col_name'] ?>', name: '<?php echo $header['col_name'] ?>'},
                    <?php } ?>
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'lastlogin', name: 'lastlogin'},
                    {data: 'view', name: 'view'},
                    {data: 'perm', name: 'perm'},
                    {data: 'roles', name: 'roles'},
                    {data: 'edit', name: 'edit'},
                    {data: 'delete', name: 'delete'}
                ]
            });
        })
    </script>

    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script>
       //$('#course_date_begin,#course_date_end').datepicker({
       //     uiLibrary: 'bootstrap4'
       // });
      function changePerm(id,title){
        document.getElementById('perm_user').value = id;
        document.getElementById('confirmChangePermTitle').innerHTML = "Change "+title+"'s Password";
      }
      $(function() {
        $('.datepicker').each(function(){
            $(this).datepicker({
              endDate: Infinity,
              format: 'yyyy-mm-dd'
            });
        });
        $('.timepicker').each(function(){
            $(this).timepicker({
            });
        });
        $('.hourpicker').each(function(){
            $(this).timepicker({
                showSecond: true,
                showMillisec: true,
                timeFormat: 'hh:mm:ss:l'
            });
        });
        $('#input_time').timepicker({
            showSecond: true,
            showMinute: true,
            showHour: true,
            timeFormat: 'HH:mm:ss' });
      });

      $(document).ready(function() {
          $('.dropify').dropify({
            messages: {
              'default': '',
              'remove':  'Remove',
              'error':   'Ooops, something wrong happended.'
            }}
          );
          $('#datatables').DataTable();
      } );
    </script>
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
              $('#pwdId, #cPwdId').on('keyup', function () {
                if ($('#pwdId').val() != '' && $('#cPwdId').val() != '' && $('#pwdId').val() == $('#cPwdId').val()) {
                    $("#saveProfile").attr("disabled",false);
                    $('#cPwdValid').show();
                    $('#cPwdInvalid').hide();
                    $('#cPwdValid').html('Valid').css('color', 'green');
                    $('.pwds').removeClass('is-invalid')
                } else {
                    $("#saveProfile").attr("disabled",true);
                    $('#cPwdValid').hide();
                    $('#cPwdInvalid').show();
                    $('#cPwdInvalid').html('Not Matching').css('color', 'red');
                    $('.pwds').addClass('is-invalid');
                    //event.preventDefault();
                    //event.stopPropagation();
                }
              });
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();

      $('#addUserField').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var fieldname = button.data('fieldname');
        var fieldid = button.data('fieldid');
        var typefield = button.data('typefield');
        var group_name = button.data('groupname');
        document.getElementById('field_id').value = (fieldid === undefined || fieldid === null ) ? '' : fieldid;
        document.getElementById('translation').value = (fieldname === undefined || fieldname === null ) ? '' : fieldname;
        document.getElementById('type_field').value = (typefield === undefined || typefield === null ) ? '' : typefield;
        document.getElementById('group_id').value = (typefield === undefined || typefield === null ) ? '' : group_name;

        var modal = $(this);
        var title_msg = (fieldname === undefined || fieldname === null ) ? 'Add user field name' : 'Editing ' + fieldname+'' ;
        document.getElementById('addUserFieldTitle').innerHTML = title_msg;
      });
      $('#addUserFieldSon').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var fieldname = button.data('fieldname');
        var fieldid = button.data('fieldid');
        var son_id = button.data('sonid');
        document.getElementById('son_id').value = (son_id === undefined || son_id === null ) ? '' : son_id;
        document.getElementById('field_id').value = (fieldid === undefined || fieldid === null ) ? '' : fieldid;
        document.getElementById('translation').value = (fieldname === undefined || fieldname === null ) ? '' : fieldname;
        var modal = $(this);
        document.getElementById('modalTitle').innerHTML  = (fieldname === undefined || fieldname === null ) ? 'Add user field name' : 'Editing ' + fieldname+'' ;
      });
      $('#addUserGroup').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var fieldname = button.data('fieldname');
        var fieldid = button.data('fieldid');
        var typefield = button.data('typefield');
        document.getElementById('group_id').value = (fieldid === undefined || fieldid === null ) ? '' : fieldid;
        document.getElementById('group_name').value = (fieldname === undefined || fieldname === null ) ? '' : fieldname;
        var modal = $(this);
        var title_msg = (fieldname === undefined || fieldname === null ) ? 'Add user field name' : 'Editing ' + fieldname+'' ;
        document.getElementById('addUserGroupTitle').innerHTML = title_msg;
      });
      $('#addCategory').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var categoryid = button.data('categoryid');
        var categorypath = button.data('categorypath');
        var categoryparent = button.data('categoryparent');
        var categoryname = button.data('categoryname');
        var categorydesc = button.data('categorydesc');
        var categorylevel = button.data('categorylevel');
        document.getElementById('category_name').value = (categoryname === undefined || categoryname === null ) ? '' : categoryname;
        document.getElementById('category_id').value = (categoryid === undefined || categoryid === null ) ? '' : categoryid;
        document.getElementById('category_parent').value = (categoryparent === undefined || categoryparent === null ) ? '' : categoryparent;
        document.getElementById('category_level').value = (categorylevel === undefined || categorylevel === null ) ? '' : categorylevel;
        document.getElementById('category_description').value = (categorydesc === undefined || categorydesc === null ) ? '' : categorydesc;
      var modal = $(this);
        var title_msg = (categoryid === undefined || categoryid === null ) ? 'Add Category' : 'Editing ' + categoryname+'' ;
        document.getElementById('addCatTitle').innerHTML = title_msg;
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
    //DeleteAnything
    $(document).on("click", ".DeleteAnything", function(e) {
          var button = $(e.relatedTarget);
          var fieldid = $(this).data('fieldid');
          var formid = $(this).data('formid');
          var rowid = $(this).data('rowid');
          var msg = $(this).data('msg');
          document.getElementById(''+rowid+'').value  = fieldid;
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
    $(document).on("click", ".upAnything", function(e) {
          var button = $(e.relatedTarget);
          var key_id = $(this).data('key_id');
          //var formid = $(this).data('formid');
          var key_name = $(this).data('key_name');
          var group_key = $(this).data('group_key');
          var group_key1 = $(this).data('group_key1');
          document.getElementById(''+group_key+'').value  = key_name;
          document.getElementById(''+group_key1+'').value  = key_id;
    });
    $(document).on("click", ".DeleteUserField", function(e) {
          var button = $(e.relatedTarget);
          var fieldid = $(this).data('fieldid');
          var msg = $(this).data('msg');
          bootbox.confirm({
              message: (msg ? ''+msg+'' : 'Please confirm delete!') ,
              centerVertical: true,
              buttons: { confirm: { label: 'Yes', className: 'btn-success active ml-3' },
              cancel: { label: 'No', className: 'btn-danger active' } },
              callback: function (result) {
                console.log(result);
                if(result==true){
                  document.getElementById(''+fieldid+'').submit();
                }
              }
          });
    });
    $(document).on("click", ".courseUserSub", function(e) {
          var button = $(e.relatedTarget);
          var fieldid = $(this).data('fieldid');
          var msg = $(this).data('msg');
          var courseid = $(this).data('courseid');
          var userid = $(this).data('userid');
          var level = $(this).data('level');

          if(level==700){
            bootbox.confirm({
                message: (msg ? ''+msg+'' : 'Please confirm delete!') ,
                centerVertical: true,
                buttons: { confirm: { label: 'Yes', className: 'btn-success active ml-3' },
                cancel: { label: 'No', className: 'btn-danger active' } },
                callback: function (result) {
                  console.log(result);
                  if(result==true){
                    document.getElementById(''+fieldid+'').submit();
                  }
                }
            });
          }else if(level == 700){
                bootbox.prompt({
                  title: 'Course Role',
                  message: msg ,
                  inputType: 'select',
                  className: 'selectpicker form-control',
                  buttons: { confirm: { label: 'Yes', className: 'btn-success active ml-3' },
                  cancel: { label: 'No', className: 'btn-danger active' } },
                  value: level,
                  inputOptions: [
                    {
                        text: 'Choose one...',
                        value: '',
                    },
                    { text: 'Guest',  value: '1', }, { text: 'Ghost',  value: '2', }, { text: 'Student',  value: '3', },
                    { text: 'Tutor',  value: '4', }, { text: 'Mentor',  value: '5', }, { text: 'Instructor',  value: '6', },
                    { text: 'Administrator',  value: '7', }, { text: 'Manager',  value: '8', }
                  ],
                  callback: function (result) {
                    if (result != null) {
                      document.getElementById('role_id').value  = result;
                      document.getElementById('sub_user_id').value = userid;
                      document.getElementById('subUserForm').submit();
                    }else{
                      //do nothing
                    }
                  }
              });
              $('.bootbox-input-select').addClass("selectpicker form-control");
            }else if(level == 701){
              bootbox.confirm({
                  message: (msg ? ''+msg+'' : 'Please confirm!') ,
                  centerVertical: true,
                  buttons: { confirm: { label: 'Yes', className: 'btn-success active ml-3' },
                  cancel: { label: 'No', className: 'btn-danger active' } },
                  callback: function (result) {
                    console.log(result);
                    if(result==true){
                      document.getElementById('role_id').value  = 3;
                      document.getElementById('sub_user_id').value = userid;
                      document.getElementById('subUserForm').submit();
                    }
                  }

              });
            }else if(level == 702){
              bootbox.confirm({
                  message: (msg ? ''+msg+'' : 'Please confirm!') ,
                  centerVertical: true,
                  buttons: { confirm: { label: 'Yes', className: 'btn-success active ml-3' },
                  cancel: { label: 'No', className: 'btn-danger active' } },
                  callback: function (result) {
                    console.log(result);
                    if(result==true){
                      document.getElementById('role_id_removed').value  = 3;
                      document.getElementById('user_id_removed').value = userid;
                      document.getElementById('delUserForm').submit();
                    }
                  }

              });
          }
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
    $(document).ready(function() {
    $('#assignRolestable').DataTable( {
        "scrollX": false
    } );
} );
</script>
@endsection

