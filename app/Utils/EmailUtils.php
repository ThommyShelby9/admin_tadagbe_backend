<?php
/*
    16.12.2019
    RolesService.php
*/

namespace App\Utils;

use App\Models\FormField;
use App\Models\EmailTemplate;
use App\Models\Admission;
use App\Models\Setting;

use Mail;

final class EmailUtils{
        public static function sendAdmissionEmail($admission_id,$payment_id=null){
            $admission=Admission::find($admission_id);
            if(!$admission)
            return;

            $admission_mail_setting_code=$admission->school_id."_EMAIL_SUBSCRIPTION";
            $admission_mail_setting=Setting::where("code",$admission_mail_setting_code)->first();
            if(!$admission_mail_setting)
            return;
            $template = EmailTemplate::find($admission_mail_setting->value);
            if(!$template)
            return;
            $school_link_config_code=$admission->school_id."_SCHOOL_LINK";
            $school_link_config=Setting::where("code",$school_link_config_code)->first();
            $payment_link=$school_link_config?$school_link_config->value."/admission/payment/".$admission_id:"LIEN INVALID";
            $template->content = str_replace("{{NAME}}", $admission->first_name." ".$admission->last_name, $template->content);
            $template->content = str_replace("{{LIEN_DE_PAYEMENT}}", $payment_link, $template->content);
            $template->content = str_replace("NOM_PRENOM", $admission->first_name." ".$admission->last_name, $template->content);
            $template->content = str_replace("TITRE", "Mr/Mme", $template->content);
            $template->content = str_replace("ENTETE", "", $template->content);
            $email=$admission->email;
        Mail::send([], [], function ($message) use ($email, $template)
        {
            $message->to($email);
            $message->subject($template->subject);
            $message->setBody($template->content,'text/html');
        });
        return; //redirect()->route('mail.index');
    }

    public static function sendEmail($email,$templateId,$variables=[],$files=[]){
            $template = EmailTemplate::find($templateId);
            if(!$template)
            return;
            if(json_decode($variables))
            foreach (json_decode($variables) as $variable){
                $template->content = str_replace($variable->key, $variable->value, $template->content);
            }
            $entete='<div><img src="http://admin.inter-nat.com/assets/img/entete_eiegi.png" alt="Entete"></div>';
            $template->content = str_replace("ENTETE", $entete, $template->content);
            Mail::send([], [], function ($message) use ($email, $template,$files)
            {
                $message->to($email);
                $message->subject($template->subject);
                $message->setBody($template->content,'text/html');
                if(count($files) > 0) {
                    foreach($files as $file) {
                        $message->attach($file->getRealPath(), array(
                            'as' => $file->getClientOriginalName(), // If you want you can chnage original name to custom name
                            'mime' => $file->getMimeType())
                );
                }
            }
            });
        return; //redirect()->route('mail.index');
    }
}
