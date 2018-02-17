<?php

/*
	Write endpoints and database table(s) to: 

	Store addresses 

	Return addresses 

	Lookup by name 

	Lookup by zip 
*/

require_once __DIR__ . '/vendor/autoload.php';
require_once '/var/www/html/AddressesApi/objects/address.php';

$klein = new \Klein\Klein();

$klein->respond(function ($request, $response, $service, $app) use ($klein) {

    $klein->onError(function ($klein, $err_msg) {

        $klein->service()->flash($err_msg);
        $klein->service()->back();
    });

    $app->db = new PDO("mysql:host=" . $this->m_strHost . ";dbname=" . $this->m_strDatabaseName, $this->m_strUsername, $this->m_strPassword);
});

$klein->respond('POST', '/addresses/[get|search|add:action]', function () {

	$objAddress = new CAddress( $app->db );
	$arrmixRequestParams = json_decode( $request->paramsPost() );

	switch( $request->action() ) {
		case 'fetch':
			$strJson = $objAddress->fetch();
			echo( $strJson );

		case 'search':
			if( true == isset( $arrmixRequestParams['name'] ) && 0 < strlen( $arrmixRequestParams['name'] ) ) {
				
				$strJson = $objAddress->fetchAddressesByName( $arrmixRequestParams['name'] );
				echo( $strJson );
			} else if ( true == isset( $arrmixRequestParams['zip_code'] ) ) {

				$strJson = $objAddress->fetchAddressesByZipCode( $arrmixRequestParams['zip_code'] );
				echo( $strJson );
			}

		case 'add':
			$objAddress->setName( $arrmixRequestParams['name'] );
			$objAddress->setStreetNumber( $arrmixRequestParams['street_number'] );
			$objAddress->setCity( $arrmixRequestParams['city'] );
			$objAddress->setState( $arrmixRequestParams['state'] );
			$objAddress->setZipCode( $arrmixRequestParams['zip_code'] );

			$strJson = $objAddress->insert();
			echo( $strJson );

		default:
			echo 'Please enter a valid URL';
	}
});
