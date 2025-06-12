<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Response;

class FileDownloadController extends Controller
{
    protected $module_id;
    protected $module;
    public $module_name;
    public $module_slug;
    public $page_title;
    protected $defaultProfilePhotoPath = 'profile-photos';

    public function __construct()
    {
        $this->middleware('log.requests');
        $this->module_id = 1;
        $this->module_name = 'File Downloads';
        $this->module_slug = '_USER';
        $this->module = 'user';
        $this->page_title = $this->module_name;
    }
    public function index($file)
    {
        $name = basename($file);
        return response()->download($file, $name);
    }
    public function download(Request $request)
    {
        $filename = urldecode($request->input('file')); 
        return Response::download('./'.$defaultProfilePhotoPath.'/' . $filename . '');
    }
}
