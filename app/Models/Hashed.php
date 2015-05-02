<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rhumsaa\Uuid\Uuid;

class Hashed extends Model
{

	/**
	 * Model boot method, sets guid on create.
	 *
	 * @return void
	 */
	public static function boot()
	{
		parent::boot();

		static::creating(function($model){
			$model->guid = Uuid::uuid4();
		});
	}

	/**
	 * Find model by its guid.
	 *
	 * @param  mixed  $guid
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|null
	 */
	public static function findHashed($guid, $columns = array('*'))
	{
		return is_array($guid)
			? static::whereIn('guid', $guid)->get($columns)
			: static::where('guid', '=', $guid)->first($columns);
	}

	/**
	 * Get the route key for the model.
	 *
	 * @return string
	 */
	public function getRouteKeyName()
	{
		return 'guid';
	}

}
