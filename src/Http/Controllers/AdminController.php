<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class AdminController extends Controller
{
    function __construct()
    { 
    }
    public function index(Request $request)
    {
      return view('vendor.profilehub.dashboard');
    }
    function allPageRoles(){
        $data = [
            'view' => 1, 
            'add' => 1, 
            'edit' => 1, 
            'create' => 1,
            'update' => 1,
            'delete' => 1,
            'manage' => 1
        ];

        if (!session()) {
            throw new RuntimeException('Session not available');
        }

        session()->put('page_perm', $data);

        return $data;
    }
}
