<?php namespace App\Events\Email;

use App\Events\EmailEvent;

class EmailBounced extends EmailEvent {

	public $code;
	public $error;

	/**
	 * Create a new event instance.
	 *
	 * @param  String $code
	 * @param  String $error
	 * @return void
	 */
	public function __construct($code, $error) {
		$this->code = $code;
		$this->error = $error;
	}

}
