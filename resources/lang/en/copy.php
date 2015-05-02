<?php

// Uncomment for testing
// return [];

return [

	'site' => [
		'title' => 'Laravel 5',
	],

	'welcome' => [
		'title' => 'Welcome',
	],

	'auth' => [
		'actions' => [
			'register' => 'Register',
			'login'    => 'Login',
			'logout'   => 'Logout',
		],
		'fields' => [
			'name'     => 'Name',
			'email'    => 'Email Address',
			'password' => 'Password',
			'confirm_password' => 'Confirm Password',
		],
		'login' => [
			'title'    => 'Login',
			'remember' => 'Remember Me',
			'forgot'   => 'Forgot Your Password?',
		],
		'register' => [
			'title' => 'Register',
		],
	],

	'password' => [
		'email' => [
			'title' => 'Forgot Password',
			'actions' => [
				'send'  => 'Send Password Reset Link',
			],
		],
		'reset' => [
			'title' => 'Reset Password',
			'actions' => [
				'reset' => 'Reset Password',
			],
		],
	],

	'home' => [
		'title' => 'Home',
	],

];