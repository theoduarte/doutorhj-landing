<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrupoProcedimentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('grupo_procedimentos')->delete();
    	
    	DB::table('grupo_procedimentos')->insert(array (
    			0 =>
    			array (
    					'id'             => '1',
    					'ds_grupo' => 'CBHPM Geral',
    			),
    			1 =>
    			array (
    					'id'             => '2',
    					'ds_grupo' => 'Procedimentos Laboratoriais',
    			),
    			2 =>
    			array (
    					
    					'id'             => '3',
    					'ds_grupo' => 'Anatomia Patológica e Citopatol',
    			),
    			3 =>
    			array (
    						
    					'id'             => '4',
    					'ds_grupo' => 'Raio-X',
    			),
    			4 =>
    			array (
    			
    					'id'             => '5',
    					'ds_grupo' => 'Ultrassonografias',
    			),
    			5 =>
    			array (
    					 
    					'id'             => '6',
    					'ds_grupo' => 'Tomografias',
    			),
    			6 =>
    			array (
    					 
    					'id'             => '7',
    					'ds_grupo' => 'Ressonâncias Magnéticas',
    			),
    			7 =>
    			array (
    					 
    					'id'             => '8',
    					'ds_grupo' => 'Cardiologia',
    			),
    			8 =>
    			array (
    					 
    					'id'             => '9',
    					'ds_grupo' => 'Ginecologia',
    			),
    			9 =>
    			array (
    					 
    					'id'             => '10',
    					'ds_grupo' => 'Urologia',
    			),
    			10 =>
    			array (
    					 
    					'id'             => '11',
    					'ds_grupo' => 'Oftalmologia',
    			),
    			11 =>
    			array (
    					 
    					'id'             => '12',
    					'ds_grupo' => 'Dermatologia',
    			),
    			
    	));
    }
}
