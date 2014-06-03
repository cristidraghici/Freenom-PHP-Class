# Freenom PHP Class

This is a PHP wrapper class for the [Freenom](http://www.freenom.com) API.

More information about it can be found at http://www.freenom.com/en/freenom-api.html .

## Example usage

```php
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
```

### The example above will output something like

```php
array (size=3)
  'domain' => 
    array (size=1)
      0 => 
        array (size=2)
          'status' => string 'NOT AVAILABLE' (length=13)
          'domainname' => string 'FREENOM.ML' (length=10)
  'status' => string 'OK' (length=2)
  'result' => string 'DOMAIN NOT AVAILABLE' (length=20)
```