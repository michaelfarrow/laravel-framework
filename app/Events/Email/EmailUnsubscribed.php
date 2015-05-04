<?php namespace App\Events\Email;

use App\Events\EmailClientEvent;

class EmailUnsubscribed extends EmailClientEvent {

	public $tag;

}
