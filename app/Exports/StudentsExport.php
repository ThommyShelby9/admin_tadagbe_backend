<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Student;

class StudentsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::select("users.first_name","users.last_name","users.phone","users.email","students.study_level","students.school_id")->join("users","users.id","students.user_id")->get();

    }
}
