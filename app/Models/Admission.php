<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;
class Admission extends Model
{
    use HasFactory;
    //0=processing,1=incomplete, 2=paid,3=validated,studying,
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:00',
        'updated_at' => 'datetime:d-m-Y H:00',
    ];
    protected $fillable = [
        "user_id",
        "status",
        "study_branch_code",
        "school_id",
        "study_path_id",
        "first_name",
        "last_name",
        "birth_date",
        "phone",
        "email",
        "nationality",
        "photo_url",
        "cv_url",
        "last_degre_url",
        "releve_bac_url",
        "id_card_url",
        "motivation_letter_url",
        "paiement_proof_url",
        "paiement_mode"
        ];
        function getStatusString(){
            $status="";
            switch($this->status){
                case 0:
                    $status="En attente";
                    break;
                case 1:
                    $status="A compléter";
                    break;
                case 2:
                    $status="En traitement";
                    break;
                case 3:
                    $status="Validée";
                    break;
            }
            return $status;
        }
        function getStatusClass(){
            $class="";
            switch($this->status){
                case 0:
                    $class="badge badge-warning";
                    break;
                case 1:
                    $class="badge badge-success";
                    break;
                case 2:
                    $class="badge badge-secondary";
                    break;
                case 3:
                    $class="badge badge-danger";
                    break;
            }
           // dd($class);
            return $class;
        }
        function payment(){
            return Payment::where(['payer_type'=>"admission","payer_id"=>$this->id])->first();
            }
        function getStatusClassAndText(){
            $class="";
            $text="";
            switch($this->status){
                case 0:
                    $text="En attente";
                    $class="class='badge badge-warning'";
                    break;
                case 1:
                    $text="Validée";
                    $class="class='badge badge-success'";
                    break;
                case 2:
                    $text="En de vérification";
                    $class="class='badge badge-secondary'";
                    break;
                case 3:
                    $text="Rejetée";
                    $class="class='badge badge-danger'";
                    break;
            }
           // dd($class);
            return ["text"=>$text,"class"=>$class];
        }
        function getStatusSpan(){
            $status=$this->getStatusClassAndText();
           return "<span ".$status['class'].">".$status['text']."</span>";
        }

}
