<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use App\Models\User;
use BabeRuka\ProfileHub\Models\UserGroups;
use BabeRuka\ProfileHub\Models\UserGroupUsers; 
use BabeRuka\ProfileHub\Models\PasswordResets;
use BabeRuka\ProfileHub\Http\Controllers\UsersController; 
use BabeRuka\ProfileHub\Models\Users;
use BabeRuka\ProfileHub\Models\UserField;
use BabeRuka\ProfileHub\Models\UserProfiles;
use BabeRuka\ProfileHub\Models\UserInputTypes; 
use BabeRuka\ProfileHub\Http\Controllers\AdminController;  
use BabeRuka\ProfileHub\Http\Controllers\Auth\RegisterController;  
use BabeRuka\ProfileHub\Repository\UserFunctions;
use Hash;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Validator;


class AdminUsersController extends Controller
{
    protected $module_id;
    protected $module;
    public $module_name;
    public $module_slug;
    public $page_title;
    protected $admin;

    public function __construct()
    { 
        $this->recipients = array('admin', 'superadmin');
        $this->group = 'user';
        $this->module_id = 1;
        $this->module_name = 'User Management';
        $this->module_slug = '_USER';
        $this->module = 'user';
        $this->page_title = $this->module_name;
        $this->admin = new AdminController();
    }
    public function index(Request $request): View|Response
    { 
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        session()->put('page_perm', $page_perm);
        $you = auth()->user();
        $Users = new User();
        $users = $Users->orderBy('id','desc')->get(); 
        $detail = new UsersController();
        $userdetails_headers = $detail->userDetailsTable(null, 1); 
        $all_users = array();
        $userdetails_cols = array();

        foreach ($userdetails_headers as $key => $value) {
            $userdetails_cols[$key]['col_name'] = $this->stripAll($value->translation);
        }
        //$array = $users->toArray();
        $all_users = (object)$all_users;
        $page_title = 'Users';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('vendor.profilehub.admin.users.users', compact('page_title', 'users', 'you', 'userdetails_headers', 'userdetails_cols', 'page_perm'));
    }
    function walk($val, $key, $new_array)
    {
        $nums = explode('-', $val);
        $new_array[$nums[0]] = $nums[1];
    }
 
     
    public function groups(): View|Response
    { 
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $groups = new UserGroups();
        $groups = $groups->all();
        $group_users = new UserGroupUsers();
        $users = User::all();
        $type_group = new UserInputTypes();
        $you = auth()->user();  
        $page_title = 'Groups';
        $page_title = $page_title ? $page_title : $this->page_title; 
        return view('vendor.profilehub.admin.groups.users.userGroups', compact('page_title', 'you', 'type_group', 'groups', 'users', 'group_users', 'page_perm'));
    }
    public function group(Request $request): View|Response
    { 
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $group_id = $request->post('group_id');
        $groups = new UserGroups();
        $groups = $groups->find($group_id);
        $group_users = new UserGroupUsers();
        $group_users = $group_users->where(['group_id' => $group_id])->get();
        $users = User::all();

        $you = auth()->user();
        $page_title = 'Group';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('vendor.profilehub.admin.users.userGroup', compact('page_title', 'you', 'groups', 'group_users', 'page_perm'));
    }

