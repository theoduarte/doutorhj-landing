<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentIdToDebitCardResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('debit_card_responses', function (Blueprint $table) {
    		$table->integer('payment_id')
    		->unsigned()
    		->nullable()
    		->after('return_code');
    		 
    		$table->foreign('payment_id')->references('id')->on('payments');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table('debit_card_responses', function (Blueprint $table) {
    		$table->dropForeign('debit_card_responses_payment_id_foreign');
    		$table->dropColumn('payment_id');
    	});
    }
}
