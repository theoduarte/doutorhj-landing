<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPacienteIdToDependentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('dependentes', function (Blueprint $table) {
    		$table->integer('paciente_id')
    		->unsigned()
    		->nullable()
    		->after('parentesco');
    		 
    		$table->foreign('paciente_id')->references('id')->on('pacientes');
    	});
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table('dependentes', function (Blueprint $table) {
    	    $table->dropForeign('dependentes_paciente_id_foreign');
    		$table->dropColumn('paciente_id');
    	});
    }
}
