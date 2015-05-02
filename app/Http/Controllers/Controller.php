<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Routing\Redirector as Redirect;
use Illuminate\Session\Store as Session;
use Illuminate\Routing\Router as Route;

abstract class Controller extends BaseController
{

	use DispatchesCommands, ValidatesRequests;

	protected $layout;
	protected $request;
	protected $guard;
	protected $redirect;
	protected $session;
	protected $route;

	public function __construct(
		Request  $request = null,
		Guard    $guard = null,
		Redirect $redirect = null,
		Session  $session = null,
		Route    $route = null
	) {
		$this->resolve();

		$this->layout = (object) [];
		$this->setPageData();
	}

	protected function setPageData()
	{
		$route = $this->route->current();
		$siteTitleKey = 'copy.site.title';
		$pageTitleKey = 'copy.' . ($route ? $this->route->current()->getName() : 'noRoute') . '.title';

		$pageTitle = trans($pageTitleKey);
		if ($pageTitle == $pageTitleKey)
			$pageTitle = false;

		$siteTitle = trans($siteTitleKey);
		if ($siteTitle == $siteTitleKey)
			$siteTitle = 'Laravel 5';

		$title = $pageTitle
			? $pageTitle . ' - ' . $siteTitle
			: $siteTitle;

		if (!$pageTitle)
			$pageTitle = $siteTitle;

		$this->layout->page = (object) [
			'siteTitle' => $siteTitle,
			'fullTitle' => $title,
			'title' => $pageTitle,
		];
	}

	protected function resolve()
	{
		static $dependencies;

		$app = App::getInstance();
		$trace = debug_backtrace();

		// Get parameters
		if ($dependencies === null)
		{
			$dependencies = [];
		}

		$reflector = new \ReflectionClass($trace[1]['class']);
		$constructor = $reflector->getConstructor();
		$dependencies = array_merge(
			$dependencies,
			$constructor->getParameters()
		);

		foreach ($dependencies as $dependency)
		{
			// Process only omitted optional parameters
			if ($this->{$dependency->name} === null)
			{
				// Assign variable
				$this->{$dependency->name} = $app->make($dependency->getClass()->name);
			}
		}
	}

	protected function layout($items)
	{
		$this->layout = (object) array_merge(
			(array) $this->layout,
			$items
		);
	}

	protected function view($name)
	{
		return view($name)->with(
			(array) $this->layout
		);
	}

}
