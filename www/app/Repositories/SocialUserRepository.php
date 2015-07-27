<?php namespace App\Repositories;

use App\Models\SocialUser;
use App\Models\User;

class SocialUserRepository {

	protected $user;

	public function __construct(User $user){
		$this->user = $user;
	}

	protected function randomPassword($length = 8) {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = [];
		$alphaLength = strlen($alphabet) - 1;

		for ($i = 0; $i < $length; $i++)
		{
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}

	public function findByUserNameOrCreate($provider, $userData)
	{
		$user = $this->user->firstOrNew([
			'name'  => ucwords($provider) . ' user',
			'email' => $userData->id . '@' . $provider . '.social',
		]);

		$user->password = bcrypt($this->randomPassword(40));
		$user->confirmed = true;

		$socialUser = SocialUser::where('provider_id', '=', $userData->id)->
			where('provider', '=', $provider)->
			first();

		if(!$socialUser) {
			$socialUser = SocialUser::create([
				'provider_id' => $userData->id,
				'provider' => $provider,
				'name' => $userData->name,
				'username' => $userData->nickname,
				'email' => $userData->email,
				'avatar' => $userData->avatar,
				'token' => $userData->token,
			]);
		}

		$user->social()->associate($socialUser);
		$user->save();

		$this->checkIfUserNeedsUpdating($userData, $socialUser);
		return $user;
	}

	public function checkIfUserNeedsUpdating($userData, $user) {

		$socialData = [
			'avatar' => $userData->avatar,
			'email' => $userData->email,
			'name' => $userData->name,
			'username' => $userData->nickname,
			'token' => $userData->token,
		];

		$dbData = [
			'avatar' => $user->avatar,
			'email' => $user->email,
			'name' => $user->name,
			'username' => $user->username,
			'token' => $user->token,
		];

		if (!empty(array_diff($socialData, $dbData))) {
			$user->avatar = $userData->avatar;
			$user->email = $userData->email;
			$user->name = $userData->name;
			$user->username = $userData->nickname;
			$user->save();
		}
	}

}