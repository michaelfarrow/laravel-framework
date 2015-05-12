<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Contracts\Auth\Guard as Auth;
use Laravel\Socialite\Contracts\Factory as Socialite; 
use App\Repositories\SocialUserRepository;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller {

	use AuthenticatesAndRegistersUsers;

	protected $socialite;
	protected $socialUsers;

	protected $loginPath;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(
		Registrar $registrar,
		Auth $auth,
    Socialite $socialite,
    SocialUserRepository $socialUsers
	) {
		parent::__construct();
		$this->resolve();

		$this->loginPath = route('auth.login');

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function getProvider($provider)
	{
		if ( ! array_key_exists($provider, config('auth.providers')))
			abort(404);

		if ( ! $this->request->all()) return $this->socialite->driver($provider)->redirect();

		$user = $this->socialUsers->findByUserNameOrCreate($provider, $this->socialite->driver($provider)->user());

		$this->auth->login($user, true);

    return redirect($this->redirectPath());
	}

	public function redirectPath()
	{
		return $this->registrar->homeRoute();
	}

	public function getLogin()
	{
		return $this->view('auth.login');
	}

	public function getRegister()
	{
		return $this->view('auth.register');
	}

}
