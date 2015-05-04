<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Traits\ResolvesDependencies;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Routing\Redirector as Redirect;
use Illuminate\Session\Store as Session;
use Illuminate\Routing\Router as Route;

abstract class Controller extends BaseController
{

	use DispatchesCommands,
	    ValidatesRequests,
	    ResolvesDependencies;

	protected $layout;
	protected $request;
	protected $guard;
	protected $redirect;
	protected $session;
	protected $route;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
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
		$route = ($route ? $route->getName() : 'noRoute');
		$routeParts = explode('.', $route);
		$siteTitleKey = 'copy.site.title';
		$pageKey = 'copy.' . $route;
		$pageCopy = trans($pageKey);
		if($pageCopy == $pageKey) $pageCopy = [];
		$pageCopy = (object) $pageCopy;

		$pageTitleKey = $pageKey . '.title';

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
			'copy' => $pageCopy,
			'route' => $route,
			'routeParts' => $routeParts,
		];
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
