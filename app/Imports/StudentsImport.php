<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Student;

class StudentsImport implements ToModel
{

    public function model(array $row)
    {
        $exist=Student::where("first_name",$row[0])
        ->where("first_name",$row[0])
        ->where("last_name",$row[1])
        ->where("birth_date",$row[2])
        ->where("school_classe_id", $row[3])
        ->where("student_parent_user_id",$row[4])
        ->first();
        if($exist)
        return $exist;
        return new Student([
                    "first_name"=>$row[0],
                    "last_name" => $row[1],
                    "birth_date"=> $row[2],
                    "school_classe_id"=> $row[3],
                    "student_parent_user_id"=> $row[4],
                    "school_id"=> $row[5],
                    "student_user_id"=> $row[6]
                ]);
    }
}
