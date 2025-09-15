<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\PaymentDataTable;
use App\Models\Payment;
use App\Repositories\PaymentRepository;

class PaymentController extends Controller
{
    protected $paymentRepo;
    public function __construct(PaymentRepository $repo){
        $this->paymentRepo=$repo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,PaymentDataTable $dataTable){
        $school_id=$request->query("school_id");
        session(["school_id"=>$school_id]);
        //dd("school_id",$school_id);
        if($school_id)
        $dataTable->with("school_id",$school_id);
        return $dataTable->render('dashboard.payments.index');
    }
    public function datatables(PaymentDataTable $dataTable)
    {
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
        $payment = Payment::find($id);
        return view('dashboard.payments.show', compact("payment"));
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
         $this->paymentRepo->delete($id);
         $request->session()->flash('error', 'Supprimée');
         return redirect("/payments");
    }
}
