<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Models\Hashed;

class User extends Hashed implements AuthenticatableContract, CanResetPasswordContract
{

	use Authenticatable,
	    CanResetPassword,
	    EntrustUserTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * Get the name of the user, from the first relevant social
	 * or user table field.
	 *
	 * @return string
	 */
	public function getNameAttribute()
	{
		if ($this->social)
		{
			return $this->social->name ?:
				$this->social->username ?:
					$this->social->email ?:
						$this->attributes['name'];
		}
		else
		{
			return $this->attributes['name'];
		}
	}

	/**
	 * Is the current login the users first?
	 *
	 * @return boolean
	 */
	public function isFirstLogin()
	{
		return $this->last_login == $this->first_login;
	}

	/**
	 * The users social user relationship.
	 *
	 * @var Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function social()
	{
		return $this->belongsTo('App\Models\SocialUser', 'social_id', 'id');
	}

}
