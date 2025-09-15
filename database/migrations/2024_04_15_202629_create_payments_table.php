<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('amount');
            $table->string('reference_name')->nullable();
            $table->string('reference_code')->nullable();//admission,
            $table->string('reference_details')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('payer_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('status')->default(1);
            $table->json('metadata')->default(null);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
