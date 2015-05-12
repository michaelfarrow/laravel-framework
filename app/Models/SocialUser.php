<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialUser extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'social_users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'username',
		'email',
		'avatar',
		'provider',
		'provider_id',
		'token',
	];

	/**
	 * The social users user relationship.
	 *
	 * @var Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user(){
		return $this->hasOne('App\Models\User', 'id', 'social_id');
	}

}
