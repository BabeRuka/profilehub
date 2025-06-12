<?php

namespace BabeRuka\ProfileHub\Http\Controllers;
use BabeRuka\ProfileHub\Models\Users;
use BabeRuka\ProfileHub\Models\UserDetails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public $module_id;
    public $module_name;
    public $module_slug;
    public $module;
    public $page_title;
    
    public function __construct()
    {
        $this->module_id = 1;
        $this->module_name = 'Ajax Management';
        $this->module_slug = '_FILE';
        $this->module = 'file';
        $this->page_title = $this->module_name;
    }
    public function validateUserdetail(Request $request){
        $user_details = new UserDetails();
        if($request->post('username')){
            $unlenght = strlen($request->post('username'));
            if($unlenght < 8){
                echo 'invalidlenght';
                return;
            }
            if($request->post('username')==''){
                echo 'invalid';
                return;
            }
            $found_user = $user_details->where('username', $request->post('username'))->first();
            if ($found_user) {  
                echo 'username-found';
                return;
            }
            echo 'valid';
            return;
        }
        if($request->post('email')){
            $validator = Validator::make($request->all(), [
                'email'  => ['required', 'email:rfc,dns,filter', 'unique:users,email,NULL,id,deleted_at,NULL'],
            ]);
            $email = $request->post('email');
            $unlenght = strlen($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo 'invalid-email';
                return;
            }
            if($unlenght < 8){
                echo 'invalidlenght';
                return;
            }
            if($email==''){
                echo 'invalid';
                return;
            }
            $found_user = $user->where('email', $request->post('email'))->orWhere('username', $request->post('email'))->first();
            if ($found_user) {  
                echo 'email-found';
                return;
            }
            echo 'valid';
            return;
        }
    }
    public function validEmails(){
        return [
            'email'  => ['required', 'email:rfc,dns,filter', 'unique:users,email,NULL,id,deleted_at,NULL'],
        ];
    }
}
