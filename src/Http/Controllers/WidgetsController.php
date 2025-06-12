<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use BabeRuka\ProfileHub\Models\LmsCountries;
use BabeRuka\ProfileHub\Models\LmsCountryStates;

class WidgetsController extends Controller
{
    protected $module_id;
    protected $module;
    public $module_name;
    public $module_slug;
    public $page_title;
    
    public function __construct()
    {
        
        $request = new Request();
        $this->request = $request;
        $this->middleware('auth');
        
        $this->module_id = 1;
        $this->module_name = 'Widgets';
        $this->module_slug = '_WIDGETS';
        $this->module = 'widgets';
    }

    public function getFormWidget(Request $request)
    {
        $LmsCountries = new LmsCountries();
        $LmsCountryStates = new LmsCountryStates();
        $selected_option = $request->input('selected_option');
        $required_settings = 'required';
        switch ($request->input('type')) {
            case 'form':
                if ($request->input('widget') == 'country' || $request->input('widget') == 'state') {
                    $all_countries = $LmsCountries->all();
                    $dropdown_id = $request->input('id');
                    $dropdown_name = $request->input('name');
                    $returnHTML = view('profilehub::admin.widgets.forms.parts.country-list',
                        [
                            'dropdown_id' => $dropdown_id,
                            'dropdown_name' => $dropdown_name,
                            'all_countries' => $all_countries,
                            'selected_option' => $selected_option,
                            'required_settings' => $required_settings,
                        ]
                    )->render();
                    //return response()->json(array('success' => true, 'html'=>$returnHTML));
                    return $returnHTML;
                }
                if ($request->input('widget') == 'state') {
                    if($request->input('country_id')){
                        $country_id = $request->input('country_id');
                        $all_states = $LmsCountryStates->where('country_id',$country_id)->get();
                    }else{
                        $all_states = $LmsCountryStates->all();
                    }

                    $dropdown_id = $request->input('id');
                    $dropdown_name = $request->input('name');
                    $returnHTML = view('profilehub::admin.widgets.forms.parts.state-list',
                        [
                            'dropdown_id' => $dropdown_id,
                            'dropdown_name' => $dropdown_name,
                            'all_states' => $all_states,
                            'selected_option' => $selected_option,
                            'required_settings' => $required_settings,
                        ]
                    )->render();
                    return $returnHTML;
                }
                if ($request->input('widget') == 'city') {
                    # code...
                }
                break;

            default:
                # code...
                break;
        }
    }
}
