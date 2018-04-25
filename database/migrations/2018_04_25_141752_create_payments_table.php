<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->increments('id');
            $table->string('merchant_order_id', 20)->nullable();
            $table->string('paymentId', 60)->nullable();
            $table->string('payment_type', 50)->nullable();
            $table->integer('amount')->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('country', 10)->nullable();
            $table->integer('service_tax_amount')->nullable();
            $table->integer('installments')->nullable();
            $table->string('interest', 50)->nullable();
            $table->boolean('capture')->default(FALSE);
            $table->boolean('authenticate')->default(FALSE);
            $table->string('soft_descriptor', 50)->nullable();
            $table->string('crc_card_number', 16)->nullable();
            $table->string('crc_holder', 50)->nullable();
            $table->string('crc_expiration_date', 10)->nullable();
            $table->string('crc_security_code', 4)->nullable();
            $table->boolean('crc_save_card')->default(FALSE);
            $table->string('crc_brand', 10)->nullable();
            $table->string('dbc_customer_name', 100)->nullable();
            $table->string('dbc_card_number', 16)->nullable();
            $table->string('dbc_holder', 50)->nullable();
            $table->string('dbc_expiration_date', 10)->nullable();
            $table->string('dbc_security_code', 4)->nullable();
            $table->string('dbc_brand', 10)->nullable();
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
        Schema::dropIfExists('payments');
    }
}
