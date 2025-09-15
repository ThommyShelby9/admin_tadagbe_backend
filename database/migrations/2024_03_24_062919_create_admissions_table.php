<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('status')->default(0);//0=processing,1=incomplete, 2=paid,3=validated,studying,
            $table->string('school_id')->nullable();
            $table->string("study_path_id")->nullable();
            $table->string("first_name")->nullable();
            $table->string("last_name")->nullable();
            $table->date("birth_date")->nullable();
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->string("nationality")->nullable();
            $table->string("photo_url")->nullable();
            $table->string("cv_url")->nullable();
            $table->string("last_degre_url")->nullable();
            $table->string("releve_bac_url")->nullable();
            $table->string("motivation_letter_url")->nullable();
            $table->string("paiement_proof_url")->nullable();
            $table->string("paiement_mode")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admissions');
    }
}
