<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
      return view('profilehub::admin.index');
    }
    function allPageRoles(){
      return [
        'view' => 1, 
        'add' => 1, 
        'edit' => 1, 
        'delete' => 1,
        'manage' => 1
      ];
    }
}
