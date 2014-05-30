<?php
// Include the required files
require_once( 'Freenom.class.php' );

// Init the class
$freenom = new FreenomAPI\Freenom();

// Send the request
$freenom->ping();
?>