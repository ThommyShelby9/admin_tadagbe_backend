<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AdmissionRepository;
use Illuminate\Http\Request;
use App\Utils\SettingUtils;

class AdmissionApiController extends Controller
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
    public function index(Request $request)
    {
        $school_id=$request->header("school-d")?$request->header("school-id"):null;
        $data=$school_id?["school_id"=>$school_id]:null;
        return $this->admissionRepo->list($data);
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
        $data=$request->all();
        return $this->admissionRepo->store($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->admissionRepo->get($id);
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
        $data=$request->all();
        return $this->admissionRepo->update($id,$data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->admissionRepo->delete($id);
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addPayment($id,Request  $request)
    {
        return $this->admissionRepo->addPayment($id,$request->all());
    }
    public function updatePayment($id,Request  $request,)
    {
        return $this->admissionRepo->updatePayment($id,$request->all());
    }
    public function getPayment($id)
    {
        try{
            $payment=$this->admissionRepo->getPayment($id);
            return $payment;
        }catch(Exception $e){
            return $e->message();
        }

    }
}
