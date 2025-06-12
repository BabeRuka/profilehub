<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use BabeRuka\ProfileHub\Models\Pages;
use BabeRuka\ProfileHub\Repository\UserFunctions;
use BabeRuka\ProfileHub\Models\User;
use BabeRuka\ProfileHub\Models\PageModules;
use BabeRuka\ProfileHub\Models\PageData;
use BabeRuka\ProfileHub\Models\PageWidgets;
use BabeRuka\ProfileHub\Models\UserFieldGroups;
use BabeRuka\ProfileHub\Models\UserFieldSonData;
use BabeRuka\ProfileHub\Models\UserFieldSon;
use BabeRuka\ProfileHub\Models\Countries;
use BabeRuka\ProfileHub\Models\UserInputTypes;
use BabeRuka\ProfileHub\Models\Roles;
use DB;

class AdminPagesController extends Controller
{

    protected $module_id;
    protected $module;
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
    public function index(Request $request)
    { 
        $user = Auth::user(); 
        return view('profilehub::admin.pages.dashboard',[
            'module_id' => $this->module_id,
            'module_name' => $this->module_name,
            'module_slug' => $this->module_slug,
            'page_title' => $this->page_title,
            'user' => $user
        ]);
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $Pages = new Pages();
        $page = $Pages->find($request->input('page'));
        $users = new User();
        $admin = $users->find($page->page_admin);
        $PageModules = new PageModules();
        $page_modules = $PageModules->where('has_widget', '2')->groupBy('module_name')->orderBy('widget_order', 'asc')->get();
        $PageData = new PageData();
        $all_page_data = $PageData->where('page_id', $request->input('page'))->get();
        $PageWidgets = new PageWidgets();
        $all_widgets = $PageWidgets->where('page_id', $request->input('page'))->get();
        $page_module = $PageWidgets->where(['page_id' => $request->input('page'), 'page_key' => 'page_module'])->get();
        $page_col = $PageWidgets->where(['page_id' => $request->input('page'), 'page_key' => 'page_col'])->get();
        $page_row = $PageWidgets->where(['page_id' => $request->input('page'), 'page_key' => 'page_row'])->get();
        $UserFieldGroups = new UserFieldGroups();
        $page_groups = $UserFieldGroups->all();
        $UserFieldSonData = new UserFieldSonData();
        $son_data = $UserFieldSonData->all();
        $UserFieldSon = new UserFieldSon();
        $field_sons = $UserFieldSon->all();
        $Countries = new Countries();
        $countries = $Countries->all();
        $UserInputTypes = new UserInputTypes();
        $user_inputs = $UserInputTypes->all();
        $Roles = new Roles();
        $all_roles = $Roles->all();
        //$page_input_settings;
        $page_title = 'Pages';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('profilehub::admin.pages.edit', [
            'user' => $user,
            'page' => $page,
            'admin' => $admin,
            'page_modules' => $page_modules,
            'all_page_data' => $all_page_data,
            'all_widgets' => $all_widgets,
            'all_page_module' => $page_module,
            'all_page_col' => $page_col,
            'all_page_row' => $page_row,
            'page_groups' => $page_groups,
            'son_data' => $son_data,
            'countries' => $countries,
            'all_field_sons' => $field_sons,
            'user_inputs' => $user_inputs,
            'page_title' => $page_title,
            'all_roles' => $all_roles,
        ]);
    }

