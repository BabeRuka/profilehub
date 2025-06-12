<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use BabeRuka\ProfileHub\Http\Controllers\UsersController;
use BabeRuka\ProfileHub\Http\Controllers\AdminUserDetailsController;
use BabeRuka\ProfileHub\Models\UserProfiles;
use BabeRuka\ProfileHub\Models\UserField;
use BabeRuka\ProfileHub\Models\UserDetails;
use BabeRuka\ProfileHub\Models\Countries;
use BabeRuka\ProfileHub\Models\CountryStates;
use BabeRuka\ProfileHub\Models\PageData;
use BabeRuka\ProfileHub\Models\UserFieldDetailsData; 
use BabeRuka\ProfileHub\Models\User;
use BabeRuka\ProfileHub\Models\UserFieldSonData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;
use BabeRuka\ProfileHub\Models\Roles;
use BabeRuka\ProfileHub\Repository\UserFunctions;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use BabeRuka\ProfileHub\Http\Controllers\AdminController; 

class ProfileController extends Controller
{

    protected $module_id;
    protected $module;
    public $module_name;
    public $module_slug;
    public $page_title;
    protected $admin;

    public function __construct()
    {
        $this->middleware('auth');
        $this->module_id = 1;
        $this->module_name = 'User Management';
        $this->module_slug = '_USER';
        $this->module = 'user';
        $this->page_title = $this->module_name;
        $this->admin = new AdminController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View|Response
    {
        $UserFunctions = new UserFunctions();
        $UserDetailsController = new AdminUserDetailsController(); 
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $default_user_details = $UserDetailsController->default_user_details();
        $details = new UsersController();
        $user_details = new UserDetails();
        $user_id = ($request->input('id') != null ? $request->input('id') : auth()->user()->id);
        $user_detail = $user_details->where(['user_id' => $user_id])->first();
        $you = auth()->user();
        if ($user_id > 0) {
            $found = new User();
            $user = $found->find($user_id);
        } else {
            $user = $you;
        }
        $userdetails_headers = $details->userDetailsTable(null, 1);
        $userdetails_body = $details->userDetailsTable(null, 2);
        $UserProfile = new UserProfiles();
        $force = $UserProfile->where(['user_id' => $user->id])->first();
        $UserFieldSonData = new UserFieldSonData();
        $fieldson_data = $UserFieldSonData->all();
        $Userfield = new Userfield();
        $user_fields = $Userfield->all();
        $user_field_details_data = $this->user_field_details_data($user->id); //array($num_rows,$user_data);
        $page_defaults = $UserFunctions->default_userprofile_cols('default');
        $page_profile = $UserFunctions->default_userprofile_cols('profile');
        $PageData = new PageData();
        $page_data = $PageData->where('page_id', 4)->get();
        $roles = new Roles();
        $user_roles = $roles->all();

        $page_title = 'User';
        $page_title = $page_title ? $page_title : $this->page_title;

        return view('profilehub.vendor.admin.user.userShow',
        [
                'user' => $user,
                'you' => $you,
                'force' => $force,
                'user_id' => $user_id, 
                'userdetails_headers' => $userdetails_headers,
                'userdetails_body' => $userdetails_body,
                'user_detail' => $user_detail,
                'default_user_details' => $default_user_details,
                'page_perm' => $page_perm,
                'user_fields' => $user_fields,
                'son_data' => $fieldson_data,
                'detailsdata_rows' => $user_field_details_data[0],
                'userfield_details_data' => $user_field_details_data[1],
                'page_defaults' => $page_defaults,
                'page_data' => $page_data,
                'user_roles' => $user_roles,
                'page_profile' => $page_profile,
                'page_title' => $page_title,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View|Response
    {
        $UserFunctions = new UserFunctions(); 
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $user = User::find($id);
        $UserProfile = new UserProfiles();
        $force = $UserProfile->where(['user_id' => $id])->first();
        $UserFieldSonData = new UserFieldSonData();
        $son_data = $UserFieldSonData->all();
        $Userfield = new Userfield();
        $user_fields = $Userfield->all();
        $userfield_details_data = $this->user_field_details_data($user->id);
        $detailsdata_rows = $userfield_details_data[0];
        $userfield_details_data = $userfield_details_data[1];
        $Countries = new Countries();
        $countries = $Countries->all();
        $CountryStates = new CountryStates();
        $states = $CountryStates->all();
        $PageData = new PageData();
        $page_data = $PageData->where('page_id', 4)->get();
        $page_defaults = $UserFunctions->default_userprofile_cols('default');
        $page_profile = $UserFunctions->default_userprofile_cols('profile');
        $roles = new Roles();
        $user_roles = $roles->all();

        $page_title = 'Profile';
        $page_title = $page_title ? $page_title : $this->page_title;

        return view(
            'admin.user.userShow',
            [
                'user' => $user,
                'force' => $force,
                'page_perm' => $page_perm,
                'user_fields' => $user_fields,
                'son_data' => $son_data,
                'countries' => $countries,
                'states' => $states,
                'detailsdata_rows' => $detailsdata_rows,
                'userfield_details_data' => $userfield_details_data,
                'page_data' => $page_data,
                'page_defaults' => $page_defaults,
                'user_roles' => $user_roles,
                'page_profile' => $page_profile,
                'page_title' => $page_title,
            ]
        );
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request): View|Response
    {
        $Countries = new Countries();
        $UserFunctions = new UserFunctions();
        $UserDetailsController = new AdminUserDetailsController();
        $user = Auth::user();
        $user_details = new UserDetails();
        if (Session('user_role') != 'superadmin' && Session('user_role') != 'admin') {
            if ($user->id != $request->input('id')) {
                return abort(401);
            }
        }
        $user_id = ($request->input('id') != null ? $request->input('id') : auth()->user()->id);
        $all_countries = $Countries->orderBy('country_name', 'asc')->groupBy('country_code')->get();
        $Countries = new Countries();
        $countries = $Countries->all();
        $CountryStates = new CountryStates();
        $states = $CountryStates->all(); 
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $user = User::find($request->input('id'));
        $UserFieldSonData = new UserFieldSonData();
        $son_data = $UserFieldSonData->all();
        $userfield_details_data = $this->user_field_details_data($user->id);
        $detailsdata_rows = $userfield_details_data[0];
        $userfield_details_data = $userfield_details_data[1];
        $PageData = new PageData();
        $page_data = $PageData->where('page_id', 5)->get();
        $page_defaults = $UserFunctions->default_userprofile_cols('default');
        $page_profile = $UserFunctions->default_userprofile_cols('profile');
        //$page_data = $UserFunctions->page_settings(5);
        $default_user_details = $UserDetailsController->default_user_details();
        $user_detail = $user_details->where(['user_id' => $user_id])->first();
        $page_title = 'Edit Profile';
        $page_title = $page_title ? $page_title : $this->page_title;

        return view('profilehub.vendor.admin.user.userEdit', compact(
            'user_detail' ,
            'default_user_details',
            'user',
            'page_perm',
            'all_countries',
            'countries',
            'states',
            'son_data',
            'detailsdata_rows',
            'userfield_details_data',
            'page_data',
            'page_defaults',
            'page_profile',
            'page_title'
        ));
    }

    public function force(Request $request): View|Response
    {
        //dd($request);
        $Countries = new Countries();
        $UserFunctions = new UserFunctions();
        $user = Auth::user();
        $all_countries = $Countries->orderBy('country_name', 'asc')->groupBy('country_code')->get();
        $Countries = new Countries();
        $countries = $Countries->all();
        $CountryStates = new CountryStates();
        $states = $CountryStates->all(); 
        $page_perm = $this->admin->allPageRoles($this->module_slug);

        $page_perm = true;
        $user = User::find($request->input('id'));
        $UserFieldSonData = new UserFieldSonData();
        $son_data = $UserFieldSonData->all();
        $userfield_details_data = $this->user_field_details_data($user->id);
        $page_defaults = $UserFunctions->default_userprofile_cols();
        $detailsdata_rows = $userfield_details_data[0];
        $userfield_details_data = $userfield_details_data[1];
        $PageData = new PageData();
        $page_data = $PageData->where('page_id', 2)->get();

        $page_title = 'Profile';
        $page_title = $page_title ? $page_title : $this->page_title;

        return view(
            'admin.user.forceProfile',
            [
                'user' => $user,
                'page_perm' => $page_perm,
                'all_countries' => $all_countries,
                'countries' => $countries,
                'states' => $states,
                'son_data' => $son_data,
                'detailsdata_rows' => $detailsdata_rows,
                'userfield_details_data' => $userfield_details_data,
                'page_data' => $page_data,
                'all_page_data' => $page_data,
                'page_defaults' => $page_defaults,
                'page_title' => $page_title,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createrecord(Request $request)
    {

        if ($request->input('user_id') != session('user_id')) {
            $request->session()->flash('error', 'permission not granted');
            return redirect()->back();
        }
        if (($request->input('user_password') != $request->input('user_password_repeat')) && ($request->input('user_password') != '')) {
            $msg = 'your passwords do not match';
            $request->session()->flash('error', $msg);
            return redirect()->back();
        }
        $user = User::find($request->input('user_id'));
        if (($request->input('user_password') == $request->input('user_password_repeat')) && ($request->input('user_password') != '')) {
            $password = Hash::make('user_password');

            $user->forceFill([
                'password' => Hash::make($request->input('user_password'))
            ])->save();
            $user->setRememberToken(Str::random(60));
            $pass_id = 1;
            
        }
        $profile = new UsersController();
        $user_id = $request->input('user_id');
        //update additional fields
        $user = User::find($request->input('user_id'));
        $user->user_bio = addslashes($request->input('user_bio'));
        $user->save();
        $detail = new AdminUserDetailsController();

        foreach ($request->post('user_entry') as $field_id => $user_rows) {
            $detail->save_user_details($user_id, $field_id, $user_rows, json_encode($user_rows));
        }

        $detail->createrecord($request, 'bypass');
        //update the profile
        $num_filled = $this->updateProfileDetails($request->input('user_id'));
        $UserProfile = new UserProfiles();
        $profile = $UserProfile->where(['user_id' => $request->post('user_id')])->first();
        //echo $num_filled; dd($request->post());
        if ($profile) {
            $profile->num_filled = $num_filled;
            $profile->pforce = '0';
            $profile->save();
        }

        $msg = ($user_id > 0 ? 'you have successfully updated your profile' : 'error');
        $request->session()->flash('message', $msg);
        return redirect()->route('profilehub::dashboard.index');
    }
     
    function updateProfileDetails($user_id)
    {
        $query = " SELECT SUM((t.username != '') + (t.name != '') + (t.firstname != '') + (t.lastname != '') + (t.email != '')) AS num_core FROM users t WHERE t.id = '" . $user_id . "' ";
        $res1 = DB::select($query);
        $query = " SELECT SUM(user_entry != '') AS num_fields FROM user_field_details WHERE user_id = '" . $user_id . "' ";
        $res2 = DB::select($query);
        return $res1[0]->num_core + $res2[0]->num_fields;
    }
    function numberProfileFields()
    {
        $Userfield = new Userfield();
        $fields = $Userfield->all();
        return 5 + count($fields);
    }
    function user_field_details_data($user_id)
    {
        $user_field_details = new UserFieldDetailsData();
        $user_data = $user_field_details->where(['user_id' => $user_id])->get();
        $num_rows = $user_field_details->where(['user_id' => $user_id])->groupBy('sequence')->get();
        $num_rows = ($num_rows->first() ? count($num_rows) : 0);
        return array($num_rows, $user_data);
    }
}
