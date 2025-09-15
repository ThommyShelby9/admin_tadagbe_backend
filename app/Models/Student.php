<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:00',
        'updated_at' => 'datetime:d-m-Y H:00',
    ];
    protected $fillable=[
        "user_id",
        "admission_id",
        "status",
        "moodle_user_name",
        "moodle_password",
        "school_id",
        "study_level"
        ];
        function user(){
            return $this->hasOne(User::class,"id","user_id");
        }
        function school(){
            return $this->hasOne(School::class,"id","school_id");
        }
        function admission(){
            return $this->hasOne(Admission::class,"id","admission_id");
        }
}