    public function createrecord(Request $request)
    {
        $msg = 'Error!';
        $UserFunctions = new UserFunctions();
        $user = Auth::user();
        //echo '<pre>'; print_r($_FILES);echo '</pre>'; $this->image_store($request); dd($request->post());
        if ($request->post('function') != '') {
            if ($request->post('function') == 'add-page') {
                $this->image_store($request);
                $this->page_details_init($request);
                $Pages = new Pages();
                $Pages->page_name = $request->post('page_name');
                $Pages->page_type = $request->post('page_type');
                $Pages->page_settings = $request->post('page_settings');
                $Pages->page_slug = $UserFunctions->stripAll($request->post('page_name'), '-');
                $Pages->page_admin = $user->id;
                $page_id = $Pages->save();
                if ($page_id) {
                    $msg = 'Success: new page added';
                }
            } else if ($request->post('function') == 'edit-page') {
                $Pages = new Pages();
                $Pages = $Pages->find($request->post('page_id'));
                $Pages->page_name = $request->post('page_name');
                $Pages->page_slug = $UserFunctions->stripAll($request->post('page_name'), '-');
                $Pages->page_type = $request->post('page_type');
                $Pages->page_settings = $request->post('page_settings');
                $Pages->page_desc = $request->post('page_desc');
                $Pages->page_content = $request->post('page_content');
                $Pages->page_admin = $user->id;
                $Pages->save();
                $this->image_store($request);
                $this->page_details_init($request);
                $msg = 'Success: ' . $request->post('page_name') . ' successfully edited!';
            }
            if ($request->post('sortable')) {
                $start = 1;
                foreach ($request->post('sortable') as $mudule_key => $module) {
                    $PageModules = new PageModules();
                    $has_module = $PageModules->where('mudule_slug', $module)->get();
                    $has_module[0]->widget_order = $start;
                    $has_module[0]->save();
                    $PageWidgets = new PageWidgets();
                    $has_widget = $PageWidgets->where('widget_key', $module)->get();
                    $has_widget[0]->widget_order = $start;
                    $has_widget[0]->save();

                    $start++;
                }
            }
        }
        $request->session()->flash('message', $msg);
        return redirect()->back();
    }
    function image_store($request)
    {
        if ($request->file('banner_image')) {
            $banner_dir = '/files/pages/banners/';
            $FileController = new FileController();
            $banner_image = ($request->hasFile('banner_image') ? $FileController->uploadAnything($request->banner_image, $request->banner_image->getClientOriginalExtension(), $request->post('user_id'), 'banner_image', $banner_dir) : '');
            if ($banner_image) {
                $this->add_page_data($request->post('page_id'), 'page_image', 'banner_image', $banner_image, false, false);
            }
        }
    }
    function page_details_init($request)
    {
        if ($request->post('group_enabled')) {
            $this->control_group_settings($request, $request->post('page_id'), 'group_enabled');
        }
        if ($request->post('group_layout')) {
            $this->control_group_settings($request, $request->post('page_id'), 'group_layout');
        }
        if ($request->post('group_input')) {
            $this->control_group_settings($request, $request->post('page_id'), 'group_input');
        }
        //dd($request->post());
        $widget_type = ($request->post('widget_type') ? $request->post('widget_type') : 'all');
        if ($request->post('page_module')) {
            $this->control_widgets($request, $request->post('page_id'), 'page_module', $widget_type);
        }
        if ($request->post('page_col')) {
            $this->control_widgets($request, $request->post('page_id'), 'page_col', $widget_type);
        }
        if ($request->post('page_row')) {
            $this->control_widgets($request, $request->post('page_id'), 'page_row', $widget_type);
        }
        if ($request->post('page_data')) {
            $this->control_page_data($request, $request->post('page_id'), 'page_data');
        }
        if ($request->post('page_input')) {
            $this->control_page_input($request, $request->post('page_id'), 'page_input');
        }
        if ($request->post('page_input_settings')) {
            $this->control_page_input_settings($request, $request->post('page_id'), 'page_input_settings');
        }
        if ($request->post('page_input_required')) {
            $this->control_page_input_required($request, $request->post('page_id'), 'page_input_required');
        }
        if ($request->post('son_input_settings')) {
            $this->control_son_input_settings($request, $request->post('page_id'), 'son_input_settings');
        }
        //control_group_settings
    }
    function control_group_settings($request, $page_id, $page_key)
    {
        foreach ($request->post($page_key) as $page_module => $p_data) {
            $PageData = new PageData();
            $page_data = $PageData->where(['page_id' => $page_id, 'page_key' => $page_key, 'page_module' => $page_module])->get();

            if ($page_data->first()) {
                $page_data = $page_data->first();
                $data_id = $page_data->data_id;
            } else {
                $data_id = 0;
            }
            $this->add_page_data($page_id, $page_key, $page_module, $p_data, $data_id);
        }
    }
    function control_page_data($request, $page_id, $page_key)
    {
        foreach ($request->post('page_data') as $page_module => $p_data) {
            $PageData = new PageData();
            $page_data = $PageData->where(['page_id' => $page_id, 'page_key' => $page_key, 'page_module' => $page_module])->get();
            if ($page_data->first()) {
                $page_data = $page_data->first();
                $data_id = $page_data->data_id;
            } else {
                $data_id = 0;
            }
            $this->add_page_data($page_id, $page_key, $page_module, $p_data, $data_id);
        }
    }

