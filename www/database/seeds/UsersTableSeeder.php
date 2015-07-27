<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class UsersTableSeeder extends DatabaseSeeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		if (Role::get()->count() == 0)
		{
			Role::create([
				'name'         => 'admin',
				'display_name' => 'Admin',
				'description'  => 'User can adminstrate the site',
			]);

			Role::create([
				'name'         => 'user',
				'display_name' => 'User',
				'description'  => 'User can navigate the site',
			]);
		}

		if (User::get()->count() == 0)
		{
			User::create([
				'name'     => env('ROOT_USER_NAME', 'Test User'),
				'email'    => env('ROOT_USER_EMAIL', 'testuser@test.com'),
				'password' => Hash::make(env('ROOT_USER_PASSWORD', 'password')),
			])->attachRole(Role::where('name', '=', 'admin')->first());
		}
	}

}
