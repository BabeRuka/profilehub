<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use BabeRuka\ProfileHub\Models\Countries;
use BabeRuka\ProfileHub\Models\CountryStates;
use BabeRuka\ProfileHub\Models\CountryDialingCodes;
use BabeRuka\ProfileHub\Models\CountryCodes;

class AdminCountriesController extends Controller
{

    public function index(Request $request){
        $countries = new Countries();
        $all_countries = $countries->orderBy('country_name', 'asc')->groupBy('country_code')->get();
        //dd($request);
        return view ('admin.countries.countryList', compact('all_countries'));
    }

    public function country(Request $request){
        return view ('admin.country.dashboard');
    }
    public function countryData(Request $request){
        $countries = new Countries();
        $all_countries = $countries->orderBy('country_name', 'asc')->groupBy('country_code')->get();
        return datatables()->of($all_countries)->toJson();
    }
    public function createrecord(Request $request){
        if($request->isMethod('post')){
            if($request->post('function')){
                $message = 'your action was not completed successfully';
                $request->session()->flash('message', $message);
                if($request->post('function') == 'add-country'){
                    $Countries = new Countries();
                    $Countries->country_code = $request->post('country_code');
                    $Countries->country_name = $request->post('country_name');
                    $Countries->country_status = $request->post('country_status');
                    $Countries->save();
                    $country_id = $Countries->country_id;
                    if($country_id > 0){
                        $message = 'The country ['.$request->post('country_name').'] was saved successfully';
                        $request->session()->flash('message', $message);
                    } 
                }else if($request->post('function') == 'edit-country'){
                    $Countries = Countries::find($request->post('country_id'));
                    $Countries->country_code = $request->post('country_code');
                    $Countries->country_name = $request->post('country_name');
                    $Countries->country_status = $request->post('country_status');
                    $Countries->save();
                    $country_id = $Countries->country_id;
                    if($country_id > 0){
                        $message = 'The country ['.$request->post('country_name').'] was updated successfully';
                        $request->session()->flash('message', $message);
                    } 
                }
                return redirect()->route('profilehub::admin.countries');
            }
        }
    }
    public function update(Request $request){
        $Countries = new Countries();
        $country = $Countries->find($request->post('country_id'));
        $country->country_code = $request->post('country_code');
        $country->country_name = $request->post('country_name');
        $country->country_status = $request->post('country_status');
        $country->save();
        $country_id = $country->country_id;
        return $country_id;
    }

    public function delete(Request $request){
        $Countries = new Countries();
        $country = $Countries->find($request->post('country_id'));
        $country->delete();
    }
}
