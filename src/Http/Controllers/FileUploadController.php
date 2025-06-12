<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FileUploadController extends Controller
{
    protected $module_id;
    protected $module;
    public $module_name;
    public $module_slug;
    public $page_title;
    protected $defaultProfilePhotoPath = 'profile-photos';
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('log.requests');
        $this->module_id = 1;
        $this->module_name = 'File Management';
        $this->module_slug = '_USER';
        $this->module = 'user';
        $this->page_title = $this->module_name;
    }
    public function fileUploadPost(Request $request)
    { 
        $request->validate([
            'file' => 'required|mimes:pdf,xlx,csv|max:2048',
        ]);
        $time_now = time();
        $hashed_time = Hash::make($time_now);
        $fileName = $time_now . '_' . $hashed_time . '.' . $request->file->extension();

        $request->file->move(public_path(''.$defaultProfilePhotoPath.''), $fileName);
        return $fileName;
    }

    public function fileImageStore(Request $request)
    {
        if ($request->hasFile('original_pic')) {
            $original_pic = $request->file('original_pic');

            $file_extension = $original_pic->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;

            # upload original image
            Storage::put($defaultProfilePhotoPath.'/' . $filename, (string) file_get_contents($original_pic), 'public');

            # croped image from request.
            $image_parts = explode(";base64,", $request->input('article_image'));
            $image_base64 = base64_decode($image_parts[1]);

            Storage::put($defaultProfilePhotoPath.'/croped/' . $filename, (string) $image_base64, 'public');

            # get image from s3 or local storage.
            $image_get = Storage::get($defaultProfilePhotoPath.'/croped/' . $filename);

            # resize 50 by 50 1x
            $image_50_50 = Image::make($image_get)
                ->resize(340, 227)
                ->encode($file_extension, 80);

            Storage::put($defaultProfilePhotoPath.'/croped//1x/' . $filename, (string) $image_50_50, 'public');

            $file_url = Storage::url($defaultProfilePhotoPath.'/croped/' . $filename);

            return response()->json(['success' => true, 'filename' => $filename, 'file_url' => $file_url], 200);
        }
    }
     
}
