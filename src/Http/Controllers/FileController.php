<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Storage;
use Auth;
use Illuminate\Support\Facades\DB;
use BabeRuka\ProfileHub\Repository\UserFunctions;
use BabeRuka\ProfileHub\Models\UserFiles;
use Session;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str;
class FileController extends Controller
{
    protected $module_id;
    protected $module;
    public $module_name;
    public $module_slug;
    public $page_title;
    protected $defaultProfilePhotoPath = 'profile-photos';
    
    public function __construct()
    { 
        $this->module_id = 1;
        $this->module_name = 'File Management';
        $this->module_slug = '_FILE';
        $this->module = 'file';
        $this->page_title = $this->module_name;
    }
    public function uploadAnything($filename, $extension, $user_id=false, $pretty_name, $directory=false, $file_desc = false)
    {
        $time_now = time();
        $userfunctions = new UserFunctions();
        $pretty_name = $userfunctions->randomAlphaNum(15); 
        $random_str = Str::random(6).date('h-i-s');
        $new_id = $user_id . '_' . $time_now . '_' . $pretty_name . '.' . $extension;
        $filename_new = $random_str . '_' .$new_id.'_'.$time_now . '_' . $pretty_name . '.' . $extension;
        $directory = ($directory ? $directory : $defaultProfilePhotoPath);
        $response_msg = ''; 
        $request = new Request();
        if ($filename->isValid()) {
            $filename->move(public_path() . $directory, $filename_new);
        } else {
            $response_msg .= "file is not found :- " . $filename_new . ' filename_new<br />';
            $response_msg .= $filename->getClientOriginalName() . ' getClientOriginalName<br />';
            $response_msg .= pathinfo($filename, PATHINFO_FILENAME) . ' PATHINFO_FILENAME<br />';
            $response_msg .= $filename->getClientOriginalExtension() . ' getClientOriginalExtension<br />';
            $request->session()->flash('message', 'your action was not completed successfully');
            return $response_msg;
        }
        $file_type = ($user_id > 0 ? 1 : 2);
        $file_desc = ($file_desc != '' ? $file_desc : 'default');
        $this->save_file_details($filename_new, $directory, $file_type, $file_desc);
        return $filename_new;
    }

    public function uploadImage($request, $original_filename)
    {
        if ($request->hasFile($original_filename)) {
            $original_pic = $request->file($original_filename);

            $file_extension = $original_pic->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;

            # upload original image
            Storage::put(public_path(''.$defaultProfilePhotoPath.'/' . $filename, (string) file_get_contents($original_pic), 'public'));

            # croped image from request.
            $image_parts = explode(";base64,", $request->input('article_image'));
            $image_base64 = base64_decode($image_parts[1]);

            Storage::put(public_path(''.$defaultProfilePhotoPath.'/croped/' . $filename, (string) $image_base64, 'public'));

            # get image from s3 or local storage.
            $image_get = Storage::get(public_path('files/images/croped/' . $filename));

            # resize 50 by 50 1x
            $image_50_50 = Image::make($image_get)
                ->resize(340, 227)
                ->encode($file_extension, 80);

            Storage::put(public_path(''.$defaultProfilePhotoPath.'/croped/1x/' . $filename, (string) $image_50_50, 'public'));

            $file_url = Storage::url(public_path(''.$defaultProfilePhotoPath.'/croped/' . $filename));

            return response()->json(['success' => true, 'filename' => $filename, 'file_url' => $file_url], 200);
        }
    }
    function save_file_details($file_name, $file_path, $file_type, $file_desc){
        $UserFiles = new UserFiles();
        $UserFiles->file_name = $file_name;
        $UserFiles->file_path = $file_path;
        $UserFiles->file_type = $file_type;
        $UserFiles->create_date = date('Y-m-d h:m:s');
        $UserFiles->file_desc = $file_desc;
        $UserFiles->save();
    }
 
    public function deleteProfilePicture($dir,$filename)
    {
        $filePath = storage_path('app/' . $dir . $filename); 

        if (File::exists($filePath)) {
            if (File::delete($filePath)) {
                return response()->json(['message' => 'File deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Error deleting file'], 500);
            }
        } else {
            return response()->json(['error' => 'File does not exist'], 404);
        }
    }
}
