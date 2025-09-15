<?php

namespace App\Repositories;

use MrAtiebatie\Repository;
use App\Models\Admission;
use App\Models\Payment;
use App\Utils\EmailUtils;
use App\Models\Setting;
use App\Models\User;
use App\Models\Student;

use App\Services\RolesService;
use Illuminate\Support\Facades\Hash;

class AdmissionRepository
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        // setup the model
        $this->model = app(Admission::class);
    }
    public function store($data) {
        $exist= $this->model->where("email",$data["email"])->where("school_id",$data["school_id"])->first();
        $admission=null;
        if($exist&& $exist->id){
            $exist->update($data);
            $admission= $exist;
        }else{
            $admission=$this->model->create($data);
        }
       $this->getPayment($admission->id);
        return $admission ;
    }
    public function update($id,$data) {
        $admission=$this->model->find($id);
        $response=null;
        if($admission)
        $response=$admission->update($data);
        $this->getPayment($admission->id);
        if(isset($data["transaction"])){
            $status=$data["transaction"]["status"]=="FAILED"?1:0;
            Payment::find($data["payment_id"])->update(["status"=>status]);
        }
        return $response;
    }
    public function get($id) {
        return $this->model->find($id);

    }
    public function list($data=null) {
        $response=null;
        if($data)
             $response= $this->model->where($data)->get();
        else
             $response=$this->model->all();
      return $response;
    }
    public function delete($id) {
        return $this->model->find($id)->delete();
    }

    function sendAdmissionEmail($email,$admission_id=null,$payment_id=null){
        return EmailUtils::sendAdmissionEmail($admission_id,$payment_id);
    }

    function addPayment($data,$admission=null){
       // $admission=$this->model->find($id);
        $payment=Payment::create($data);
        if($admission &&$admission->email)
        $this->sendAdmissionEmail($admission->email,$admission->id,$payment->id);
        return $payment ;
     }
     function getPayment($id){
        $admission=Admission::find($id);
        if(!$admission)
        return null;
        $admission_payment_code=$admission->school_id."_SUBSCRIPTION_PRICE";
        $payment_config=Setting::where("code",$admission_payment_code)->first();
        $amount=50000;
        if($payment_config)
        $amount=$payment_config->value;
        $payment_data=[
            "amount"=>$amount,
            "reference_name"=>$admission_payment_code,
            "reference_code"=>$admission->id,
            "reference_details"=>"Frais de dossier pour ". $admission->school_id,
            "status"=>0,
            "payer_id"=>$admission->id,
            "payer_type"=>"admission",
            ];
        $payment=Payment::where(["payer_type"=>"admission","payer_id"=>$admission->id])->first();
        if(!$payment){
            $payment=$this->addPayment($payment_data,$admission);
        }
        else{
            $payment->update($payment_data);
           // $this->sendAdmissionEmail($admission->email,$admission->id,$payment->id);

        }

        return $payment;
     }
    function updatePayment($payment_id,$data){
       // dd($payment_id,$data);
         Payment::find($payment_id)->update($data);
         return  Payment::find($payment_id);
    }

public function createUser($admission){
       // $admission=$this->model->find($id);
       $user = new User();
        $user->name     = $admission->last_name;
        $user->email   =  $admission->email;
        $user->phone =  $admission->phone;
        $user->first_name = $admission->first_name;
        $user->last_name = $admission->last_name;
        $pass="ETUDi@ant".$admission->id;
        $user->password = Hash::make($pass);
        $user->menuroles="student";
        $exist=User::where("email",$user->email)->first();
        if(!$exist){
            $user->save();
        }else{
            $user=$exist;
        }
        return $user ;
     }
public function createStudent($user,$admission){
    $student_data=   [  "user_id"=>$user->id,
                        "admission_id"=>$admission->id,
                        "status"=>1,
                        "moodle_user_name"=>$admission->email,
                        "moodle_password"=>"ETUDi@ant".$admission->id,
                        "school_id"=>$admission->school_id,//session("school_id"),
                        "study_level"=>$admission->study_path_id
                        ];
    $exist= Student::where("user_id",$user->id)->first();
    if($exist)
    return $exist;
    $student = Student::create($student_data);
    return $student;
     }
    public function createUserAndStudent($admission){
        $user= $this->createUser($admission);
        $student=$this->createStudent($user,$admission);
        return ["user"=>$user,"student"=>$student] ;
     }
    }


