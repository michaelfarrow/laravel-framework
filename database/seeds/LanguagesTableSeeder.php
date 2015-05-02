<?php

use Waavi\Translation\Models\Language;

class LanguagesTableSeeder extends DatabaseSeeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		if (Language::get()->count() != 0) return;

		Language::create([
			'locale' => 'en',
			'name'   => 'english',
		]);

	}


}
