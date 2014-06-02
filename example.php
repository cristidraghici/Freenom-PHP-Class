<?php
// Include the required files
require_once( 'Freenom.class.php' );

// Init the class
$freenom = new FreenomAPI\Freenom();

// Send the request
$result = $freenom->domain_search('freenom.ml');

// Show the output
var_dump($result);
?>