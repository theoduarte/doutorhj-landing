<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebitCardResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debitcardresponse', function (Blueprint $table) {
            $table->increments('id');
            $table->text('authentication_url')->nullable();
			$table->string('tid', 20)->nullable();
			$table->text('return_url')->nullable();
			$table->integer('dbc_status')->nullable();
			$table->string('return_code')->nullable();
			
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
        Schema::dropIfExists('debitcardresponse');
    }
}