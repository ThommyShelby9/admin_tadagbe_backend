<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\StudentDataTable;
use App\Models\Student;

use App\Imports\StudentsImport;
use App\Exports\StudentsExport;

use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    //protected $studentRepo;
   // public function __construct(StudentRepository $repo){
    //    $this->studentRepo=$repo;
   // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,StudentDataTable $dataTable){
        $school_id=$request->query("school_id");
        session(["school_id"=>$school_id]);
        //dd("school_id",$school_id);
        if($school_id)
        $dataTable->with("school_id",$school_id);
      //  $dataTable= $dataTable->with("status","0");

        return $dataTable->render('dashboard.students.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student=Student::find($id);
        return view("dashboard.students.show",compact("student"));
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
    public function destroy($id)
    {
        //
    }
    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }
    public function import(Request $request)
    {
        Excel::import(new StudentsImport, request()->file('file'));

        return redirect('/')->with('success', 'All good!');
    }
}
