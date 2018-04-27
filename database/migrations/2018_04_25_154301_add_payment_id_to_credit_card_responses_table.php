<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentIdToCreditCardResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('credit_card_responses', function (Blueprint $table) {
    		$table->integer('payment_id')
    		->unsigned()
    		->nullable()
    		->after('return_message');
    	
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
    	Schema::table('credit_card_responses', function (Blueprint $table) {
    		$table->dropForeign('credit_card_responses_payment_id_foreign');
    		$table->dropColumn('payment_id');
    	});
    }
}
