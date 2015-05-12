<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('statistics', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('period');
			$table->datetime('start')->nullable();
			$table->datetime('end')->nullable();
			$table->double('value', 15, 8);
			$table->timestamps();

			$table->unique(['name', 'period', 'start', 'end']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('statistics');
	}

}
