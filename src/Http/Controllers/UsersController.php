<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use BabeRuka\ProfileHub\Models\User;
use BabeRuka\ProfileHub\Models\UserDetails;
use BabeRuka\ProfileHub\Models\UserFieldDetails;
use BabeRuka\ProfileHub\Models\UserProfiles; 
use Auth;
use Session;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use BabeRuka\ProfileHub\Http\Controllers\AdminController; 

class UsersController extends Controller
{

    protected $module_id;
    protected $module;
    public $module_name;
    public $module_slug;
    public $page_title;
    public $lms_group;
    protected $admin;

    public function __construct()
    {
        $this->middleware('auth');
        $this->module_id = 1;
        $this->lms_group = 'user';
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
    public function index(): View|Response
    {
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $you = auth()->user();
        $users = User::whereNull('deleted_at')->get();
        $userdetails_headers = $this->userDetailsTable(null, 1);
        $userdetails_body = $this->userDetailsTable(null, 2);
        $page_title = $this->page_title ? $this->page_title : 'Users';
        return view('profilehub::admin.users.users', compact('users', 'you', 'userdetails_headers', 'userdetails_body','page_perm','page_title'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request): View|Response
    {
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $user = User::find($request->input('id'));
        $UserProfile = new UserProfiles();
        $force = $UserProfile->where(['user_id' => $request->input('id')])->first();
        $page_title = $this->page_title ? $this->page_title : 'User';
        return view('profilehub::admin.user.userShow',
        [
            'user' => $user,
            'force' => $force,
            'page_perm' => $page_perm,
            'page_title' => $page_title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request): View|Response
    {
        $user_id = $request->input('id');
        $user_details = new UserDetails();
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $user = User::find($user_id);
        $user_detail = $user_details->where(['user_id' => $user_id])->first();
        $page_title = $this->page_title ? $this->page_title : 'User';
        return view('profilehub::admin.users.userEditForm', compact('user','user_detail','page_title','page_perm'));
    }

    public function create(Request $request): View|Response
    {
        $page_title = $this->page_title ? $this->page_title : 'New User';
        return view('profilehub::admin.users.userCreateForm',compact('page_title'));
    }
     
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $bypass=false, $name = false)
    {
        $validatedData = $request->validate([
            'name'       => 'required|min:1|max:256',
            'email'      => 'required|email|max:256'
        ]);
        $user = User::find($id);
        $user->name       = $name ? $name : $request->input('name');
        $user->email      = $request->input('email'); 
        $user->user_bio      = addslashes($request->input('user_bio'));
        $user_id = $user->save();
        if($bypass=='bypass'){
            return $user_id;
        }
        $request->session()->flash('message', 'Successfully updated user');
        return redirect()->back(); 
    }

    /**
     * get user details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userDetailsTable($id = false, $return_type = false)
    {
        $user_details = new UserFieldDetails();
        $fields = $user_details->user_field();
        //dd($fields);
        $field_headers = array();
        $field_body = array();
        $field_arr = array();
        foreach ($fields as $fk=>$fld) {
            $detail = $user_details->one_user_field_details($fld->field_id, $id);
            //dd($detail);
            $field_headers[$id] = '<td>' . $fld->translation . '</td>';
            $translation = $this->stripAll($fld->translation);
            $field_arr[$fk][$translation] =  $detail;
            $field_body[$id] = $detail;
        }
        if ($return_type == 1) {
            return $fields;
        }else if ($return_type == 3) {
            return $field_arr;
        } else {
            return $field_body;
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->session()->put('deleted-user', '');
        $user = User::find($request->input('id'));
        $request->session()->put('deleted-user', $user);
        $username = $user->name ;  
        if ($user) {
            $user->delete();
        }
        $admin_name = Auth::user()->name;
        $user = $request->session()->get('deleted-user');
        $request->session()->flash('message',  ''.$username.' has successfully been deleted!');
        return redirect()->back();
    }
    public function logoutUser()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
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
    
}
