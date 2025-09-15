<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

protected $casts = [
        'created_at' => 'datetime:d-m-Y H:00',
        'updated_at' => 'datetime:d-m-Y H:00',
    ];
    protected $fillable = [
        "amount",
        "reference_name",
        "reference_code",
        "reference_details",
        "status",
        "payer_id",
        "payer_type",
        "payment_method",
        "metadata",
        "payment_proof"
    ];
    function getStatusClassAndText(){
            $class="class='badge badge-danger'";
            $text="Aucun Payement";
            switch($this->status){
                case 0:
                    $text="Attente de paiement";
                    $class="class='badge badge-warning'";
                    break;
                case 1:
                    $text="Payé";
                    $class="class='badge badge-success'";
                    break;
                case 2:
                    $text="Attente de vérification";
                    $class="class='badge badge-secondary'";
                    break;
                case 3:
                    $text="Payement rejeté";
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
        function admission(){
            return $this->hasOne(Admission::class,"id","payer_id");
        }
}

