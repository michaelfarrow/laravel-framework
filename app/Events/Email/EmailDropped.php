<?php namespace App\Events\Email;

use App\Events\EmailEvent;

class EmailDropped extends EmailEvent {

	public $code;
	public $description;
	public $reason;

	/**
	 * Create a new event instance.
	 *
	 * @param  String $code
	 * @param  String $description
	 * @param  String $reason
	 * @return void
	 */
	public function __construct($code, $description, $reason) {
		$this->code = $code;
		$this->description = $description;
		$this->reason = $reason;
	}

}
