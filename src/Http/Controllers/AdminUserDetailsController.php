<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use BabeRuka\ProfileHub\Repository\Login;
use BabeRuka\ProfileHub\Models\UserDetails;
use BabeRuka\ProfileHub\Models\UserField;
use BabeRuka\ProfileHub\Models\UserFieldDetails;
use BabeRuka\ProfileHub\Models\UserFieldSon;
use BabeRuka\ProfileHub\Models\UserFieldGroups;
use BabeRuka\ProfileHub\Models\UserFieldSonData;
use BabeRuka\ProfileHub\Models\UserFieldDetailsData;
use DB;
use BabeRuka\ProfileHub\Models\Users;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Input;
use BabeRuka\ProfileHub\Http\Controllers\AdminController; 

class AdminUserDetailsController extends Controller
{

    protected $module_id;
    protected $module;
    protected $admin;
    public $module_name;
    public $module_slug;
    public $page_title;
    
    
    public function __construct()
    {
        
        $request = new Request();
        $this->request = $request; 
        
        $this->module_id = 1;
        $this->module_name = 'User Management';
        $this->module_slug = '_USER';
        $this->module = 'user';
        $this->page_title = $this->module_name;
        $this->admin = new AdminController();
    }

    public function UserFieldDetailsModel()
    {
        $fields = new UserFieldDetails();
        return $fields;
    }
    public function index()
    {
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $fields = $this->UserFieldDetailsModel();
        $user_fields = $fields->user_field();
        $user_field_type = $fields->user_field_type();
        $user_groups = $fields->user_field_groups();
        $page_title = 'Additional Fields';
        $page_title = $page_title ? $page_title : $this->page_title;
        $user_id = Auth::id();
        return view('profilehub.vendor.admin.users.profile.usersDetails')->with(compact(['user_fields', 'user_field_type', 'user_groups', 'page_perm','page_title']));
    }

    public function userfield(Request $request)
    {
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $field = $this->UserFieldDetailsModel();
        $user_fields = $field->user_field();
        $son_fields = $field->user_field_son($request->input('id'));
        $user_field_type = $field->user_field_type();
        $user_id = Auth::id();
        $Userfield = new Userfield();
        $field = $Userfield->find($request->input('id'));
        $UserFieldGroups = new UserFieldGroups();
        $group = $UserFieldGroups->where(['group_id' => $field->group_id])->first();
        $UserFieldSonData = new UserFieldSonData();
        $fieldson_data = $UserFieldSonData->all();
        $page_title = 'Additional Field';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view(
            'admin.users.profile.usersDetailsField',
            [
                'group' => $group,
                'field' => $field,
                'user_fields' => $user_fields,
                'user_field_type' => $user_field_type,
                'son_fields' => $son_fields,
                'page_perm' => $page_perm,
                'son_data'  => $fieldson_data,
                'page_title' => $page_title,
            ]
        );
    }
    public function groups()
    {
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $fields = $this->UserFieldDetailsModel();
        $user_groups = $fields->user_field_groups();
        $user_field_type = $fields->user_field_type();
        $user_id = Auth::id();
        $page_title = 'Additional Fields';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('profilehub.vendor.admin.users.profile.userFieldGroups')->with(compact(['user_groups', 'page_perm','page_title']));
    }

