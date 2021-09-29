<?php

return [

	/* Important Settings */

	// ======================================================================
	// never remove 'web', just put your middleware like auth or admin (if you have) here. eg: ['web','auth']
	'middlewares' => ['language','admin'],
	// you can change default route from sms-admin to anything you want
	'route' => '{lang}/admin/sms-admin',
	// SMS.ir Web Service URL
	'webservice-url' => env('SMSIR-WEBSERVICE-URL','https://ws.sms.ir/'),
	// SMS.ir Api Key
	'api-key' => '8fa9c3a25f528b6e7fb5bfef',
	// SMS.ir Secret Key
	'secret-key' => 'eBCit66)%#t!@*&',
	// Your sms.ir line number
	'line-number' => '50002015497938',
	// ======================================================================
	// set true if you want log to the database
	'db-log' => true,
	// if you don't want to include admin panel routes set this to false
	'panel-routes' => true,
	/* Admin Panel Title */
	'title' => 'مدیریت پیامک ها',
	// How many log you want to show in sms-admin panel ?
	'in-page' => '15'
];
