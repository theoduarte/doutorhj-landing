<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditCardResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditcardresponse', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proof_of_sale', 6)->nullable();
			$table->string('tid', 20)->nullable();
			$table->string('authorization_code', 6)->nullable();
			$table->string('soft_descriptor', 13)->nullable();
			$table->integer('crc_status')->nullable();
			$table->string('return_code', 32)->nullable();
			$table->string('return_message', 32)->nullable();
		    $table->timestamp('created_at')->default(DB::raw('NOW()'));
            $table->timestamp('updated_at')->default(DB::raw('NOW()'));
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('creditcardresponse');
    }
}