<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\DataTables\UsersDataTable;
use App\Services\RolesService;
use Illuminate\Support\Facades\Hash;
class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexo()
    {
        $you = auth()->user();
        $users = User::all();
        return view('dashboard.admin.usersList', compact('users', 'you'));
    }
    public function index(UsersDataTable $dataTable){
        
        return $dataTable->render('dashboard.admin.usersList');
    }
    public function datatables(UserDataTable $dataTable)
    {
        return $dataTable->ajax();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('dashboard.admin.userShow', compact( 'user' ));
    }
 /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles   =RolesService::get();
        return view('dashboard.admin.userCreateForm', compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name'             => 'required',
            'email'           => 'required',
            'password'         => 'required',
        ]);
        $user = new User();
        $user->name     = $request->input('name');
        $user->email   = $request->input('email');
        $user->phone = $request->input('phone');
        if($request->input('first_name'))
        $user->first_name = $request->input('first_name');
        if($request->input('last_name'))
        $user->last_name = $request->input('last_name');
        $user->password = Hash::make($request->input('password'));
        if($request->input('menuroles'))
        $user->menuroles=implode(",",$request->input('menuroles'));
        $user->email_verified_at=date();
        $user->save();
        $request->session()->flash('message', 'Succcès');
        return redirect()->route('users.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles= RolesService::get();
        $user = User::find($id);
        return view('dashboard.admin.userEditForm', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'       => 'required|min:1|max:256',
            'email'      => 'required|email|max:256'
        ]);
        $user = User::find($id);
        $user->name       = $request->input('name');
        $user->email      = $request->input('email');
        if($request->input('password'))
        $user->password = Hash::make($request->input('password'));
        if($request->input('menuroles'))
        $user->menuroles=implode(",",$request->input('menuroles'));
        //dd($request->input('menuroles'));
        $user->save();
        $request->session()->flash('message', 'Succès');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
        }
        return redirect()->route('users.index');
    }
}
