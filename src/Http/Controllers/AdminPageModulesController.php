<?php

namespace BabeRuka\ProfileHub\Http\Controllers;
use Illuminate\Http\Request; 
use BabeRuka\ProfileHub\Models\PageModules;
use BabeRuka\ProfileHub\Models\PageModuleGroups;    
use BabeRuka\ProfileHub\Models\PageWidgets;
use BabeRuka\ProfileHub\Repository\UserFunctions; 
use Session;
use BabeRuka\ProfileHub\Http\Controllers\AdminController; 

class AdminPageModulesController extends Controller
{

    public $module;
    public $module_id;
    public $module_name;
    public $module_slug;
    public $page_title;
    protected $admin;

    public function __construct()
    {
       
        $this->module_name = 'Settings';
        $this->module_slug = '_SETTINGS';
        $this->module = 'settings';
        $this->page_title = $this->module_name;
        $this->admin = new AdminController();
    }
    public function index(Request $request)
    {
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $PageModules = new PageModules();
        $PageModuleGroups = new PageModuleGroups();
 
        if ($request->input('group_id') > 0) {
            $modules = $PageModules->where(['group_id' => $request->input('group_id')])->get();
            $groups = $PageModuleGroups->find($request->input('group_id'));
        } else {
            $modules = $PageModules->all();
            $groups = $PageModuleGroups->all();
        }
        $page_title = 'Modules';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('profilehub::admin.modules.moduleList')->with(compact(['page_title', 'groups', 'modules', 'page_perm', 'request']));
    }
    //groups
    public function groups(Request $request)
    {
        $page_perm = $this->admin->allPageRoles($this->module_slug);
        $PageModules = new PageModules();
        $modules = $PageModules->all();
        $PageModuleGroups = new PageModuleGroups();
        $groups = $PageModuleGroups->all();
        $page_title = 'Groups';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('profilehub::admin.modules.moduleGroupList')->with(compact(['page_title', 'groups', 'modules', 'page_perm']));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'module_name'             => 'required|min:1|max:64',
            'module_icon'         => 'required'
        ]);
        $user = auth()->user();
        $UserFunctions = new UserFunctions();
        $module_name = $UserFunctions->stripAll($request->input('module_name'), '_');
        $mudule_slug = strtoupper($module_name);
        $mudule_slug = '_' . $mudule_slug;
        $PageModules = new PageModules();
        $PageModules->group_id = $request->input('group_id');
        $PageModules->setting_id = $request->input('setting_id');
        $PageModules->module_name = $request->input('module_name');
        $PageModules->mudule_slug = $mudule_slug;
        $PageModules->module_icon = $request->input('module_icon');
        $PageModules->module_desc = $request->input('module_desc');
        $PageModules->module_active = $request->input('module_active');
        $module_id = $PageModules->save();
        if ($module_id) {
            $request->session()->flash('message', 'Successfully created a new module');
        } else {
            $request->session()->flash('message', 'Error in creating a new module');
        }
        return redirect()->back();
    }
    public function update(Request $request)
    {
        request()->validate([
            'module_name'             => 'required|min:3|max:64',
            'module_icon'         => 'required',
            'module_active'         => 'required'
        ]);
        $PageModules = new PageModules();
        $PageModules = $PageModules->find($request->input('module_id'));
        if (!$PageModules->module_id) {
            $request->session()->flash('error', "your action was not successfully completed.");
            return redirect()->back();
        }
        $UserFunctions = new UserFunctions();
        $module_name = $UserFunctions->stripAll($request->input('module_name'), '_');
        $mudule_slug = strtoupper($module_name);
        $mudule_slug = '_' . $mudule_slug;
        $PageModules->setting_id = $request->input('setting_id');
        $PageModules->module_name = $request->input('module_name');
        $PageModules->mudule_slug = $mudule_slug;
        $PageModules->module_icon = $request->input('module_icon');
        $PageModules->module_desc = $request->input('module_desc');
        $PageModules->module_active = $request->input('module_active');
        $module_id = $PageModules->save();
        if ($module_id) {
            $request->session()->flash('message', 'Successfully created a new module');
        } else {
            $request->session()->flash('message', 'Error in creating a new module');
        }
        return redirect()->back();
    }

    public function createrecord()
    {
        $page_perm = $this->admin->allPageRoles($this->module_slug); 
        if ($request->post('function') == 'update-widget') { 
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
