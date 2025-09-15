<?php

namespace App\Repositories;

use MrAtiebatie\Repository;
use App\Models\Programme; 
use App\Utils\EmailUtils; 

class ProgrammeRepository
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
        $this->model = app(Programme::class);
    }
    public function store($data) {
        $exist= $this->model->where("date",$data["date"])->first();
        $Programme=null;
        if($exist&& $exist->id){
            $exist->update($data);
            $Programme= $exist;
        }else{
            $Programme=$this->model->create($data);
        }
        return $Programme ;
    }
    public function update($id,$data) {
        $Programme=$this->model->find($id);
        $response=null;
        if($Programme)
        $response=$Programme->update($data);
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

    function sendProgrammeEmail($email){
        return EmailUtils::sendProgrammeEmail($email);
    }
}
