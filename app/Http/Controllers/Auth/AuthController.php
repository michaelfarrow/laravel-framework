<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Contracts\Auth\Guard as Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

	use AuthenticatesAndRegistersUsers;

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
		Auth $auth
	) {
		parent::__construct();
		$this->resolve();

		$this->loginPath = route('auth.login');

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function redirectPath(){
		return $this->registrar->homeRoute();
	}

	public function getLogin() {
		return $this->view('auth.login');
	}

	public function getRegister() {
		return $this->view('auth.register');
	}

}
