<?php namespace App\Traits;

trait ResolvesDependencies {

	/**
	 * Resolve constructor dependencies.
	 * Used to inherit dependencies in subclasses.
	 *
	 * @return void
	 */
	protected function resolve()
	{
		static $dependencies;

		$trace = debug_backtrace();

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
			if ($this->{$dependency->name} === null)
			{
				$this->{$dependency->name} = app()->make($dependency->getClass()->name);
			}
		}
	}

}
