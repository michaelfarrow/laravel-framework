<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('social_users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('username')->nullable();
			$table->string('email')->nullable();
			$table->string('avatar');
			$table->string('provider');
			$table->string('provider_id');
			$table->string('token');
			$table->timestamps();

			$table->unique(array('provider', 'provider_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('social_users');
	}

}
