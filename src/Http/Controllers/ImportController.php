<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use BabeRuka\ProfileHub\Imports\CsvImport;
use Illuminate\Http\Request;
use BabeRuka\ProfileHub\User;
use BabeRuka\ProfileHub\LmsCsvData;
use BabeRuka\ProfileHub\UserField;
use BabeRuka\ProfileHub\UserFieldSon;
use BabeRuka\ProfileHub\UserFieldDetails;
use BabeRuka\ProfileHub\Controllers\UsersController; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Excel;

class ImportController extends Controller
{
    protected $module_id;
    protected $module;
    public $module_name;
    public $module_slug;
    public $page_title;
    
    public function __construct()
    {
        $this->middleware('log.requests');
        $this->middleware('auth');
        $this->module_name = 'Imports';
        $this->page_title = $this->module_name;
    }
    public function parseImport(Request $request)
    {
        $validatedData = $request->validate([
            'csv_file' => 'required|file'
        ]);
        $user_id = Auth::user()->id;
        $AdminCourseController = new AdminCourseController();
        $dir = '/files/admin/field/';
        $LmsCsvData = new LmsCsvData();
        $UsersController = new UsersController();
        $UserDetails = new UserFieldDetails();
        $user_headers = $UserDetails->requiredUserCollumns();
        $user_headers = (object)$user_headers;
        $aheaders = $this->userDetailsData();
        $additional_headers = (object)$aheaders;
        $filename = $AdminCourseController->fileUploadPost($request->csv_file, $request->csv_file->getClientOriginalExtension(), $user_id, $user_id, $dir);
        $path = public_path('files/admin/field/').$filename;
        $path = $request->file('csv_file')->getRealPath();
      
        if ($request->has('header')) {
            //$data = Excel::import($path, function($reader) {})->get()->toArray();
            $data = Excel::import(new CsvImport, $path); //->get()->toArray();

        } else {
            $data = array_map('str_getcsv', file($path));
        }
        
        $data = array_map('str_getcsv', file($path));
        $csv_data = array_slice($data, 0, 2);
        if (count($data) > 505) {
            return redirect()->back();
        }
        if (count($data) > 0) {
            if ($request->has('header')) {
                $csv_header_fields = [];
                foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $key;
                }
            }
            $csv_data = array_slice($data, 0, 2);

            $csv_data_file = LmsCsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_rows' => count($data),
                'csv_data' => json_encode($data, JSON_UNESCAPED_UNICODE)
            ]);
        } else {
            return redirect()->back();
        }
        $page_title = 'Imports';
        $page_title = $page_title ? $page_title : $this->page_title;
        return view('lms.admin.import.process', compact('page_title', 'csv_header_fields', 'csv_data', 'csv_data_file', 'user_headers', 'additional_headers'));
    }

    public function processImport(Request $request)
    {
        $LmsCsvData = new LmsCsvData();
        $UserDetails = new UserFieldDetails();
        $user_headers = $UserDetails->requiredUserCollumns();
        $user_headers = (object)$user_headers;
        $additional_headers = $this->userDetailsData(null, 1);
        $additional_headers = (object)$additional_headers;
        $data = $LmsCsvData->find($request->input('csv_data_file_id'));
        $contents =  $data->csv_data;
        $csv_data = json_decode($contents, true);
        $all_headers = $request->input('fields');
        $this->matchFields($request, $all_headers);
        $num = 0;
        $user_id = 0;
        $imported = 0;
        foreach ($csv_data as $row) {
            if ($data->csv_header == 1) {
                if ($num > 0) {
                    if ($row[0] != '') {
                        $user_id = $this->addRows($row);
                        $imported++;
                    }
                }
            } else {
                $user_id = $this->addRows($row);
                $imported++;
            }
            if ($user_id > 0) {
                foreach ($request->post('fields') as $field_id => $translation) {
                    if ($field_id > 5) {
                        $Userfield = new Userfield();
                        $Userfield = $Userfield->find($field_id);
                        if ($Userfield->type_field == 'dropdown') {
                            $son_id = $this->getDropDownVal($field_id, $translation);
                            $this->addUserDetails($field_id, $user_id, $son_id);
                        } else {
                            $this->addUserDetails($field_id, $user_id, $translation);
                        }
                    }
                }
            }
            $num++;
        }
        $LmsCsvData->csv_rows_imported = $imported;
        $LmsCsvData->save();
        return redirect()->route('admin.users');
    }
    function addRows($row)
    {
        $found = new User();
        $found_user = $found->where(['username' => $row[0]])->first();
        if (!$found_user) {
            $user = new User();
            //username
            $user->username = $row[0];
            //firstname
            $user->firstname = $row[1];
            //lastname
            $user->lastname = $row[2];
            //email
            $user->email = $row[3];
            //password
            $user->password = Hash::make($row[4]);
            //name
            $user->name = $row[1] . " " . $row[2];
            //role
            $user->menuroles = 'user';
            $user->user_role = 2;
            $user->user_roles = 2;
            $user->save();
            //update user_id
            $user_id = $user->id;
            $found1 = new User();
            $found_user1 = $found1->find($user_id);
            $found_user1->user_id = $user_id;
            $found_user1->save();
            //assign role
            $user->assignRole('user');
            return $user_id;
        }
    }
    function getDropDownVal($field_id, $translation)
    {
        $field = new UserFieldSon();
        $field = $field->where(['field_id' => $field_id, 'translation' => strtolower($translation)])->first();
        return $field->son_id;
    }
    function addUserDetails($field_id, $user_id, $user_entry)
    {
        $UserFieldDetails = new UserFieldDetails();
        $UserFieldDetails->user_entry = $user_entry;
        $UserFieldDetails->field_id = $field_id;
        $UserFieldDetails->user_id = $user_id;
        $UserFieldDetails->save();
    }
    function addRowsFixed($row)
    {
        $user = new User();
        //username
        $user->username = $row[0];
        //firstname
        $user->firstname = $row[1];
        //lastname
        $user->lastname = $row[2];
        //email
        $user->email = $row[3];
        //password
        $user->password = Hash::make($row[4]);
        //name
        $user->name = $row[1] . " " . $row[2];
        //role
        $user->menuroles = 'user';
        $user->user_role = 2;
        $user->user_roles = 2;
        $user->save();
        //update user_id
        $user_id = $user->id;
        $found1 = new User();
        $found_user1 = $found1->find($user_id);
        $found_user1->user_id = $user_id;
        $found_user1->save();
        //assign role
        $user->assignRole('user');
        return $user_id;
    }
    public function userDetailsData()
    {
        $UserDetails = new UserFieldDetails();
        $fields = $UserDetails->user_field();
        $field_headers = array();
        foreach ($fields as $fld) {
            $field_headers[$fld->field_id] =  $fld->translation;
        }
        return $field_headers;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new CsvImport, 'users_' . time() . '.xlsx');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import()
    {
        Excel::import(new CsvImport, request()->file('file'));

        return back();
    }
    function matchFields($request, $all_headers)
    {
        if (!in_array('username', $all_headers)) {
            $request->session()->flash('message', 'your action was not completed successfully');
            return redirect()->route('admin.users');
        }
        if (!in_array('firstname', $all_headers)) {
            $request->session()->flash('message', 'your action was not completed successfully');
            return redirect()->route('admin.users');
        }
        if (!in_array('lastname', $all_headers)) {
            $request->session()->flash('message', 'your action was not completed successfully');
            return redirect()->route('admin.users');
        }
        if (!in_array('email', $all_headers)) {
            $request->session()->flash('message', 'your action was not completed successfully');
            return redirect()->route('admin.users');
        }
        if (!in_array('password', $all_headers)) {
            $request->session()->flash('message', 'your action was not completed successfully');
            return redirect()->route('admin.users');
        }
        return true;
    }
    function jsonError($data)
    {
        var_dump($data);
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                echo ' - No errors';
                break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                echo ' - Unknown error';
                break;
        }
    }
}
