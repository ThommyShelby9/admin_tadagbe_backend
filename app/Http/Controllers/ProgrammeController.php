<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ProgrammeDataTable;
use App\Models\Programme;
use App\Repositories\ProgrammeRepository;
class ProgrammeController extends Controller
{
    protected $ProgrammeRepo;
    public function __construct(ProgrammeRepository $repo){
        $this->ProgrammeRepo=$repo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,ProgrammeDataTable $dataTable){

        $school_id=$request->query("school_id");
        session(["school_id"=>$school_id]);
        return $dataTable->render('dashboard.programmes.index');
    }
    public function datatables(ProgrammeDataTable $dataTable)
    {

        return $dataTable->ajax();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $school_id=$request->query("school_id");
        session(["school_id"=>$school_id]);
                return view('dashboard.programmes.create',compact("school_id"));
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
            'date'             => 'required',
            'courses'           => 'required',
        ]);
        $user = auth()->user();
        $data=$request->all();
        $Programme = new Programme($data);
        $Programme->save();
        if(isset($data["isAjax"])){
            return json_encode(["status"=>"success"]);
        }
        $request->session()->flash('message', 'Succès');
        return redirect()->route('programmes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $this->ProgrammeRepo->delete($id);
        $request->session()->flash('error', 'Supprimé');
        return redirect("/programmes");
    }
}
