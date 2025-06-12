<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use BabeRuka\ProfileHub\Models\Pages;
use BabeRuka\ProfileHub\Repository\UserFunctions;
use BabeRuka\ProfileHub\Models\User;
use BabeRuka\ProfileHub\Models\Modules;
use BabeRuka\ProfileHub\Models\PageData;
use BabeRuka\ProfileHub\Models\PageWidgets;
use DB;

class PagesController extends Controller
{
    public $module_id;
    public $module_name;
    public $module_slug;
    public $page_title;
    
    public function __construct()
    {
        $this->module_id = 9;
        $this->module_name = 'Layout';
        $this->module_slug = '_LAYOUT';
        $this->page_title = $this->module_name;
    }
    public function index(){

    }

    public function publicpages()
    {
        $user = Auth::user();
        $page_title = 'Layout';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('profilehub::admin.pages.public.publicpages', [
            'user' => $user,
            'page_title' => $page_title,
        ]);
    }


    public function about()
    {
        $user = Auth::user();

        $page_title = 'Layout';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('profilehub::admin.pages.public.about', [
            'user' => $user,
            'page_title' => $page_title,
        ]);
    }

    public function contactus()
    {
        $user = Auth::user();

        $page_title = 'Layout';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('profilehub::admin.pages.public.contactus', [
            'user' => $user,
            'page_title' => $page_title,
        ]);
    }
    public function privacypolicy()
    {
        $user = Auth::user();

        $page_title = 'Layout';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('profilehub::admin.pages.public.privacypolicy', [
            'user' => $user,
            'page_title' => $page_title,
        ]);
    }
    public function terms()
    {
        $user = Auth::user();

        $page_title = 'Layout';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('profilehub::admin.pages.public.terms', [
            'user' => $user,
            'page_title' => $page_title,
        ]);
    }

}
