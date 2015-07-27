<?php namespace App\Events;

class EmailEvent extends Event {

	public $id;
	public $timestamp;
	public $domain;
	public $email;
	public $headers;

}
