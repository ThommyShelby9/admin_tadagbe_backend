<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admission;

class DashboardController extends Controller
{
    const ROLE_TECH="tech";
    const ROLE_ADMIN="admin";
    const ROLE_COMPTABLE="comptable";
    const ROLE_CAISSE="caissier";
    const ROLE_SECRETAIRE="secretaire";
    const ROLE_AGENT="agent";
    const ROLE_GUEST="guest";
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
    if(!$user)
    return redirect(route("login"));
    $roles=$user->roles->pluck("name")->toArray();
    //dd($roles);
    $role="user";
    if(in_array(DashboardController::ROLE_TECH,$roles)){
        $role=DashboardController::ROLE_TECH;
    }
    if(in_array(DashboardController::ROLE_ADMIN,$roles)){
        $role=DashboardController::ROLE_ADMIN;
    }else if(in_array(DashboardController::ROLE_COMPTABLE,$roles)){
        $role=DashboardController::ROLE_COMPTABLE;
    }else if(in_array(DashboardController::ROLE_CAISSE,$roles)){
        $role=DashboardController::ROLE_CAISSE;
    }else if(in_array(DashboardController::ROLE_SECRETAIRE,$roles)){
        $role=DashboardController::ROLE_SECRETAIRE;
    }else if(in_array(DashboardController::ROLE_AGENT,$roles)){
        $role=DashboardController::ROLE_AGENT;
    }else{
        $role=DashboardController::ROLE_GUEST;
    }
    $validatedAdmissions=Admission::where("status",3)->count();
    $pendingAdmissions=Admission::where("status",0)->count();
    $totalsAdmissions=Admission::all()->count();
    $rejectedAdmissions=Admission::where("status",2)->count();
    $admissions=Admission::limit(5)->latest()->get();
   // dd($admisssions);

    return view('dashboard.homepage', 
    compact("validatedAdmissions",
    "pendingAdmissions",
    "totalsAdmissions",
    "rejectedAdmissions",
    "admissions"));
    }
}
