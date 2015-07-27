<?php namespace App\Services;

use Validator;
use Auth;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		$userModel = config('auth.model');

		return $userModel::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'confirmed' => true,
		]);
	}

	/**
	 * return home route url for the currently logged in user,
	 * based on the users role.
	 *
	 * @return string
	 */
	public function homeRoute()
	{
		$user = Auth::user();

		if(!$user) return route('welcome');

		return $user->hasRole('admin')
			? route('admin.home')
			: route('app.home');
	}

}
