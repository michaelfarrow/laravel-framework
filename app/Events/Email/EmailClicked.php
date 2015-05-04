<?php namespace App\Events\Email;

use App\Events\EmailClientEvent;

class EmailClicked extends EmailClientEvent {

	public $url;

}
