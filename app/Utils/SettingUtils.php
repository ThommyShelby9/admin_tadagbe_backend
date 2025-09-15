<?php
/*
    16.12.2019
    RolesService.php
*/

namespace App\Utils;

use App\Models\EmailTemplate;
use App\Models\Admission;
use App\Models\Setting;


final class SettingUtils{
    
    public static  function getSchoolSettings($school_id){
        return Setting::where("code","like","%".$school_id."%")->get();
    }
}