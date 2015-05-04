<?php namespace App\Repositories;

class UserRepository {

	/**
	 * The user model.
	 *
	 * @var Model
	 */
	protected $model;

	/**
	 * Create the repository.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$model = config('auth.model');
		$this->model = new $model;
	}

	/**
	 * Find single user by email.
	 *
	 * @param  $email
	 * @return Model|null
	 */
	public function findByEmail($email)
	{
		return $this->model->where('email', '=', $email)->first();
	}

}