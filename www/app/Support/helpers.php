<?php

if ( ! function_exists('trans_hier'))
{
	/**
	 * Translate the given message.
	 *
	 * @param  string  $id
	 * @param  string  $idAppend
	 * @param  string  $default
	 * @param  array   $parameters
	 * @param  string  $domain
	 * @param  string  $locale
	 * @return string
	 */
	function trans_hier($id = null, $idAppend = null, $default = null, $parameters = array(), $domain = 'messages', $locale = null)
	{
		if (is_null($id) || is_null($idAppend)) return app('translator');

		$idOriginal = $id . '.' . $idAppend;
		$idExploded = explode('.', $id);

		do
		{
			$id = implode('.', $idExploded) . '.' . $idAppend;
			$translated = trans($id, $parameters, $domain, $locale);
			array_pop($idExploded);
		}
		while ($id == $translated && count($idExploded) > 0);

		return $id == $translated
			? (is_null($default) ? $idOriginal : $default)
			: $translated;
	}
}

if ( ! function_exists('trans_default'))
{
	/**
	 * Translate the given message.
	 *
	 * @param  string  $id
	 * @param  string  $default
	 * @param  array   $parameters
	 * @param  string  $domain
	 * @param  string  $locale
	 * @return string
	 */
	function trans_default($id = null, $default = null, $parameters = array(), $domain = 'messages', $locale = null)
	{
		$return = trans($id, $parameters, $domain, $locale);

		return $return == $id
			? (is_null($default) ? $id : $default)
			: $return;
	}
}

if ( ! function_exists('array_human'))
{
	/**
	 * Convert an array of values to a human readable string.
	 *
	 * @param  array  $array
	 * @param  string $delimiter
	 * @param  string $last
	 * @return string
	 */
	function array_human($array, $delimiter = ',', $last = 'and')
	{
		if(count($array) == 0) return '';
		if(count($array) == 1) return $array[0];

		$lastItem = array_pop($array);

		return implode("$delimiter ", $array) . " $last " . $lastItem;
	}
}

if ( ! function_exists('build_asset'))
{
	/**
	 * Return a normal asset path or an elixir path,
	 * based on the current environment.
	 *
	 * @param  string $path
	 * @return string
	 */
	function build_asset($path) {
		if(App::isLocal()) {
			return asset($path);
		} else {
			return elixir($path);
		}
	}
}
