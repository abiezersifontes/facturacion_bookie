<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactuClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('mysql')->create('factu_clientes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('tipdoc');
			$table->integer('numdoc');
			$table->string('nombre');
			$table->string('direccion');
			$table->string('estado');
			$table->string('ciudad');
			$table->integer('CodSucursal');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('mysql')->drop('factu_clientes');
	}

}
