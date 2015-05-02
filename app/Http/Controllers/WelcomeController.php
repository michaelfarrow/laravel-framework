<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');

		parent::__construct();
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		function outputList($list)
		{
			$out = '<ul>';

			foreach ($list as $key => $value)
			{
				$out .= '<li class="' . (is_array($value) ? 'array' : 'string') . '">';
				$out .= '<h2 style="display:inline;">' . $key . '</h2> ';
				$out .= is_array($value) ? outputList($value) : $value;
				$out .= '</li>';
			}

			$out .= '</ul>';
			return $out;
		}
		// $trans = trans('copy.site.title');

		// $output = [];

		// foreach ($trans as $key => $value) {
		// 	$output[md5($key)] = $key;
		// }

		// return $output;
		// return $trans;

		$lang = [
			'passwords' => trans('passwords'),
			'pagination' => trans('pagination'),
			'validation' => trans('validation'),
			'copy' => trans('copy'),
		];
		$langDot = array_dot($lang);

		$langFinal = [];
		foreach ($langDot as $key => $value) {
			array_set($langFinal, $key, $value);
		}

		$langinfo = outputList($langFinal);

		return $this->view('welcome')->with('langinfo', $langinfo);
	}

	public function test($id)
	{
		$user = \App\Models\User::findHashed('47ee991c-8500-42e7-b6ba-50f6c1edb729');

		$user->load('roles');

		return $user;

		return route('test', \App\Models\User::first());
		return $id;
	}

}
