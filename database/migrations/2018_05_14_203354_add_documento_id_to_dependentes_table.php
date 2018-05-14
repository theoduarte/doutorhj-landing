<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDocumentoIdToDependentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('dependentes', function (Blueprint $table) {
    		$table->integer('documento_id')
    		->unsigned()
    		->nullable()
    		->after('paciente_id');
    		 
    		$table->foreign('documento_id')->references('id')->on('documentos');
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
    		$table->dropForeign('dependentes_documento_id_foreign');
    		$table->dropColumn('documento_id');
    	});
    }
}
