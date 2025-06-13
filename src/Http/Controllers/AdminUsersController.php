<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use BabeRuka\ProfileHub\Models\User;
use BabeRuka\ProfileHub\Models\UserGroups;
use BabeRuka\ProfileHub\Models\UserGroupUsers; 
use BabeRuka\ProfileHub\Models\PasswordResets;
use BabeRuka\ProfileHub\Http\Controllers\UsersController; 
use BabeRuka\ProfileHub\Models\Users;
use BabeRuka\ProfileHub\Models\UserField;
use BabeRuka\ProfileHub\Models\UserProfiles;
use BabeRuka\ProfileHub\Models\Groups; 
use BabeRuka\ProfileHub\Http\Controllers\AdminController;  
use BabeRuka\ProfileHub\Http\Controllers\Auth\RegisterController;  
use Hash;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use function PHPUnit\Framework\isEmpty;

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
        $request->session()->put('page_perm', $page_perm);
        $you = auth()->user();
        $all = new Users();
        $users = $all->whereNull('deleted_at')->get();
        $detail = new UsersController();
        $userdetails_headers = $detail->userDetailsTable(null, 1);
        $user = $all->find(1);
        $all_users = array();
        $userdetails_cols = array();

        foreach ($userdetails_headers as $key => $value) {
            $userdetails_cols[$key]['col_name'] = $this->stripAll($value->translation);
        }
        $array = $users->toArray();
        $all_users = (object)$all_users;
        $page_title = 'Users';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('profilehub.vendor.admin.users.users', compact('page_title', 'users', 'you', 'userdetails_headers', 'userdetails_cols', 'page_perm'));
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
        $type_group = new Groups();
        $you = auth()->user();
        $page_title = 'Groups';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('profilehub.vendor.admin.users.usersGroups', compact('page_title', 'you', 'type_group', 'groups', 'users', 'group_users', 'page_perm'));
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
        return view('profilehub.vendor.admin.users.usersGroup', compact('page_title', 'you', 'groups', 'group_users', 'page_perm'));
    }
    public function createrecord(Request $request)
    {
        $function_id = 0;
        $newgroup = new UserGroups();
        $recipients = false;
        if ($request->input('function') == 'update-password') { 
            
            $user = new User();
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
        }
        if ($request->input('function') == 'create-user-group') { 
            $validatedData = $request->validate([
                'group_name'       => 'required',
                'group_description' => 'required',
                'group_type' => 'required'
            ]);
            $group = new UserGroups();
            $group_id = $request->input('group_id');
            if ($group_id > 0) {
                $group = $group->find($group_id);
            }
            $group->group_name              =   $request->input('group_name');
            $group->group_description       =   $request->input('group_description');
            $group->group_key               =   $request->input('group_key');
            $group->group_admin             =   $request->input('group_admin');
            $group->group_type             =   $request->input('group_type');
            $function_id = $group->save();
            if ($group_id <= 0) {
                $group_id = $group->group_id;
            }
            $event_subject = 'User Group Created';
            $event_message = 'A user group [' . $request->input('group_name') . '] has been created by ' . auth()->user()->name . ' ';
        }
        if ($request->input('function') == 'del-user-group') { 
            $eventClass = 'UserGroupRemove';
            $function_id = $course->downAnything('user_groups', 'group_id', $request->post('group_id'));
            $grp = $newgroup->find($request->post('group_id'));
            $event_subject = 'User Group Deleted';
            $event_message = 'A user group [' . $grp->group_name . '] has been deleted by ' . auth()->user()->name . ' ';
        }
         
         
        if ($request->input('function') == 'force-profile-update') {
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
            $request->session()->flash('message', $message);
            return redirect()->back();
        }
        if ($function_id > 0) {
            $message = 'your action was completed successfully';
        } else {
            $message = 'your action was not completed successfully';
        }
         
        $request->session()->flash('message',  $message);
        return redirect()->back(); 
    }
    
   
    public function userdata()
    {
        $detail = new UsersController();
        $query = $this->allUsersCompleteQuery();
        $users = DB::select($query);

        return datatables()->of($users)
            ->addColumn('view', function ($row) {
                $page_perm = session('page_perm');
                $html = '<a href="' . route('profilehub::admin.users.user', ['id' => $row->id]) . '" class="" data-toggle="tooltip" data-placement="top" title="View">
                        <i class="ri-cursor-fill"></i>
                    </a>';
                return ($page_perm['view'] ? $html : '&nbsp');
            })
            ->addColumn('perm', function ($row) {
                $comma = "'";
                $page_perm = session('page_perm');
                $html = '<a data-bs-toggle="modal" href="#permModal" data-bs-target="#permModal" onClick="changePerm(' . $row->id . ',' . $comma . addslashes($row->name) . $comma . ')" class="" data-toggle="tooltip" data-placement="top" title="Permissions">
                        <i class="ri-lock-unlock-line"></i>
                    </a>';
                return ($page_perm['approve'] || $page_perm['create'] || $page_perm['update'] ? $html : '&nbsp');
            })

            ->addColumn('roles', function ($row) {
                $page_perm = session('page_perm');
                $html = '';
                return ($page_perm['approve'] || $page_perm['create'] || $page_perm['update'] ? $html : '&nbsp');
            })

            ->addColumn('edit', function ($row) {
                $page_perm = session('page_perm');
                $html = '<a href="' . route('profilehub::admin.users.user.edit', ['id' => $row->id]) . '" class="EditAnything" data-formid="edit_user" data-fieldid="' . $row->id . '" data-rowid="edit_user_id" data-msg="Are you sure you want to edit this user  ' . $row->name . '" class="" data-toggle="tooltip" data-placement="top" title="Edit ' . $row->name . '">
                        <i class="ri-edit-circle-fill text-primary"></i>
                    </a>';
                return ($page_perm['update'] ? $html : '&nbsp');
            })
            ->addColumn('delete', function ($row) {
                $page_perm = session('page_perm');
                $title = 'Delete ' . $row->name. '';
                $deleteIdName = 'id';
                $message = 'Are you sure you want to delete this user? ' . $row->name . ' ';
                $formAction = route('profilehub::admin.users.destroy') ;
                $back_url = route('profilehub::admin.users');
                $html = '<a href="#deleteModal" data-bs-toggle="modal" data-bs-target="#deleteModal" onClick="updateDeleteModal(\'' . $title . '\', \'' . $message . '\', \'' . $formAction . '\', \'' . $deleteIdName . '\', \'' . $row->id . '\', \'' . $back_url . '\')" class="" data-formid="deleteForm" data-fieldid="' . $row->id . '" data-rowid="deleteId" data-msg="Are you sure you want to delete this user [' . $row->name . ' ]" data-toggle="tooltip" data-placement="top" title="Delete [' . $row->name . '">
                            <i class="ri-delete-bin-5-line text-danger"></i>
                        </a>';
                return ($page_perm['delete'] ? $html : '&nbsp');
            })
            ->rawColumns(['view', 'perm', 'roles', 'edit', 'delete'])
            ->toJson();
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
                WHERE `user_field_details`.`field_id` = " . $field->field_id . " AND `user_field_details`.`user_id` = u.`user_id`  LIMIT 1  ) AS `" . $this->stripAll($field->translation) . "`, ";
            } else {
                $details .= " ( SELECT user_field_details.user_entry
                FROM user_field_details
                INNER JOIN user_field ON user_field.field_id = user_field_details.field_id
                WHERE `user_field_details`.`field_id` = " . $field->field_id . " AND `user_field_details`.`user_id` = u.`user_id`  LIMIT 1) AS `" . $this->stripAll($field->translation) . "`, ";
            }
        }
        $query = "SELECT u.id, ud.user_id, ud.details_id, ud.username, ud.firstname,ud.lastname,ud.middle_name, ud.user_bio,ud.profile_pic,ud.user_avatar, u.`name`, 
        u.email,u.email_verified_at,u.updated_at AS lastlogin,ud.profile_pic,u.updated_at AS last_seen,u.created_at,
        " . $details . "
        u.updated_at 
        FROM users AS u 
        LEFT JOIN user_details AS ud ON ud.user_id = u.id
        WHERE u.deleted_at IS NULL " . $queryj . "";
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
}