    function control_page_input($request, $page_id, $page_key)
    {
        $key_id = 0;
        foreach ($request->post('page_input') as $page_module => $p_data) {
            $PageData = new PageData();
            $page_input = $PageData->where(['page_id' => $page_id, 'page_key' => $page_key, 'page_module' => $page_module])->get();
            if ($page_input->first()) {
                $page_data = $page_input->first();
                $data_id = $page_data->data_id;
            } else {
                $data_id = 0;
            }
            $page_sequence = 0;
            if ($request->post('page_input_sequence') && count($request->post('page_input_sequence')) <= $page_module) {
                if(is_int($page_module)){
                    $page_sequence = $request->post('page_input_sequence')[$page_module];
                }
            }  
            $this->add_page_data($page_id, $page_key, $page_module, $p_data, $data_id, $page_sequence);
            $key_id++;
        }
    }

    function control_page_input_required($request, $page_id, $page_key)
    {
        foreach ($request->post('page_input_required') as $page_module => $p_data) {
            $PageData = new PageData();
            $page_input = $PageData->where(['page_id' => $page_id, 'page_key' => $page_key, 'page_module' => $page_module])->get();
            if ($page_input->first()) {
                $page_data = $page_input->first();
                $data_id = $page_data->data_id;
            } else {
                $data_id = 0;
            }
            $this->add_page_data($page_id, $page_key, $page_module, $p_data, $data_id);
        }
    }

    function page_input_sequence($page_module, $page_id, $page_key, $p_data)
    {

        $PageData = new PageData();
        $page_input = $PageData->where(['page_id' => $page_id, 'page_key' => $page_key, 'page_module' => $page_module])->get();
        if ($page_input->first()) {
            $page_data = $page_input->first();
            $data_id = $page_data->data_id;
        } else {
            $data_id = 0;
        }
        $this->add_page_data($page_id, $page_key, $page_module, $p_data, $data_id);
    }

    function control_page_input_settings($request, $page_id, $page_key)
    {
        foreach ($request->post('page_input_settings') as $page_module => $p_data) {
            if (is_array($p_data)) {
                foreach ($p_data as $pdata_key => $pdata_value) {
                    $p_data = json_encode(array($pdata_key => $pdata_value));
                    $PageData = new PageData();
                    $page_input = $PageData->where(['page_id' => $page_id, 'page_key' => $page_key, 'page_module' => $page_module])->get();
                    if ($page_input->first()) {
                        $page_data = $page_input->first();
                        $data_id = $page_data->data_id;
                    } else {
                        $data_id = 0;
                    }
                }

                $this->add_page_data($page_id, $page_key, $page_module, $p_data, $data_id);
            } else {
                $PageData = new PageData();
                $page_input = $PageData->where(['page_id' => $page_id, 'page_key' => $page_key, 'page_module' => $page_module])->get();
                if ($page_input->first()) {
                    $page_data = $page_input->first();
                    $data_id = $page_data->data_id;
                } else {
                    $data_id = 0;
                }
                $this->add_page_data($page_id, $page_key, $page_module, $p_data, $data_id);
            }
        }
    }

    function control_son_input_settings($request, $page_id, $page_key)
    {
        $UserFunctions = new UserFunctions();
        foreach ($request->post('son_input_settings') as $son_id => $settings) {
            $key_id = 0;
            $page_data_arr = array();
            foreach ($settings as $key => $value) {
                $PageData = new PageData();
                $page_input = $PageData->where(['page_id' => $page_id, 'page_key' => $page_key, 'page_module' => $son_id])->get();
                if ($page_input->first()) {
                    $page_data = $page_input->first();
                    $data_id = $page_data->data_id;
                } else {
                    $data_id = 0;
                }
                $cleaned_key = $UserFunctions->stripAll($key, '_');
                //echo $cleaned_key.'cleaned_key <br />';
                $page_data_arr[] = array($cleaned_key => $value);
            }
            $this->add_page_data($page_id, $page_key, $son_id, json_encode($page_data_arr), $data_id);
            $key_id++;
        }
    }

