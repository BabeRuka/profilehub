<?php

namespace BabeRuka\ProfileHub\Repository;

use Request;
use BabeRuka\ProfileHub\Models\UserFieldDetails;
use BabeRuka\ProfileHub\Models\UserField;
use BabeRuka\ProfileHub\Repository\CommonFunctions;
use BabeRuka\ProfileHub\Models\Countries;
use BabeRuka\ProfileHub\Models\User;
use DB;
use URL;
use DateTime;
use Auth;
use Route;
use Illuminate\Support\Facades\Hash;
use BabeRuka\ProfileHub\Http\Controllers\AdminAjaxController;
use Illuminate\Database\Eloquent\Collection;
use BabeRuka\ProfileHub\Http\Controllers\AdminSystemController;
use BabeRuka\ProfileHub\Models\Pages;
use BabeRuka\ProfileHub\Models\PageData;
use BabeRuka\ProfileHub\Models\UserInputTypes;
use Session;
use BabeRuka\ProfileHub\Http\Controllers\FileController;

class UserFunctions
{
    protected $model;
    /**
       * Instantiate reporitory
       * 
       * @param  $model
       */
    public function __construct( )
    {
    }

    function timeAgo($ptime)
    {
        $estimate_time = time() - $ptime;
        if ($estimate_time < 1) {
            return 'less than 1 second ago';
        }
        $condition = array(
            12 * 30 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );
        foreach ($condition as $secs => $str) {
            $d = $estimate_time / $secs;
            if ($d >= 1) {
                $r = round($d);
                return ' ' . $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
            }
        }
    }
    function stripAll($strip, $prefered)
    {
        $strip = preg_replace('/[.,:?]/', '', $strip);
        $strip = str_replace("'", ' ', strtolower($strip));
        $strip = str_replace('"', ' ', $strip);
        $strip = str_replace(" ", '-', $strip);
        $strip = str_replace("-", $prefered, strtolower($strip));
        return $strip;
    }

    function stripAllDefault($strip)
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
     
    function all_additional_fields($user_id)
    {
        $UserDetails = new UserFieldDetails();
        $Userfield = new Userfield();
        $all_fields = $Userfield->all();
        $user_fields = array();
        foreach ($all_fields as $field) {
            $user_fields[strtolower($this->stripAll($field->translation, '_'))] = $UserDetails->one_user_field_details($field->field_id, $user_id);
        }
        return $user_fields;
    }
      
    function treeToList($items)
    {

        $indexedItems = array();
        foreach ($items as $item) {
            $item->subs = array();
            $indexedItems[$item->org_id] = $item;
        }
        $topLevel = array();
        if (count($indexedItems) > 0) {
            foreach ($indexedItems as $item) {
                if ($item->parent_id == 0) {
                    $topLevel[] = $item;
                } else {
                    $indexedItems[$item->parent_id]->subs[] = $item;
                }
            }
        }

        return $topLevel;
    }
      

    function checkUrlSegments($path, $segment)
    {
        $decodedPath = urldecode($path);
        if (strpos($decodedPath, $segment) !== false) {
            return true;
        }
        return false;
    }
     
    public static function urlPathToController($pretty_url)
    {
        if ($pretty_url) {
            $controller = explode('/', $pretty_url);
            if (count($controller) > 0) {
                return $controller[1];
            }
        }
        return 'home';
    }
    public static function uploadAnything($filename, $extension, $user_id, $pretty_name, $directory, $request)
    {
        $FileController = new FileController();
        $new_filename = $FileController->uploadAnything($filename, $extension, $user_id, $pretty_name, $directory);
        return $new_filename;
    }
     
    function backToUrl($varName, $varValue, $varName1, $varValue1, $varName2, $varValue2)
    {
        $referer = request()->headers->get('referer');
        $previousUrl = $referer;
        $previousUrl = $previousUrl . '&' . $varName . '=' . $varValue . '&' . $varName1 . '=' . $varValue1 . '&' . $varName2 . '=' . $varValue2 . '';
        return redirect()->to($previousUrl);
    }
    function backToAnyUrl($varName, $varValue, $varName1, $varValue1, $varName2, $varValue2, $referer = false)
    {
        $referer = ($referer ? $referer : request()->headers->get('referer'));
        $previousUrl = $referer;
        $previousUrl = $previousUrl . '&' . $varName . '=' . $varValue . '&' . $varName1 . '=' . $varValue1 . '&' . $varName2 . '=' . $varValue2 . '';
        return redirect()->to($previousUrl);
    }
     