    public function children(Request $request)
    {
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $id = $request->input('id');
        $field_data = $this->UserFieldDetailsModel();
        $children = $field_data->user_field(null, $id);
        $children = new Collection($children);
        $group_id = $id;
        $children = $children->sortBy('group_sequence');
        $page_title = 'Additional Fields';
        $page_title = $page_title ? $page_title : $this->page_title;
        $UserFieldGroups = new UserFieldGroups();
        $group = $UserFieldGroups->find($id);
        return view('profilehub.vendor.admin.users.profile.groupChildren', compact('group_id','group', 'children', 'page_perm','page_title'));
    }
    public function childrenData(Request $request){
        $son_id = $request->input('son_id');
        $UserFieldSonData = new UserFieldSonData();
        $fieldson_data = $UserFieldSonData->where(['son_id' => $son_id])->get();
        $table_d = '
        <table data-dropdowns class="table table-striped table-hover table-active">
        <thead>
            <tr>
                <th>#</th>
                <th>Dropdown Key</th>
                <th>Dropdown Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>';
        foreach($fieldson_data as $table_collumn){
            $table_d .= '
            <tr>
                <td>'.$table_collumn->data_id.'</td>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" name="dropdown_name['.$table_collumn->data_id.']" value="'.$table_collumn->data_key.'" required>
                        <div class="invalid-feedback">
                            Dropdown name is required.
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" name="dropdown_value['.$table_collumn->data_id.']" id="dropdown_value" value="'.$table_collumn->data_value.'"  required>
                        <div class="invalid-feedback">
                            Dropdown value is required.
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0)" data-remove><i class="fa fa-minus"></i></a>
                    <a href="javascript:void(0)" data-add><i class="fa fa-plus"></i></a>
                </td>
            </tr>';
        }
        $table_d .= '</tbody></table>';

