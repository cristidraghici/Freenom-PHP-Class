# Freenom PHP Class

This is a PHP wrapper class for the [Freenom](http://www.freenom.com) API.
It returns information in the JSON format.

More information about it can be found on the [Freenom API Page](http://www.freenom.com/en/freenom-api.html).

For information about the methods, please check `./classes/FreenomV*.php` files.

**!!!** Apparently, free domains cannot be registered and using the API.
**!!!** It's only for the reseller/paid account.

## Examples

Usage examples can be found in `./examples`. Please remember to edit `settings.example.php` with your credentials and save it as `settings.php`

## API version attention

According to the [official API doc](https://www.freenom.com/en/freenom-api.html), the API version 1 seems to be deprecated.

Using API version 2. And the Freenom API v1 class will be removed.

## TODO

- add more validation to parameters than just required or not;
- add a testing component;
- improve code structure;
- add Composer compatibility;
- add XML support.
