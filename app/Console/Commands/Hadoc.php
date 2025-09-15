<?php

namespace App\Console\Commands;
use App\Models\Menus;
use App\Models\Notes;
use App\Models\User;
use App\Models\Admission;

use Illuminate\Support\Facades\DB;


use Illuminate\Console\Command;

class Hadoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adhoc:run {function}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $function=$this->argument("function");
        switch($function){
            case 1:
                $this->deleteMenues();
                break;
            case 2:
                $this->deleteNotes();
                break;
            case 3:
                $this->deleteUsers();
                break;
            case 4:
                $this->deleteFakeAdmissions();
                break;
            }
    }
    function deleteMenues(){
        //Menus::where("id",">",2)->delete();
       //DB::table('menus')->latest()->take(1)->delete();
       $lastPost = Menus::orderBy('id', 'desc')->first();
        if ($lastPost) {
            $lastPost->delete();
        }
        $this->info("completed");
    }
    function deleteNotes(){
        Notes::where("id",">",0)->delete();
        $this->info("completed");
    }
    function deleteUsers(){
        $list=[2,3,4,5,6,7,8,9,10,11,13];
        User::whereIn("id",$list)->delete();
        $this->info("completed");
    }
function deleteFakeAdmissions()
{
    // Rechercher les admissions avec des caractères spéciaux, des chiffres ou des noms ne respectant pas la règle
    $invalidAdmissions = Admission::where('status', 0)
        ->where(function ($query) {
            $query->whereRaw("last_name REGEXP '[^a-zA-Z]'") // Contient des caractères spéciaux ou des chiffres
                  ->orWhereRaw("first_name REGEXP '[^a-zA-Z]'")
                  ->orWhereRaw("last_name REGEXP BINARY '^[a-zA-Z](?![a-z]*$)(?![A-Z]*$).+'") // Ne respecte pas la règle
                  ->orWhereRaw("first_name REGEXP BINARY '^[a-zA-Z](?![a-z]*$)(?![A-Z]*$).+'");
        })
        ->get();

    $this->info("Found " . count($invalidAdmissions) . " invalid admissions");

    // Supprimer les paiements liés et les admissions invalides
    foreach ($invalidAdmissions as $admission) {
        // Supprimer les paiements liés
        $this->info("Deleting payment for admission id " . $admission->id);
        DB::table('payments')->where('payer_id', $admission->id)->delete();

        // Supprimer l'admission
        $admission->delete();
        $this->info("Deleted admission id " . $admission->id);
    }

    // Supprimer les paiements où le payer_id n'existe pas dans la table admissions
    $orphanPayments = DB::table('payments')
        ->leftJoin('admissions', 'payments.payer_id', '=', 'admissions.id')
        ->whereNull('admissions.id')
        ->delete();

    $this->info("Deleted orphan payments where payer_id does not exist in admissions.");
    $this->info("Admissions et paiements liés supprimés avec succès.");
}
}



