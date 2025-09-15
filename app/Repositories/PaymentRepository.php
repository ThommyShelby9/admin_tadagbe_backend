<?php

namespace App\Repositories;

use MrAtiebatie\Repository;
use App\Models\Payment; 
use App\Utils\EmailUtils; 

class PaymentRepository
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
        $this->model = app(Payment::class);
    }
    public function store($data) {
        $exist= $this->model->where("email",$data["email"])->first();
        $payment=null;
        if($exist&& $exist->id){
            $exist->update($data);
            $payment= $exist;
        }else{
            $payment=$this->model->create($data);
        }
        $this->sendPaymentEmail($payment->email);
        return $payment ;
    }
    public function update($id,$data) {
        $payment=$this->model->find($id);
        $response=null;
        if($payment)
        $response=$payment->update($data);
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

    function sendPaymentEmail($email){
        return EmailUtils::sendPaymentEmail($email);
    }

    function adddPayment($data){
       // $payment=$this->model->find($id);
        return Payment::create($data);   
     }
}
