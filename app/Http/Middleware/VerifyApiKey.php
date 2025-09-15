<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Utils\SettingUtils;

// This assumes `MyParser` is an existing class 
class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        $school_id= $request->header('school-id');
        $school_api_key= $request->header('x-api-key');
        $apiKey = Setting::where("code",$school_id."_API_KEY")->first();
        $apiKeyIsValid = (
            $apiKey
            &&
            ! empty($apiKey)
            && $school_api_key == $apiKey->value
        );
        if(!$apiKeyIsValid)
        return response()->json(["status"=>"error","message"=>"Access denied. API_KEY"],403);
        $school_settings=SettingUtils::getSchoolSettings($school_id);
        $request->school_settings=$school_settings;
        return $next($request);
    }
}
