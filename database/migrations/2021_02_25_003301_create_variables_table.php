<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVariablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('variables', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('type')->default(1);
			$table->boolean('is_hidden')->default(0);
			$table->string('key')->nullable();
			$table->string('name')->nullable();
			$table->string('description')->nullable();
			$table->boolean('multilingual')->default(0);
			$table->text('value')->nullable();
			$table->boolean('status')->default(1);
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
		Schema::drop('variables');
	}

}