    public function groupUsers(Request $request) 
    { 
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $group_id = $request->input('group_id');
        $groups = new UserGroups();
        $group = $groups->find($group_id);
        $group_name = $group->group_name;
        $UserGroupUsers = new UserGroupUsers();
        $group_users = $UserGroupUsers->where(['group_id' => $group_id])->get();
        $users = User::all(); 
        $type_group = new UserInputTypes();
        $you = auth()->user();  
        $page_title = 'Groups';
        $page_title = $page_title ? $page_title : $this->page_title; 
        return view('vendor.profilehub.admin.groups.users.groupUsers', compact('page_title', 'group_name', 'you', 'type_group', 'group', 'users', 'group_users', 'page_perm'));
    }
    public function createrecord(Request $request)
    {
        $function_id = 0;
        $newgroup = new UserGroups();
        $userFunctions = new UserFunctions();
        $recipients = false;
        $user = Auth::User();   
        if ($request->has('function')) {
            if ($request->post('function') == 'update-password') {  
                $user = $user->find($request->post('user'));
                $user_email = $user->email;
                $user_password = $user->password;
                $token = $this->quick_random(64); 
                if (!$user->email) {
                    return back()->withInput()->with('error', 'Invalid email address!');
                }
                if ($request->post('user_password') != $request->post('user_password_repeat')) {
                    $message = 'The password submitted does not match the repeated password.';
                    return redirect()->back()->withErrors(['message' => $message]);
                }
                $PasswordResets = new PasswordResets();
                //update the token
                $Reset = $PasswordResets->where(['email' => $user->email, 'token' => $token])->first();
                if (!$Reset) {
                    $PasswordResets->email = $user_email;
                    $PasswordResets->token = $token;
                    $update = $PasswordResets->save();
                } else {
                    $Reset->email = $user_email;
                    $Reset->token = $token;
                    $update = $Reset->save();
                }
                if (!$update) {
                    return redirect()->back()->withErrors(['message' => 'Invalid token!']);
                }
                $user->password = Hash::make($request->post('user_password'));
                $passwordSaved = $user->save();
                if ($passwordSaved) {
                    return redirect()->back()->withSuccess(['message' =>  'password changed!']);
                } else {
                    return redirect()->back()->withErrors(['message' => 'password not changed!']);
                }
            }else if ($request->post('function') == 'create-user-group') { 
                $validator = Validator::make($request->all(), [
                    'group_name' => 'required',
                    'group_description' => 'required',
                    'group_type' => 'required',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $validatedData = $validator->validated();
                $group = new UserGroups();
                $group_id = $request->input('group_id');
                if ($group_id > 0) {
                    $group = $group->find($group_id);
                }
                $group_key = $this->stripAll($request->input('group_name'));
                $group->group_name              =   $request->input('group_name');  
                $group->group_description       =   $request->input('group_description');
                $group->group_key               =   $group_key;
                $group->group_admin             =   $user->id;
                $group->group_type             =   $request->input('group_type') ?? 'user'; 
                $group->save();
                $group_id = $group->group_id;
                if ($group_id <= 0) {
                    $group_id = $group->group_id;
                }
                $this->addUserToGroup($group_id, $user->id);
                $event_subject = 'User Group Created';
                $event_message = 'A user group [' . $request->input('group_name') . '] has been created by ' . auth()->user()->name . ' ';
                return redirect()->back();
            }else if ($request->post('function') == 'del-user-group') { 
                $group = new UserGroups();
                $group_id = $request->input('group_id');
                $group = $group->find($group_id);
                if ($group){
                    $group_name = $group->group_name;

                    $userGroupUsers = new UserGroupUsers();
                    $found_user = $userGroupUsers->where(['group_id' => $group_id])->delete(); 

                    $group->delete();
                    $message = 'A user group [' . $group_name . '] has been deleted by ' . auth()->user()->name . ' ';
                    session()->flash('message', $message);

                    return redirect()->back();
                } else {
                    return redirect()->back()->withErrors(['group_id' => 'Group not found or already deleted.']);
                }                
                
            }else if ($request->post('function') == 'force-profile-update') {
                $UserProfile = new UserProfiles();
                //dd($request->post()); num_filled
                $profile = $UserProfile->where(['user_id' => $request->post('user_id')])->first();
                if (!$profile) {
                    $UserProfile->user_id = $request->post('user_id');
                    $UserProfile->pforce = $request->post('pforce');
                    $UserProfile->num_rows = $request->post('num_rows');
                    $UserProfile->num_filled = $request->post('num_filled');
                    $UserProfile->save();
                } else {
                    $profile->user_id = $request->post('user_id');
                    $profile->pforce = $request->post('pforce');
                    $profile->num_rows = $request->post('num_rows');
                    $profile->num_filled = $request->post('num_filled');
                    $profile->save();
                }
                $message = 'your action was completed successfully';
                session()->flash('message', $message);
                return redirect()->back();
            
            }else if ($request->post('function') == 'add-user-to-group') { 
                $userGroupUsers = new UserGroupUsers();
                $group_id = $request->post('group_id'); 
                $found_users = $request->post('user_id'); 
                $result = 0;
                foreach($found_users as $index_id => $user_id){
                    $result_id = $this->addUserToGroup($group_id, $user_id);
                    if($result_id > 0){
                        $result+=1;
                    }
                }
                if($result > 0){
                    $message = 'you have subscribed '.$result.' users successfully to the group '.$group_name;
                    session()->flash('message',  $message); 
                }
                return redirect()->back(); 
            }else if ($request->post('function') == 'del-group-user') {  
                $userGroupUsers = new UserGroupUsers();
                $group_id = $request->input('group_id'); 
                $user_id = $request->post('user_id'); 
                $group = new UserGroups();
                $group = $group->find($group_id);
                $group_name = $group->group_name;
                $del_user = $userGroupUsers->where(['group_id' => $group_id, 'user_id' => $user_id])->delete();  
                if($del_user){
                    $message = 'you have unsubscribed the user successfully from the group '.$group_name;
                    session()->flash('message',  $message);
                    return redirect()->back(); 
                }
            }else{
                $message = 'your action was not completed successfully. Method not defined!';
            }
        }else{
            $message = 'Undefined method. The function was not defined correctly!';
        }
        session()->flash('message',  $message);
        return redirect()->back(); 
    }


    public function userdata(Request $request)
    {
        $detail = new UsersController();
        $query = $this->allUsersCompleteQuery();

        // DataTables params
        $draw = intval($request->input('draw', 0));
        $start = intval($request->input('start', 0));
        $length = intval($request->input('length', 10));
        $searchValue = trim($request->input('search.value', ''));

        // total records
        $totalResult = DB::selectOne("SELECT COUNT(*) as cnt FROM ({$query}) as t");
        $total = $totalResult->cnt ?? 0;

        $bindings = [];
        $filtered = $total;
        $rows = [];

        if ($searchValue !== '') {
            // Build simple search across common user fields
            $searchSql = " AND (
                u.name LIKE ? OR u.email LIKE ? OR ud.firstname LIKE ? OR ud.lastname LIKE ? OR ud.username LIKE ?
            ) ";
            $searchBinding = "%{$searchValue}%";
            $bindings = array_fill(0, 5, $searchBinding);

            // filtered count
            $countSql = "SELECT COUNT(*) as cnt FROM ({$query} {$searchSql}) as t";
            $countResult = DB::selectOne($countSql, $bindings);
            $filtered = $countResult->cnt ?? 0;

            // fetch page of results with search
            $dataSql = $query . $searchSql . " LIMIT ? OFFSET ? ";
            $bindings[] = $length;
            $bindings[] = $start;
            $rows = DB::select($dataSql, $bindings);
        } else {
            // no search, fetch page directly
            $dataSql = $query . " LIMIT ? OFFSET ? ";
            $rows = DB::select($dataSql, [$length, $start]);
        }

        $page_perm = session('page_perm') ?? [];

        // Build response data array, add action columns as in original implementation
        $data = [];
        foreach ($rows as $row) {
            // ensure properties exist (stdClass)
            $id = $row->id ?? null;
            $name = $row->name ?? ($row->username ?? '');
            $email = $row->email ?? '';

            $viewHtml = '<a href="' . route('profilehub.admin.users.user', ['id' => $id]) . '" data-toggle="tooltip" data-placement="top" title="View">
                        <i class="ri-cursor-fill"></i>
                    </a>';
            $permHtml = '<a data-bs-toggle="modal" href="#permModal" data-bs-target="#permModal" onClick="changePerm(' . $id . ',\'' . addslashes($name) . '\')" data-toggle="tooltip" data-placement="top" title="Permissions">
                        <i class="ri-lock-unlock-line"></i>
                    </a>';
            $editHtml = '<a href="' . route('profilehub.admin.profile.edit', ['id' => $id]) . '" class="EditAnything" data-formid="edit_user" data-fieldid="' . $id . '" data-rowid="edit_user_id" data-msg="Are you sure you want to edit this user  ' . $name . '" data-toggle="tooltip" data-placement="top" title="Edit ' . $name . '">
                        <i class="ri-edit-circle-fill text-primary"></i>
                    </a>';
            $deleteTitle = 'Delete ' . $name;
            $deleteMessage = 'Are you sure you want to delete this user? ' . $name . ' ';
            $formAction = route('profilehub.admin.users.destroy');
            $back_url = route('profilehub.admin.users');
            $deleteHtml = '<a href="#deleteModal" data-bs-toggle="modal" data-bs-target="#deleteModal" onClick="updateDeleteModal(\'' . addslashes($deleteTitle) . '\', \'' . addslashes($deleteMessage) . '\', \'' . $formAction . '\', \'id\', \'' . $id . '\', \'' . $back_url . '\')" data-formid="deleteForm" data-fieldid="' . $id . '" data-rowid="deleteId" data-msg="Are you sure you want to delete this user [' . $name . ' ]" data-toggle="tooltip" data-placement="top" title="Delete [' . $name . ']">
                            <i class="ri-delete-bin-5-line text-danger"></i>
                        </a>';

            $rolesHtml = ''; // placeholder (original returned empty)

            $rowArray = (array) $row;

            // Append action columns depending on permissions
            $rowArray['view'] = ($page_perm['view'] ?? false) ? $viewHtml : '&nbsp;';
            $rowArray['perm'] = (($page_perm['approve'] ?? false) || ($page_perm['create'] ?? false) || ($page_perm['update'] ?? false)) ? $permHtml : '&nbsp;';
            $rowArray['roles'] = (($page_perm['approve'] ?? false) || ($page_perm['create'] ?? false) || ($page_perm['update'] ?? false)) ? $rolesHtml : '&nbsp;';
            $rowArray['edit'] = ($page_perm['update'] ?? false) ? $editHtml : '&nbsp;';
            $rowArray['delete'] = ($page_perm['delete'] ?? false) ? $deleteHtml : '&nbsp;';

            $data[] = $rowArray;
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => intval($total),
            'recordsFiltered' => intval($filtered),
            'data' => $data,
        ]);
    }
    function allUsersCompleteQuery($custom_query = false)
    {
        $queryj = '';
        if ($custom_query) {
            $queryj = $custom_query;
        }
        $Userfield = new Userfield();
        $fields = $Userfield->all();
        $details = '';
        foreach ($fields as $field) {
            if ($field->type_field == 'dropdown') {
                $details .= " ( SELECT  user_field_son.translation
                FROM user_field_details
                INNER JOIN user_field_son ON user_field_son.son_id = user_field_details.user_entry
                WHERE `user_field_details`.`field_id` = " . $field->field_id . " AND `user_field_details`.`user_id` = u.`id`  LIMIT 1  ) AS `" . $this->stripAll($field->translation) . "`, ";
            } else {
                $details .= " ( SELECT user_field_details.user_entry
                FROM user_field_details
                INNER JOIN user_field ON user_field.field_id = user_field_details.field_id
                WHERE `user_field_details`.`field_id` = " . $field->field_id . " AND `user_field_details`.`user_id` = u.`id`  LIMIT 1) AS `" . $this->stripAll($field->translation) . "`, ";
            }
        }
        $query = "SELECT u.id, ud.user_id, ud.details_id, ud.username, ud.firstname,ud.lastname,ud.middle_name, ud.user_bio,ud.profile_pic,ud.user_avatar, u.`name`, 
        u.email,u.email_verified_at,u.updated_at AS lastlogin, u.updated_at AS last_seen,u.created_at,
        " . $details . "
        u.updated_at 
        FROM users AS u 
        LEFT JOIN user_details AS ud ON ud.user_id = u.id
        WHERE u.id IS NOT NULL " . $queryj . "";
        return $query;
    }
    function stripAll($strip)
    {
        $strip = preg_replace('/[.,:?]/', ' ', $strip);
        $strip = preg_replace('/[@#$%^&*()_+:"]/', ' ', $strip);
        $strip = str_replace("'", ' ', strtolower($strip));
        $strip = str_replace('"', ' ', $strip);
        $strip = str_replace('/', ' ', $strip);
        $strip = str_replace("", ' ', $strip);
        $strip = str_replace(" ", '_', $strip);
        $strip = str_replace("-", '_', strtolower($strip));
        return $strip;
    }
    public static function quick_random($length = false)
    {
        $length = ($length ? $length : 64);
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
  
 
    function new_admin_user(Request $request)
    {
        $RegisterController = new RegisterController();
        $UserDetailsController = new AdminUserDetailsController();
        $data = []; 
        $data['email'] = $request->post('email');
        $data['password'] = $request->post('password');
        $data['name'] = $request->post('firstname').' '.$request->post('lastname');
        $user_id = $request->post('user_id');
        $username = $request->post('username');
        $firstname = $request->post('firstname');
        $lastname = $request->post('lastname');
        $middle_name = $request->post('middle_name');
        $user_bio = $request->post('user_bio');
        $profile_pic = null;
        $user_avatar = null;
        if($user_id > 0){
            $UsersController = new UsersController();
            $UsersController->update($request, $user_id, 1, $request->post('firstname').' '.$request->post('lastname'));
            $result = $UserDetailsController->save_default_user_details($user_id,$username,$firstname,$lastname,$middle_name,$user_bio,$profile_pic,$user_avatar);
            if($result > 0){
                return redirect()->back()->with('success', 'User created successfully');
            }
            return redirect()->back()->with('Warning', 'Some details never saved!');
        }
        $RegisterController->create($data);

        $user = new User();
        $success = $user->where(['email' => $data['email']])->first();
        if($success){
            $user_id = $success->user_id;
            
            $result = $UserDetailsController->save_default_user_details($user_id,$username,$firstname,$lastname,$middle_name,$user_bio,$profile_pic,$user_avatar);
            if($result > 0){
                return redirect()->back()->with('success', 'User created successfully');
            }
            return redirect()->back()->with('Warning', 'Some details never saved!');
        }else{
            return redirect()->back()->with('Error', 'The user wasn\'t created! Please try again!');
        }
    }
    function addUserToGroup($group_id, $user_id){
        $userGroupUsers = new UserGroupUsers();
        $found_user = $userGroupUsers->where(['group_id' => $group_id, 'user_id' => $user_id])->first();
        $user_group_id = 0;
        if(!$found_user){
            $userGroupUsers->group_id = $group_id;
            $userGroupUsers->user_id = $user_id;
            $userGroupUsers->save();
            $user_group_id = $userGroupUsers->user_group_id;
        }
        return $user_group_id;
    }
}
