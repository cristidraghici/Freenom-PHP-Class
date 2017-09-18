<?php
// Show errors if needed
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Require the corresponding blueprint and wrapper
require_once(__DIR__ . '/../classes/freenom.v1.class.php');
require_once(__DIR__ . '/../settings.php');

// Create the object and use it
$freenom = new \Freenom\V1($config['email'], $config['password']);

// Search for a domain
$output = $freenom->domain_search(array(
    'domainname' => 'starfish.ml',

    // Optional parameters used for debug purposes
    '__FILE__' => __FILE__,
    '__LINE__' => __LINE__
));

// Get the output
print_r($output);

// Expected output

/*
Array
(
    [domain] => Array
        (
            [0] => Array
                (
                    [status] => NOT AVAILABLE
                    [domainname] => STARFISH.ML
                )

        )

    [status] => OK
    [result] => DOMAIN NOT AVAILABLE
)
*/
