<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\AdmissionDataTable;
use App\Models\Admission;
use App\Models\User;
use App\Models\Student;
use App\Exports\AdmissionsExport;

use App\Repositories\AdmissionRepository;
use Maatwebsite\Excel\Facades\Excel;

class AdmissionController extends Controller
{
    protected $admissionRepo;
    public function __construct(AdmissionRepository $repo){
        $this->admissionRepo=$repo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index(Request $request, AdmissionDataTable $dataTable)
{
    $school_id = $request->query("school_id");
    session(["school_id" => $school_id]);

    if ($school_id) {
        $dataTable->with("school_id", $school_id);
    }

    // Vérifier si c'est une requête AJAX
    if ($request->ajax()) {
        return $dataTable->ajax();
    }

    // Sinon, afficher la vue
    return $dataTable->render('dashboard.admissions.index');
}
    public function datatables(Request $request,AdmissionDataTable $dataTable)
    {
        $school_id=$request->query("school_id");
        if($school_id)
        $dataTable->with("school_id",$school_id);
        return $dataTable->ajax();
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
        $admission = Admission::find($id);
        return view('dashboard.admissions.show', compact("admission"));
    }
    public function pay($id)
    {
        $admission = Admission::find($id);
        $payment=$admission->payment();
        $admission["payment"]=$payment;
        return view('dashboard.admissions.process', compact("admission","payment"));
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

    public function onCompletePaymentCallback(Request $request,$id)
    {
        $transaction_id=$request->query("transaction_id");
        $payment= Payment::find($id);
        if($transaction_id){
            $payment->ref=$transaction_id;
            $payment->status=1;
            $payment->save();
        }
        return redirect("/payments");

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
        $data=$request->all();
        $this->admissionRepo->update($id,$data);
        return redirect("/admissions");
    }

    public function validateAdmission(Request $request, $id)
    {

        $new_status=$request->new_status;
        $admission=Admission::find($id);
        $this->admissionRepo->update($id,["status"=>$new_status]);
        if($new_status==1){
            $this->admissionRepo->createUserAndStudent($admission);
        }
        return redirect("/admissions");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
         $this->admissionRepo->delete($id);
         $request->session()->flash('error', 'Supprimée');
         return redirect("/admissions");
    }
    public function export()
    {
        return Excel::download(new AdmissionsExport, 'admissions.xlsx');
    }

}
