<?php
return [	
	// Your API Key, get your key in https://rajaongkir.com/
	'api_key'			=> env('RAJAONGKIR_API_KEY',''),

	//Your origin ID
	'origin'			=>'',

	// Type your account example: starter, basic, pro
	'type'				=> 'starter',

	// Available couriers
	'available_couriers'=>[
		'jne',
		'pos',
		'tiki'
	]
];