    function initiateEmptyArray($table_name)
    {
        $results = DB::select(" SELECT GROUP_CONCAT(`COLUMN_NAME`) as collumn FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE  `TABLE_NAME`=  '" . $table_name . "' ");
        $data = array();
        foreach ($results as $res) {
            $data[] = $res->collumn;
            echo '<br />';
        }
        return $data;
    }
    function secondsToHoursMinutes($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;
        return array('hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds);
    }
    function statusColors($lang)
    {
        //'valid','not_checked','not_passed','passed','not_complete','doing','not_started','failed'
        $success = array('passed', 'complete', 'completed');
        $failed = array('not_passed', 'failed');
        if (in_array($lang, $success)) {
            return 'bg-success text-white';
        }
        if (in_array($lang, $failed)) {
            return 'bg-danger text-white';
        }
        return 'bg-warning text-white';
    }
       
    function allSettings($setting_role, $group_id, $group)
    {
        $settings = DB::table('role_settings')
            ->join('role_groups', 'role_settings.group_id', '=', 'role_groups.group_id')
            ->join('role_groups_in', 'role_settings.in_id', '=', 'role_groups_in.in_id')
            ->select('role_settings.*', 'role_groups.group')
            ->where('role_settings.setting_role', '' . $setting_role . '')
            ->where('role_settings.group_id', '' . $group_id . '')
            ->where('role_groups.group', '' . $group . '')
            ->orderBy('in_id', 'asc')
            ->get();
        return $settings;
    }
     
    function findInSetQ($role_id, $table_name, $column_name)
    {
        $results = DB::select(" SELECT * FROM " . $table_name . " WHERE find_in_set('" . $role_id . "'," . $column_name . ") <> 0 ");
        return $results;
    }
    function notInSetQ($role_id, $table_name, $column_name)
    {
        $results = DB::select(" SELECT * FROM " . $table_name . " WHERE !find_in_set('" . $role_id . "'," . $column_name . ") <> 0 ");
        return $results;
    }
      
    function MimeTypeImage($mime)
    {
        $pdf = array('pdf');
        $office = array('doc', 'dot', 'wbk', 'docx', 'docm', 'dotx', 'dotm', 'docb', 'xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw', 'ppt', 'pot', 'pps', 'pptx', 'pptm', 'potx', 'potm', 'ppam', 'ppsx', 'ppsm', 'sldx', 'sldm');
        /*
            Word document
            'doc','dot','wbk','docx','docm','dotx','dotm','docb'
        */
        $word = array('doc', 'dot', 'wbk', 'docx', 'docm', 'dotx', 'dotm', 'docb');
        /*
             Excel workbook
            'xls','xlt','xlm','xlsx','xlsm','xltx','xltm','xlsb','xla','xlam','xll','xlw'
        */
        $excel = array('xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw');

        /*
             PowerPoint
            'ppt','pot','pps','pptx','pptm','potx','potm','ppam','ppsx','ppsm','sldx','sldm'
        */
        $powerpoint = array('ppt', 'pot', 'pps', 'pptx', 'pptm', 'potx', 'potm', 'ppam', 'ppsx', 'ppsm', 'sldx', 'sldm');

        /*
             Access
            'ACCDB','ACCDE','ACCDT','ACCDR'
        */
        $access = array('ACCDB', 'ACCDE', 'ACCDT', 'ACCDR');
        if (in_array($mime, $office)) {
            if (in_array($mime, $word)) {
                return 'icons/microsoft-office/icons/PNG/256x256/Word_256x256.png';
            }
            if (in_array($mime, $excel)) {
                return 'icons/microsoft-office/icons/PNG/256x256/Excel_256x256.png';
            }
            if (in_array($mime, $powerpoint)) {
                return 'icons/microsoft-office/icons/PNG/256x256/PowerPoint_256x256.png';
            }
            if (in_array($mime, $access)) {
                return 'icons/microsoft-office/icons/PNG/256x256/Excel_256x256.png';
            }
        }
        if (in_array($mime, $pdf)) {
            return 'icons/pdfs/pdf-256x256.png';
        }
    }
    function systemSettings()
    {
        $LmsSettings = new LmsSettings();
        $all_settings = $LmsSettings->all();
        $settings = array();
        foreach ($all_settings as $key => $value) {
            $settings[$value->param_name] = $value->param_value;
        }
        return $settings;
    }

     

    public function ff1($filename, $extension, $user_id, $pretty_name, $directory = false)
    {
        $time_now = time();
        $hashed_time = Hash::make($time_now);
        $filename_new = $user_id . '_' . $time_now . '_' . $pretty_name . '.' . $extension;
        $directory = ($directory ? $directory : '/files/lms/course/');
        //echo $filename_new.'<br />';echo $directory.'<br />';
        if ($filename->isValid()) {
            $filename->move(public_path() . $directory, $filename_new);
            //$request->file('ImageUpload')->storeAs('public', $fileNameToStore);
        } else {
            echo "file is not found :- " . $filename_new . ' filename_new<br />';
            echo $filename->getClientOriginalName() . ' getClientOriginalName<br />';
            echo pathinfo($filename, PATHINFO_FILENAME) . ' PATHINFO_FILENAME<br />';
            echo $filename->getClientOriginalExtension() . ' getClientOriginalExtension<br />';
            $filename_new = "";
        }
        return $filename_new;
    }
    function allCountries()
    {
        $Countries = new Countries();
        $all_countries = $Countries->orderBy('country_name', 'asc')->groupBy('country_code')->get();
        return $all_countries;
    }
    function statusBadge($status, $lang = false)
    {
        if ($status == 0) {
            return '<span class="badge badge-danger">' . ucwords(($lang ? $lang : 'in-active')) . '</span>';
        } else if ($status == 1) {
            return '<span class="badge badge-warning">' . ucwords(($lang ? $lang : 'disabled')) . '</span>';
        } else if ($status == 2) {
            return '<span class="badge badge-success">' . ucwords(($lang ? $lang : 'active')) . '</span>';
        } else {
            return '<span class="badge badge-light">undefined</span>';
        }
    }
     
    function createBranch(&$parents, $children)
    {
        $tree = array();
        foreach ($children as $child) {
            if (isset($parents[$child['id']])) {
                $child['children'] = $this->createBranch($parents, $parents[$child['id']]);
            }
            $tree[] = $child;
        }
        return $tree;
    }
    function createTree($flat, $root = 0)
    {
        $parents = array();
        foreach ($flat as $a) {
            $parents[$a['parent_id']][] = $a;
        }
        return $this->createBranch($parents, $parents[$root]);
    }
    
     
    function arrLikeSearch($keyword, $arr)
    {
        foreach ($arr as $index => $string) {
            if (strpos($string, $keyword) !== FALSE)
                return $index;
        }
        return 0;
    }
    public static function objectToArray($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map('UserFunctions::objectToArray', $object);
    }
    function page_settings($page_id = false)
    {
        $PageData = new PageData();
        if ($page_id > 0) {
            $page_data = $PageData->where(['page_id' => $page_id])->get();
        } else {
            $page_data = $PageData->all();
        }
        return $page_data;
    }
    function default_userprofile_cols($limit = false)
    {
        if ($limit == 'default') {
            $cols = array('name', 'email');
        } else if ($limit == 'profile') {
            $cols = array('password', 'profile_pic');
        } else {
            $cols = array('name', 'email', 'password');
        }
        return (object) $cols;
    }
    function userprofile_lang($column_name)
    {
        switch ($column_name) {
            case 'user_avatar':
                return 'Avatar';
            case 'middle_name':
                return 'Middle Name'; 
            case 'profile_pic':
                return 'Profile Picture';  
            case 'user_bio':
                return 'About User'; 
            default:
                return ucwords($column_name); 
        }
    }

    function default_userdetails_cols($limit = false)
    {
        if ($limit == 'default') {
            $cols = array('username', 'firstname', 'lastname');
        } else if ($limit == 'profile') {
            $cols = array('username','firstname','lastname','middle_name','user_bio','profile_pic','user_avatar');
        } else {
            $cols = array('username','firstname','lastname','middle_name','user_bio','profile_pic','user_avatar');
        }
        return (object) $cols;
    }
    function userdetails_lang($column_name)
    {
        switch ($column_name) {
            case 'user_avatar':
                return 'Avatar';
            case 'middle_name':
                return 'Middle Name'; 
            case 'profile_pic':
                return 'Profile Picture'; 
            case 'user_bio':
                return 'About User'; 
            default:
                return ucwords($column_name); 
        }
    }
    function input_types()
    {
        $inputs = array(
            'button' => 'Button',
            'tel' => 'Cell Number',
            'checkbox' => 'checkbox',
            'color' => 'color',
            'date' => 'Date',
            'datetime-local' => 'Datetime Local',
            'dropdown' => 'Dropdown',
            'email' => 'Email',
            'file' => 'File',
            'hidden' => 'Hidden',
            'image' => 'Image',
            'month' => 'Month',
            'number' => 'Number',
            'password' => 'Password',
            'radio' => 'Radio',
            'range' => 'Range',
            'reset' => 'Reset',
            'search' => 'Search',
            'submit' => 'Submit',
            'text' => 'Text',
            'textarea' => 'Textarea',
            'time' => 'Time',
            'url' => 'URL',
            'week' => 'Week',
            'widget' => 'Widget',
        );
        return $inputs;
    }
     
    function input_type_group($input_type)
    {
        $UserInputTypes = new UserInputTypes();
        $UserInputTypes = $UserInputTypes->where('input_type', $input_type)->get();
        $input_group = array();
        foreach ($UserInputTypes as $input) {
            $input_group[] = $input->input_value;
        }
        return $input_group;
    }

    function page_data($page)
    {
        $Pages = new Pages();
        $page_settings = $Pages->where('page_settings', $page)->first();
        $PageData = new PageData();
        $page_data = $PageData->where('page_id', $page_settings->page_id)->get();
        return $page_data;
    }
    function randomAlphaNum($max_chars)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randmStr = substr(str_shuffle($permitted_chars), 0, $max_chars);
        return $randmStr;
    }
    function create_anysession($session_key, $session_value = false)
    {
        $session_value = ($session_value ? $session_value : url()->full());
        Session::put($session_key, $session_value);
    }
    function del_anysession($session_key)
    {
        unset($session_key);
    }
    function remove_inline_css($output)
    {
        return preg_replace('/(<[^>]+) style=".*?"/i', '$1', $output);
    }
    function quote_comma_separated_string($string)
    {
        // Replace all commas with escaped commas.
        $string = str_replace(",", "','", $string);

        // Add quotation marks to the beginning and end of the string.
        $string = "'$string'";

        return $string;
    }

    
}
?>