        echo $table_d;

    }

    public function upUserDetailsTableData($user_id,$request)
    {
        $details_data = array();
        $user_rows = 0;
        foreach ($request->post('son_entry') as $field_id=>$field_data) {
            foreach ($field_data as $son_id=>$user_entry) {
                $field_entry = $user_entry;
                foreach ($field_entry as $user_key=>$user_entry) {
                    $details_data[] = $field_entry;
                    $sequence = $user_key + 1;
                    $user_rows = count($field_entry);
                    $this->controlUserDetailsSonTableData($field_id, $son_id, $user_id, $sequence, $user_entry, $user_rows);
                }
            }
        }
        $this->save_user_details($user_id,$field_id,$user_rows,json_encode($details_data));
    }
    function controlUserDetailsSonTableData($field_id, $son_id, $user_id, $sequence,$user_entry,$user_rows){
        $user_field_details = new UserFieldDetailsData();
        $user_data = $user_field_details->where(['field_id' => $field_id, 'son_id' => $son_id, 'user_id' => $user_id, 'sequence' => $sequence])->get();
        $details_data = array($field_id, $son_id, $user_id, $sequence,$user_entry);
        $details_data = json_encode($details_data);
        if($user_data->first()){
            $user_data = $user_data->first();
            $user_data->field_id = $field_id;
            $user_data->son_id = $son_id;
            $user_data->user_id = $user_id;
            $user_data->user_entry = $user_entry;
            $user_data->sequence = $sequence;
            $user_data->details_data = $details_data;
            $user_data->user_rows = $user_rows;
            $user_data->save();
        }else{
            $user_field_details->field_id = $field_id;
            $user_field_details->son_id = $son_id;
            $user_field_details->user_id = $user_id;
            $user_field_details->user_entry = $user_entry;
            $user_field_details->sequence = $sequence;
            $user_field_details->details_data = $details_data;
            $user_field_details->user_rows = $user_rows;
            $user_field_details->save();
        }

    }
    public function createrecord(Request $request, $bypass = false)
    {
        $fields = $this->UserFieldDetailsModel();
        
        if ($request->input('function') != '') {

            if ($request->input('function') == 'manage-user-detail') {
                $profile_pic = $this->save_profile_picture($request); 
                $user_avatar = $this->save_user_avatar($request);
                $result = $this->save_default_user_details($request->post('user_id'),$request->post('username'),$request->post('firstname'),$request->post('lastname'),$request->post('middle_name'),$request->post('user_bio'),$profile_pic,$user_avatar);
                if($result){
                    $request->session()->flash('message', 'Your action was completed successfully :-)');
                }else{
                    $request->session()->flash('message', 'Your action was not completed successfully! Please try again.');
                } 
                return redirect()->back();
            }

            //create user fields
            if ($request->input('function') == 'del-table-data') {
                $user_field_details = new UserFieldDetailsData();
                $user_field_details->where(['field_id' => $request->input('field_id'), 'user_id' => $request->input('user_id'), 'sequence' => $request->input('page_row')])->delete();
                $field_details = new UserFieldDetailsData();
                $num_rows = $request->input('page_row') - 1;
                $field_details->where(['field_id' => $request->input('field_id'), 'user_id' => $request->input('user_id')])->update(['user_rows' => $num_rows]);
                $user_details = new UserFieldDetails();
                $user_entry = $user_details->where(['field_id' => $request->input('field_id'), 'user_id' => $request->input('user_id')])->update(['user_entry' => $num_rows]);
                $request->session()->flash('message', 'your action was completed successfully');
                return redirect()->back();
            }

            if ($request->input('function') == 'add-user-field-son-data') {
                $count = 1;
                foreach ($request->post('dropdown_name') as $key => $dropdown_name) {
                    $son_data = new UserFieldSonData();
                    $dropdown_value = $request->post('dropdown_value')[$key];
                    $jdata = json_encode(array($dropdown_name, $dropdown_value));
                    $son_data->son_id = $request->post('son_id');
                    $son_data->data_key = $dropdown_name;
                    $son_data->data_value = $dropdown_value;
                    $son_data->data = $value = $jdata;
                    $son_data->data_sequence = $count;
                    $son_data->save();
                    $count++;
                }
                $request->session()->flash('message', 'your action was completed successfully');
                return redirect()->back();
            }

            if ($request->input('function') == 'up-user-field-son-data') {
                $count = 1;
                foreach ($request->post('dropdown_name') as $data_id => $dropdown_name) {
                    $son_data = new UserFieldSonData();
                    $found_son = $son_data->where(['son_id' => $request->input('son_id'), 'data_id' => $data_id ])->first();
                    $dropdown_value = $request->post('dropdown_value')[$data_id];
                    $jdata = json_encode(array($dropdown_name, $dropdown_value));
                    if(!$found_son){
                        $son_data = new UserFieldSonData();
                        $son_data->son_id = $request->post('son_id');
                        $son_data->data_key = $dropdown_name;
                        $son_data->data_value = $dropdown_value;
                        $son_data->data = $value = $jdata;
                        $son_data->data_sequence = $count;
                        $son_data->modified_date = NOW();
                        $son_data->save();
                    }else{
                        $found_son->son_id = $request->post('son_id');
                        $found_son->data_key = $dropdown_name;
                        $found_son->data_value = $dropdown_value;
                        $found_son->data = $value = $jdata;
                        $found_son->data_sequence = $count;
                        $found_son->modified_date = NOW();
                        $found_son->save();
                    }
                    $count++;
                }

                $request->session()->flash('message', 'your action was completed successfully');
                return redirect()->back();
            }

        if ($request->input('function') == 'delete-user-field-son') {
            
            $son_data = new UserFieldSon();
            $son_data->where(['son_id' => $request->input('son_id')])->delete();
            $request->session()->flash('message', 'your action was completed successfully');
            //dd($request->post());
            return redirect()->back();
        }
            //son settinggs
            if ($request->input('function') == 'add-user-field-son-date-data') {

                $UserFieldSon = new UserFieldSon();
                $son_data = $UserFieldSon->find($request->post('son_id'));
                $date_plugin = $request->post('date_plugin');
                $date_plugin_format = $request->post('date_plugin_format');
                $field_settings = array('date_plugin' => $date_plugin, 'date_plugin_format' => $date_plugin_format);
                $son_data->field_settings = json_encode($field_settings, true);
                $son_data->save();
                $request->session()->flash('message', 'your action was completed successfully');
                return redirect()->back();
            }
            if ($request->input('function') == 'add-user-field-son-range-data') {

                $UserFieldSon = new UserFieldSon();
                $son_data = $UserFieldSon->find($request->post('son_id'));
                $start_range = $request->post('start_range');
                $end_range = $request->post('end_range');
                $field_settings = array('start_range' => $start_range, 'end_range' => $end_range);
                $son_data->field_settings = json_encode($field_settings, true);
                $son_data->save();
                $request->session()->flash('message', 'your action was completed successfully');
                return redirect()->back();
            }
            if ($request->input('function') == 'add-user-field-son-widget-data') {

                $UserFieldSon = new UserFieldSon();
                $son_data = $UserFieldSon->find($request->post('son_id'));
                $input_type = $request->post('input_type');
                $dropdown_type = $request->post('dropdown_type');
                $dropdown_value = $request->post('dropdown_value');
                $field_settings = array('input_type' => $input_type, 'dropdown_type' => $dropdown_type, 'dropdown_value' => $dropdown_value);
                $son_data->field_settings = json_encode($field_settings, true);
                $son_data->save();
                $request->session()->flash('message', 'your action was completed successfully');
                return redirect()->back();
            }
            if ($request->input('function') == 'fix-son-sequence') {
                $UserFieldSon = new UserFieldSon();
                $sons = $UserFieldSon->where(['field_id' => $request->input('field_id')])->get();
                $count = 1;
                foreach ($sons as $son) {
                    $myson = new UserFieldSon();
                    $son = $myson->find($son->son_id);
                    $son->sequence = $count;
                    $son->save();
                    $count++;
                }
                $request->session()->flash('message', 'your action was completed successfully');
                return redirect()->back();
            }

            

            if ($request->input('function') == 'create-user-file') {
                
                $request->validate([
                    'translation' => 'required',
                    'type_field' => 'required',
                ]);
                if ($request->post('field_id') > 0) {
                    //edit the record
                    $fields->up_user_field($request->all());
                } else {
                    //add a new record
                    $fields->add_user_field($request->all());
                }
                $request->session()->flash('message', 'your action was completed successfully');
                return redirect()->back();
            } elseif ($request->input('function') == 'create-user-field-son') {
                
                $request->validate([
                    'translation' => 'required',
                    'field_id' => 'required',
                    'field_type' => 'required',
                ]);

                if ($request->post('son_id') > 0) {
                    //edit the record
                    $fields->up_user_field_son($request);
                } else {
                    //add a new record
                    $sequence = $this->son_sequence($request->post('field_id'));
                    $fields->add_user_field_son($request, $sequence);
                }
                
                $request->session()->flash('message', 'your action was completed successfully');
                return redirect()->back();
            } elseif ($request->input('function') == 'delete-user-field') {
                
                //son_id
                if ($request->post('son_id') > 0) {
                    $fields->down_user_field_son($request->post('son_id'));
                    $request->session()->flash('message', 'your action was completed successfully');
                    return redirect()->back();
                } else {
                    $fields->down_user_field($request->post('field_id'));
                    $request->session()->flash('message', 'your action was completed successfully');
                    return redirect()->back();
                }
            } elseif ($request->input('function') == 'create-group-name') {
                
                if ($request->post('group_id') > 0) {
                    $fields->up_user_group($request->post('group_id'));
                    $request->session()->flash('message', 'your action was completed successfully');
                    return redirect()->back();
                } else {
                    $fields->add_user_group($request->post('group_id'));
                    $request->session()->flash('message', 'your action was completed successfully');
                    return redirect()->back();
                }
            } elseif ($request->input('function') == 'delete-user-group') {
                //son_id
                
                if ($request->post('group_id') > 0) {
                    $fields->down_user_group($request->post('group_id'));
                    $request->session()->flash('message', 'your action was completed successfully');
                    return redirect()->back();
                }
            } elseif ($request->input('function') == 'manage-user') {
                
                $user = new Users();
                $user = $user->find($request->post('user_id'));
                $dir = '/files/user/';
                $FileController = new FileController();
                $profile_pic = ($request->hasFile('profile_pic') ? $FileController->uploadAnything($request->profile_pic, $request->profile_pic->getClientOriginalExtension(), $request->post('user_id'), 'profile_pic', $dir,'profile') : '');
                if ($profile_pic != '') {
                    $user->profile_pic = $profile_pic;
                    $user->save();
                }
                $user_id = $request->post('user_id'); 

                if ($user_id > 0) {
                    foreach ($request->input('user_entry') as $key => $value) {
                        $user_details = new UserFieldDetails();
                        $user_entry = $user_details->where(['field_id' => $key, 'user_id' => $user_id])->first();
                        if ($user_entry == null) {
                            $user_details->user_id = $user_id;
                            $user_details->field_id = $key;
                            $user_details->user_entry = $value;
                            $user_details->create_date = date('Y-m-d h:m:s');
                            $user_details->modified_date = date('Y-m-d h:m:s');
                            $user_details->save();
                        } else {
                            $user_entry->user_id = $user_id;
                            $user_entry->field_id = $key;
                            $user_entry->user_entry = $value;
                            $user_details->create_date = date('Y-m-d h:m:s');
                            $user_entry->modified_date = date('Y-m-d h:m:s');
                            $user_entry->save();
                        }
                    }
                }
                if ($bypass == 'bypass') {
                    return $user_id;
                }
                return redirect()->route('profilehub::users.index');
            } else {
                $request->session()->flash('message', 'your action was completed successfully');
                return redirect()->route('profilehub::admin.users.profile.fields');
            }
        }

    }
    public function manage(Request $request)
    {
        $field_data = $this->UserFieldDetailsModel();
        if ($request->input('function') != '') {
            if ($request->input('function') == 'manage-group-children') {
                $group_id = $request->input('group_id');
                if ($group_id > 0) {
                    foreach ($request->input('entry') as $key => $value) {
                        $field_data->up_anything('user_field', 'field_id', $key, 'group_sequence', $value);
                    }
                }
            }
            return redirect()->back();
        }
    }

    public function move(Request $request)
    {
        $field_data = $this->UserFieldDetailsModel();
        $field_id = $request->input('id');
        $direction = $request->input('dir');
        $type = $request->input('type');
        $sequence = $request->input('seq');
        if ($direction == 'up') {
            $replace_seq = $sequence - 1;
        } else if ($direction == 'down') {
            $replace_seq = $sequence + 1;
        }
        if ($type == 'field-parent') {
            $replace = $field_data->user_field(0, 0, $replace_seq);
        } else if ($type == 'field-child') {
            $group_id = $request->input('group');
            $field_query = ($group_id > 0 ? " AND group_id = '" . $group_id . "' " : '');
            $query = " SELECT * FROM `user_field` WHERE `group_sequence` = '" . $replace_seq . "' " . $field_query . " ";
            $replace = DB::select($query);
        } 
        $table_name = ($type == 'field-parent' ? 'user_field' : 'user_field');
        $redirect = ($type == 'field-parent' ? 'UserDetailsController@index' : 'UserDetailsController@children');
        $table_collumn = ($type == 'field-parent' ? 'sequence' : 'group_sequence');
        $redirect_id = ($type == 'field-parent' ? '' : $request->input('group'));

        //update the new sequence 
        $field_data->up_anything($table_name, 'field_id', $field_id, $table_collumn, $replace_seq);
        //downgrade the previous new sequence
         $field_data->up_anything($table_name, 'field_id', $replace[0]->field_id, $table_collumn, $sequence);
        return redirect()->back()->with('success','your action was completed successfully');
    }


    
    public function son_sequence($field_id)
    {
        $UserFieldSon = new UserFieldSon();
        $last_son = $UserFieldSon->where('field_id', $field_id)->orderBy('sequence', 'desc')->get();
        if ($last_son->first()) {
            $son = $last_son->first();
            if (!$son->sequence) {
                return 1;
            }
            $sequence = $son->sequence;
            $sequence = $sequence + 1;
            return $sequence;
        }
        return 1;
    }
    function save_user_details($user_id,$field_id,$user_entry,$details_data)
    {
     
        $user_details = new UserFieldDetails();
        $found_user_record = $user_details->where(['field_id' => $field_id, 'user_id' => $user_id])->first();
        if ($found_user_record == null) {
            $user_details->user_id = $user_id;
            $user_details->field_id = $field_id;
            $user_details->user_entry = $user_entry;
            $user_details->details_data = $details_data;
            $user_details->create_date = date('Y-m-d h:m:s');
            $user_details->modified_date = date('Y-m-d h:m:s');
            $user_details->save();
        } else {
            $found_user_record->user_id = $user_id;
            $found_user_record->field_id = $field_id;
            $found_user_record->user_entry = $user_entry;
            $found_user_record->details_data = $details_data;
            $found_user_record->modified_date = date('Y-m-d h:m:s');
            $found_user_record->save();
        }

    }
    function default_user_details(){
        return [
            'username',
            'firstname',
            'lastname',
            'middle_name',
            'user_bio',
            'profile_pic',
            'user_avatar'
        ];
    }
    function save_default_user_details($user_id,$username,$firstname,$lastname,$middle_name,$user_bio,$profile_pic=false,$user_avatar=false){
        $user_details = new UserDetails();
        $found_user_record = $user_details->where(['user_id' => $user_id])->first();
        if ($found_user_record == null) {
            $user_details->user_id = $user_id;
            $user_details->username = $username;
            $user_details->firstname = $firstname;
            $user_details->lastname = $lastname;
            $user_details->middle_name = $middle_name;
            $user_details->user_bio = $user_bio;
            $user_details->profile_pic = $profile_pic;
            $user_details->user_avatar = $user_avatar;
            $user_details->create_date = date('Y-m-d h:m:s');
            $user_details->modified_date = date('Y-m-d h:m:s');
            $user_details->save();
            return $user_details->details_id;
        } else {
            $found_user_record->username = $username;
            $found_user_record->firstname = $firstname;
            $found_user_record->lastname = $lastname;
            $found_user_record->middle_name = $middle_name;
            $found_user_record->user_bio = $user_bio;
            $found_user_record->profile_pic = $profile_pic;
            $found_user_record->user_avatar = $user_avatar;
            $found_user_record->modified_date = date('Y-m-d h:m:s');
            $found_user_record->save();
            return $found_user_record->details_id;
        }
    }
    function save_profile_picture($request){
        if ($request->hasFile('profile_pic') || $request->file('profile_pic') != '' || $request->post('profile_pic') != '') {
            $user_id = $request->post('user_id');
            $user_details = new UserDetails();
            $user = $user_details->find($user_id);
            if ($user && isset($user->profile_pic) && ($user->profile_pic != '' || $user->profile_pic != null)) {
                $old_profile_pic = $user->profile_pic;
                $dir = '/files/user/';
                $FileController = new FileController();
                $FileController->deleteProfilePicture($dir,$old_profile_pic);
            } 
            $dir = '/files/user/';
            $FileController = new FileController();
            $profile_pic = $request->file('profile_pic');  
            $extension = $profile_pic->getClientOriginalExtension();
            $saved_profile_pic = $FileController->uploadAnything($profile_pic, $extension, $user_id, 'profile_pic', $dir,'profile');
            if ($saved_profile_pic != '') { 
                return $saved_profile_pic;  
            }
        }
        return null;
    }

    function save_user_avatar($request){
        if ($request->hasFile('user_avatar') || $request->file('user_avatar') != '' || $request->post('user_avatar') != '') {
            $user_id = $request->post('user_id');
            $user_details = new UserDetails();
            $user = $user_details->find($user_id); 
            if($user->user_avatar != '' || $user->user_avatar != null){
                $old_user_avatar = $user->user_avatar;
                $dir = '/files/user/';
                $FileController = new FileController();
                $FileController->deleteProfilePicture($dir,$old_user_avatar);
            }
            //deleteProfilePicture($dir,$filename)
            $dir = '/files/user/';
            $FileController = new FileController();
            $saved_user_avatar = ($request->hasFile('user_avatar') ? $FileController->uploadAnything($request->user_avatar, $request->user_avatar->getClientOriginalExtension(), $user_id, 'user_avatar', $dir,'user_avatar') : '');
            if ($saved_user_avatar != '') {
                return $saved_user_avatar; 
            }
        }
        return null;
    }
    function destroy(Request $request){
        
        if($request->post('field_id') ){    
            $user_details = new UserField();
            $user_detail = $user_details->find($request->post('field_id'));
            if ($user_detail) {
                $user_detail->delete();
                $request->session()->flash('message', 'your action was completed successfully');
                return redirect()->back();
            }
        }
        $request->session()->flash('message', 'your action was not completed successfully');
        return redirect()->back();
    }
    function destroyGroup(Request $request){
        if($request->post('group_id') ){    
            $user_groups = new UserFieldGroups();
            $user_group = $user_groups->find($request->post('group_id'));
            if ($user_group) {
                $user_group->delete();
                $request->session()->flash('message', 'your action was completed successfully');
                return redirect()->back();
            }
        }
        $request->session()->flash('message', 'your action was not completed successfully');
        return redirect()->back();
    }
    
}