    function control_widgets($request, $page_id, $page_key, $widget_type = false)
    {
        $PageModules = new PageModules();
        if ($widget_type == 'public') {
            $_PageModules = $PageModules->where(['has_widget' => '2', 'widget_type' => $widget_type])->get();
        } else {
            $_PageModules = $PageModules->where('has_widget', '2')->get();
        }
        if ($request->post($page_key)['_DEFAULT'] == '_DEFAULT') {
            $widget_id = 0;
            $PageWidgets = new PageWidgets();
            //page_module
            $default_widget = $PageWidgets->where(['page_id' => $page_id, 'page_key' => 'page_module', 'widget_key' => '_DEFAULT'])->get();
            if ($default_widget->first()) {
                $widget_id = $default_widget[0]->widget_id;
            }
            $this->add_widget($page_id, 'page_module', '_DEFAULT', 2, $widget_id);
            //page_col
            $default_widget = $PageWidgets->where(['page_id' => $page_id, 'page_key' => 'page_col', 'widget_key' => '_DEFAULT'])->get();
            if ($default_widget->first()) {
                $widget_id = $default_widget[0]->widget_id;
            }
            $widget_value = $request->post('page_col')['_DEFAULT'];
            $this->add_widget($page_id, 'page_col', '_DEFAULT', $widget_value, $widget_id);
            //page_row
            $default_widget = $PageWidgets->where(['page_id' => $page_id, 'page_key' => 'page_row', 'widget_key' => '_DEFAULT'])->get();
            if ($default_widget->first()) {
                $widget_id = $default_widget[0]->widget_id;
            }
            $widget_value = $request->post('page_row')['_DEFAULT'];
            $this->add_widget($page_id, 'page_row', '_DEFAULT', $widget_value, $widget_id);
        }
        $num_widgets = 0;
        foreach ($_PageModules as $module) {
            $PageWidgets = new PageWidgets();
            $page_widget = $PageWidgets->where(['page_id' => $page_id, 'page_key' => $page_key, 'widget_key' => $module->mudule_slug])->get();
            $widget_value = $request->post($page_key)[$module->mudule_slug];
            $widget_value = ($widget_value != $module->mudule_slug ? $widget_value : ($widget_value == $module->mudule_slug ? 2 : 1));
            if ($page_widget->first()) {
                $page_widget = $page_widget->first();
                $widget_key = $module->mudule_slug;
                $widget_id = $page_widget->widget_id;
            } else {
                $widget_key = $module->mudule_slug;
                $widget_id = 0;
            }
            $this->add_widget($page_id, $page_key, $widget_key, $widget_value, $widget_id);
            $num_widgets++;
        }
    }
    function add_widget($page_id, $page_key, $widget_key, $widget_value, $widget_id = false)
    {
        if ($widget_id > 0) {
            $page_widget = new PageWidgets();
            $page_widget = $page_widget->find($widget_id);
        } else {
            $page_widget = new PageWidgets();
        }
        if ($widget_key == '_DEFAULT') {
            echo $widget_id . ' widget_id';
            echo '<br />';
        }
        $page_widget->page_id = $page_id;
        $page_widget->page_key = $page_key;
        $page_widget->widget_key = $widget_key;
        $page_widget->widget_value = $widget_value;
        $page_widget->save();
    }
    function add_page_data($page_id, $page_key, $page_module, $p_data, $data_id = false, $page_sequence = false)
    {
        if ($data_id > 0) {
            $PageData = new PageData();
            $page_data = $PageData->find($data_id);
        } else {
            $page_data = new PageData();
        }
        $page_data->page_id = $page_id;
        $page_data->page_key = $page_key;
        $page_data->page_module = $page_module;
        $page_data->page_data = $p_data;
        $page_data->page_sequence = ($page_sequence ? $page_sequence : 0);
        $page_data->save();
    }
    function active_widgets($page_id, $widget_type = false)
    {
        $wtype_query = ($widget_type ? " AND w1.widget_key IN (SELECT mudule_slug FROM `page_modules` WHERE widget_type = '" . $widget_type . "') " : '');
        $query = " SELECT SUBSTR(w1.widget_key,2) AS page_module,
        (SELECT w2.widget_value FROM page_widgets AS w2 WHERE w2.widget_key = w1.widget_key AND w2.page_key = 'page_col'  AND w2.widget_value !=''  LIMIT 1) AS page_col,
        (SELECT w2.widget_value FROM page_widgets AS w2 WHERE w2.widget_key = w1.widget_key AND w2.page_key = 'page_row'  AND w2.widget_value !=''  LIMIT 1) AS page_row,
        (SELECT lm.module_name FROM `page_modules` AS lm WHERE lm.mudule_slug = w1.widget_key LIMIT 1) AS module_name,
        (SELECT lm.module_icon FROM `page_modules` AS lm WHERE lm.mudule_slug = w1.widget_key LIMIT 1) AS module_icon,
        (SELECT lm.module_desc FROM `page_modules` AS lm WHERE lm.mudule_slug = w1.widget_key LIMIT 1) AS module_desc
        FROM `page_widgets` AS w1
        WHERE w1.page_id = '" . $page_id . "' " . $wtype_query . " AND w1.widget_key IN ( SELECT DISTINCT(w3.widget_key) FROM `page_widgets` AS w3 WHERE w3.widget_value = 2 )
        AND w1.widget_value = 2 ORDER BY w1.widget_order";
        $all_results = DB::select(DB::raw($query));
        return $all_results;
    }
}
