<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVariableTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('variable_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('variable_id')->unsigned()->index();
			$table->string('locale');
			$table->text('text')->nullable();
			$table->text('json')->nullable();
            $table->unique(['variable_id', 'locale']);
            $table->foreign('variable_id')->references('id')
                ->on('variables')->onDelete('cascade')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('variable_translations');
	}

}
