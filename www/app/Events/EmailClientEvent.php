<?php namespace App\Events;

class EmailClientEvent extends EmailEvent {

	public $ip;
	public $city;
	public $country;
	public $region;
	public $device_type;
	public $client_type;
	public $client_name;
	public $client_os;
	public $user_agent;

	/**
	 * Create a new event instance.
	 *
	 * @param  String $ip
	 * @param  String $city
	 * @param  String $country
	 * @param  String $region
	 * @param  String $device_type
	 * @param  String $client_type
	 * @param  String $client_name
	 * @param  String $client_os
	 * @param  String $user_agent
	 * @return void
	 */
	public function __construct(
		$code,
		$city,
		$country,
		$region,
		$device_type,
		$client_type,
		$client_name,
		$client_os,
		$user_agent
	) {
		$this->code = $code;
		$this->city = $city;
		$this->country = $country;
		$this->region = $region;
		$this->device_type = $device_type;
		$this->client_type = $client_type;
		$this->client_name = $client_name;
		$this->client_os = $client_os;
		$this->user_agent = $user_agent;
	}

}
