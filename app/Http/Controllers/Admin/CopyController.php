<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Symfony\Component\Translation\TranslatorInterface;
use Illuminate\Http\Request;
use Waavi\Translation\Models\Language;
use Waavi\Translation\Models\LanguageEntry;

class CopyController extends AdminController {

	protected $trans;
	protected $language;

	public function __construct(
		TranslatorInterface $trans = null,
		Language $language = null
	) {
		parent::__construct();

		$this->resolve();
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		return $this->view('admin.copy')->withTrans([
			'copy' => trans('copy'),
		]);
	}

	public function postIndex(Request $request)
	{
		$trans = $request->all();
		$language = $this->language->where('locale', '=', $this->trans->locale())->first();

		if(!$language) \App::abort();

		foreach ($trans as $groupKey => $group)
		{
			if(is_array($group))
			{
				$group = array_dot($group);

				foreach ($group as $key => $value)
				{
					$entry = $language->entries()
						->where('group', '=', $groupKey)
						->where('item', '=', $key)
						->first();

					if(!$entry)
					{
						$language->entries()->create([
							'group' => $groupKey,
							'item'  => $key,
							'text'  => $value,
						]);
					}
					else
					{
						$entry->text = $value;

						if($entry->isDirty())
							$entry->save();
					}
				}
			}
		}

		return redirect()->back()->withInput();
	}

}
