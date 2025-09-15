<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\Setting;

class SettingsController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $templates = EmailTemplate::all();        
        return view('dashboard.settings.index',compact("templates"));
    }
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $setting=Setting::where("code",$request->code)->first();
        if($setting){
            $setting->update(["value"=>$request->value]);
        }else{
            Setting::create($request->all());
        }
        $request->session()->flash('message', 'Effectué');
        return redirect('/settings', );
    }

    public function getSettingByCode($code){
        $setting=Setting::where("code",$code)->first();
        //dd($setting);

        return response()->json($setting);
    }
}
