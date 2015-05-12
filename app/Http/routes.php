<?php

Route::any('/', [
	'uses' => 'WelcomeController@index',
	'as'   => 'welcome',
]);

Route::get('test/{id}', [
	'uses' => 'WelcomeController@test',
	'as'   => 'test',
]);

Route::controller('account', 'Auth\AuthController', [
	'getProvider'  => 'auth.provider',
	'getLogin'     => 'auth.login',
	'postLogin'    => 'auth.login.do',
	'getRegister'  => 'auth.register',
	'postRegister' => 'auth.register.do',
	'getLogout'    => 'auth.logout',
	'getComplete'  => 'auth.complete',
	'getConfirm'   => 'auth.confirm',
	'getRoadblock' => 'auth.roadblock',
	'getResendConfirmation' => 'auth.resend_confirmation',
]);

Route::controller('password', 'Auth\PasswordController', [
	'getEmail'  => 'password.email',
	'postEmail' => 'password.email.do',
	'getReset'  => 'password.reset',
	'postReset' => 'password.reset.do',
]);

Route::get('home', [
	'uses' => 'App\HomeController@index',
	'as'   => 'app.home',
]);

Route::group([
	'prefix'    => 'admin',
	'namespace' => 'Admin',
], function(){

	Route::get('/', [
		'uses' => 'HomeController@index',
		'as'   => 'admin.home',
	]);

	Route::controller('copy', 'CopyController', [
		'getIndex'  => 'admin.copy',
		'postIndex' => 'admin.copy.do',
	]);

});

Route::group([
	'prefix'    => 'hook',
	'namespace' => 'Hooks',
], function(){

	Route::controller('mailgun', 'MailgunController');

});

