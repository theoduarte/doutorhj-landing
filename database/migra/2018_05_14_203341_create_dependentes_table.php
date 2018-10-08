<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDependentesTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependentes', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('nm_primario', 50);
        	$table->string('nm_secundario', 100);
        	$table->string('cs_sexo', 1);
        	$table->string('email', 250);
        	$table->string('parentesco', 20);
        	$table->date('dt_nascimento')->nullable()->comment('DATA DE NASCIMENTO');
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
        Schema::dropIfExists('dependentes');
    }
}
