<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'statistics';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'start',
		'end',
		'name',
		'period',
		'value',
	];

	/**
	 * Model boot method, corrects null dates.
	 *
	 * @return void
	 */
	// public static function boot()
	// {
	// 	parent::boot();

	// 	static::creating(function($model){
	// 		if(is_null($model->start)) $model->start = '0000-00-00 00:00:00';
	// 		if(is_null($model->end)) $model->end = '0000-00-00 00:00:00';
	// 	});
	// }

	/**
	 * Get the attributes that should be converted to dates.
	 *
	 * @return array
	 */
	public function getDates()
	{
		return [
			'created_at',
			'updated_at',
			'start',
			'end',
		];
	}

}
