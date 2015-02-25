<?php

use App\User;

class UsersTableSeeder extends DatabaseSeeder
{

	
	public function run()
	{

		User::create([
			'name' => env('ROOT_USER_NAME', 'Test User'),
			'email' => env('ROOT_USER_EMAIL', 'testuser@test.com'),
			'password' => Hash::make(env('ROOT_USER_PASSWORD', 'password')),
		]);

	}


}