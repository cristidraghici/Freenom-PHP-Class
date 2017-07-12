<?php
// Include the required files
require_once( '../classes/api.v1.class.php' );

// Init the class
$freenom = new FreenomAPIv1\Freenom();

// Send the request
$result = $freenom->domain_search('freenom.ml');

// Show the output
if ($result != null)
{
    var_dump($result);
}
else
{
    var_dump($freenom->errors);
}

// Expected output
/*
array(3) {
  ["domain"]=>
  array(1) {
    [0]=>
    array(2) {
      ["status"]=>
      string(13) "NOT AVAILABLE"
      ["domainname"]=>
      string(10) "FREENOM.ML"
    }
  }
  ["status"]=>
  string(2) "OK"
  ["result"]=>
  string(20) "DOMAIN NOT AVAILABLE"
}
*/
?>