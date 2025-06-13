<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use BabeRuka\ProfileHub\Models\Pages;
use BabeRuka\ProfileHub\Models\PageData;
use BabeRuka\ProfileHub\Repository\UserFunctions;
use App\Models\User;
use BabeRuka\ProfileHub\Models\Users;
use BabeRuka\ProfileHub\Models\PageModules;
use BabeRuka\ProfileHub\Models\PageModuleGroups; 
use BabeRuka\ProfileHub\Models\PageWidgets;
use BabeRuka\ProfileHub\Http\Controllers\AdminController;
use Auth;

class AdminLayoutController extends Controller
{
    public $module;
    public $module_id;
    public $module_name;
    public $module_slug;
    public $page_title;
    protected $admin;
    
    public function __construct()
    { 
        $this->module = 'Layout';
        $this->module_id = 9;
        $this->module_name = 'Layout';
        $this->module_slug = '_LAYOUT';
        $this->page_title = $this->module_name;
        $this->admin = new AdminController();
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $Pages = new Pages();
        $all_pages = $Pages->all();
        $users = new User();
        $all_users = $users->all();
        
        $page_title = 'Pages';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('vendor.profilehub.admin.pages.dashboard',[
            'user' => $user,
            'all_pages' => $all_pages,
            'all_users' => $all_users,
            'page_title' => $page_title,
        ]);
    }


    public function pages()
    {
        $user = Auth::user();
        $Pages = new Pages();
        $all_pages = $Pages->all();
        $users = new User();
        $all_users = $users->all();

        $page_title = 'Pages';
        $page_title = $page_title ? $page_title : $this->page_title;
        ///vendor/profilehub/admin/pages
        return view('vendor.profilehub.admin.pages.pages', [
            'user' => $user,
            'all_pages' => $all_pages,
            'all_users' => $all_users,
            'page_title' => $page_title,
        ]);
    }

    public function widgets(Request $request)
    {
        $user = Auth::user();
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $PageModules = new PageModules();
        $all_modules = $PageModules->all();
        $PageModuleGroups = new PageModuleGroups();
        $groups = $PageModuleGroups->all();
        $PageWidgets = new PageWidgets();
        $page_widgets = $PageWidgets->where('page_key', 'page_module')->get();

        $Pages = new Pages();
        $all_pages = $Pages->all();

        $page_title = 'Widgets';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('vendor.profilehub.admin.pages.widgetList', [
            'user' => $user,
            'request' => $request,
            'all_modules' => $all_modules,
            'groups' => $groups,
            'page_perm' => $page_perm,
            'page_widgets' => $page_widgets,
            'all_pages' => $all_pages,
            'page_title' => $page_title,
        ]);
    }
    public function preview(Request $request)
    {
        $page_id = $request->input('page_id');
        $widget_type = $request->input('type') == 'public_page' ? 'public' : '';
        $PageModules = new PageModules();
        $page_settings = $PageModules->where(['page_settings' => 'public_page', 'page_id' => $page_id])->first();
        $PageWidgets = new PageWidgets();
        $pages = new AdminPagesController();
        $active_widgets = $pages->active_widgets($page_id, $widget_type);
        $all_page_widgets = $PageWidgets->where('page_id', $page_id)->get();
        $all_widgets = $PageWidgets->where(['page_id' => $page_id])->get();
        $PageData = new PageData();
        $page_data = $PageData->where('page_id', $page_id)->get();
        $page_layout = $page_data->where('page_module', 'page_layout')->first();
        $allusers = User::all();

        $page_title = 'Page Preview';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view(
            'admin.pages.preview',
            [
                'page_settings' => $page_settings,
                'active_widgets' => $active_widgets,
                'all_widgets' => $all_widgets,
                'page_data' => $page_data,
                'page_layout' => $page_layout,
                'allusers' => $allusers,
                'all_page_widgets' => $all_page_widgets,
                'page_title' => $page_title,
            ]
        );
    }
     

    
     
    public function userdashboard()
    {
        $user = Auth::user();

        $page_title = 'Layout';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('vendor.profilehub.admin.pages.public.userdashboard', [
            'user' => $user,
            'page_title' => $page_title,
        ]);
    }
    public function forceprofile()
    {
        $user = Auth::user();

        $page_title = 'Layout';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('vendor.profilehub.admin.pages.public.forceprofile', [
            'user' => $user,
            'page_title' => $page_title,
        ]);
    }
    public function registration()
    {
        $user = Auth::user();

        $page_title = 'Layout';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('vendor.profilehub.admin.pages.public.registration', [
            'user' => $user,
            'page_title' => $page_title,
        ]);
    }
    public function createrecord()
    {
        $page_perm = $this->admin->allPageRoles($this->module_slug); 
        if ($request->post('function') == 'update-widget') {
            //
            request()->validate([
                'module_id'             => 'required',
                'widget_type'         => 'required',
                'has_widget'         => 'required'
            ]);
            $PageModules = new PageModules();
            $LmsModule = $PageModules->find($request->input('module_id'));
            $widget_type =  ($LmsModule->widget_type == 'admin' ? 'admin' : $request->input('widget_type'));
            $LmsModule->widget_type = $widget_type;
            $LmsModule->has_widget = $request->input('has_widget');
            $module_id = $LmsModule->save();
            if ($module_id) {
                $request->session()->flash('message', 'Successfully saved widget settings.');
            } else {
                $request->session()->flash('message', 'Error in saving widget settings!');
            }
            return redirect()->back();
        }
        if ($request->post('function') == 'create-module-group') { 
            request()->validate([
                'group_name'             => 'required|min:3|max:64',
                'group_icon'         => 'required',
                'group_active'         => 'required'
            ]);
            $PageModuleGroups = new PageModuleGroups();
            if ($request->input('group_id') > 0) {
                $PageModuleGroups = $PageModuleGroups->find($request->input('group_id'));
            }
            $goup_slug = strtoupper($request->input('group_name'));
            $goup_slug = '_' . $goup_slug;
            $PageModuleGroups->setting_id = $request->input('setting_id');
            $PageModuleGroups->group_name = $request->input('group_name');
            $PageModuleGroups->goup_slug = $goup_slug;
            $PageModuleGroups->group_icon = $request->input('group_icon');
            $PageModuleGroups->group_desc = $request->input('group_desc');
            $PageModuleGroups->group_active = $request->input('group_active');
            $module_id = $PageModuleGroups->save();
            if ($module_id) {
                $request->session()->flash('message', 'Successfully created a new module');
            } else {
                $request->session()->flash('message', 'Error in creating a new module');
            }
            return redirect()->back();
        }
        if ($request->post('function') == 'link-menu-to-module') { 
            request()->validate([
                'group_id'             => 'required',
                'module_id'         => 'required',
                'menu_id'         => 'required'
            ]);
             
            if ($items > 0) {
                $request->session()->flash('message', 'Successfully added ' . $items . ' menu items to a module');
            } else {
                $request->session()->flash('message', 'Error in adding ' . count($request->input('menu_id')) . ' module');
            }
            return redirect()->back();
        }
    }
     
}
