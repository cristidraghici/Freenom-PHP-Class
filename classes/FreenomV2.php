<?php
namespace Freenom;

class FreenomV2 extends FreenomMain
{
    protected $blueprint;

    public function __construct($email, $password, $test_mode=0)
    {
        parent::__construct('https://api.freenom.com/v2/', $email, $password);

        // The blueprint for the api
        $this->blueprint = array(
            /**
            * Ping the service
            */
            'ping' => array(
                'url' => 'service/ping',
                'method' => 'get',
                'params' => array(),
                'required' => array()
            ),

            // Domains

            /**
            * Search for available domains
            */
            'domain_search' => array(
                'url' => 'domain/search',
                'method' => 'get',
                'params' => array(
                    'domainname' => '',
                    'domaintype' => 'FREE', // FREE or PAID
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'domaintype',
                    'email',
                    'password'
                )
            ),

            /**
            * Register a domain
            */
            'domain_register' => array(
                'url' => 'domain/register',
                'method' => 'post',
                'params' => array(
                    'domainname' => '',
                    'period' => '12M', // Supported periods for Paid domains: 1Y, 2Y, 3Y, 4Y, 5Y, 9Y and 10Y. Free domains are registered in number of months. Supported periods for Free domains: 1M - 12M
                    'forward_url' => '',
                    'forward_mode' => 'cloak', // Can be cloak or 301_redirect. cloak is default.
                    'nameserver' => '',

                    'owner_id' => '',
                    'billing_id' => '',
                    'tech_id' => '',
                    'admin_id' => '',

                    'domaintype' => 'FREE', // The type of the domain: PAID or FREE

                    'idshield' => 'enabled', // Identity protection parameter, possible values : enabled or disabled
                    'autorenew' => 'enabled', // Autorenewal setting for this domain. Possible values: enabled or disabled.

                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'owner_id',
                    'email',
                    'password',
                    'domaintype'
                )
            ),

            /**
            * Renew a domain name registration
            */
            'domain_renew' => array(
                'url' => 'domain/renew',
                'method' => 'post',
                'params' => array(
                    'domainname' => '',
                    'period' => '12M', // The period of registration. If not given it will default to 1Y for paid domains and will default to 3M for free domains

                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'email',
                    'password'
                )
            ),

            /**
            * Get info on the registered domain names
            */
            'domain_getinfo' => array(
                'url' => 'domain/getinfo',
                'method' => 'get',
                'params' => array(
                    'domainname' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'email',
                    'password'
                )
            ),

            /**
            * Modify a domain
            */
            'domain_modify' => array(
                'url' => 'domain/modify',
                'method' => 'put',
                'params' => array(
                    'domainname' => '', //	The name of the domain	Yes	No
                    'forward_url' => '', //	The URL the domain name should forward to	No*	No
                    'forward_mode' => 'cloak', //	The type of forward. Can be cloak or 301_redirect. cloak is default.	No	No
                    'nameserver' => '', //	Nameserver to use. Minimally 2 are needed	No*	Yes
                    'owner_id' => '', //	Contact ID of domain owner	No	No
                    'admin_id' => '', //	Contact ID of administrative contact	No	No
                    'tech_id' => '', //	Contact ID of technical contact	No	No
                    'billing_id' => '', //	Contact ID of billing contact	No	No

                    'email' => '', //	E-mail address used for authentication	Yes	No
                    'password' => '', //	Password used for authentication	Yes	No

                    'idshield' => 'enabled', //	Identity protection parameter, possible values : enabled or disabled	No	No
                    'autorenew' => 'enabled', //	Autorenewal setting for this domain. Possible values: enabled or disabled.	No	No

                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'email',
                    'password'
                )
            ),

            /**
            * Get info on the registered domain names
            */
            'domain_delete' => array(
                'url' => 'domain/delete',
                'method' => 'delete',
                'params' => array(
                    'domainname' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'email',
                    'password'
                )
            ),

            /**
            * Restore a domain to the account
            */
            'domain_restore' => array(
                'url' => 'domain/restore',
                'method' => 'post',
                'params' => array(
                    'domainname' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'email',
                    'password'
                )
            ),

            /**
            * Upgrade a domain
            */
            'domain_upgrade' => array(
                'url' => 'domain/restore',
                'method' => 'post',
                'params' => array(
                    'domainname' => '', //	The name of the domain	Yes	No
                    'email' => '', //	E-mail address used for authentication	Yes	No
                    'password' => '', //	Password used for authentication	Yes	No
                    'owner_id' => '', //	Contact ID of owner contact	No**	No
                    'billing_id' => '', //	Contact ID of billing contact	No	No
                    'admin_id' => '', //	Contact ID of admin contact	No	No
                    'tech_id' => '', //	Contact ID of technical contact	No	No
                    'idshield' => 'enabled', //	Identity protection parameter, possible values : enabled or disabled	No**	No
                    'period' => '', //	Number of years to add to domain expiration, after the domain has been upgraded.	Yes	Yes

                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'email',
                    'password',
                    'period'
                )
            ),

            /**
            * List domains
            */
            'domain_list' => array(
                'url' => 'domain/list',
                'method' => 'get',
                'params' => array(
                    'pagenr' => '', //		Page number of results. Defaults to 1	No	No
                    'results_per_page' => '', //		Number of results per page. Defaults to 25	No	No
                    'email' => '', //		E-mail address used for authentication	No	No
                    'password' => '', //		Password used for authentication	No	No

                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'email',
                    'password'
                )
            ),

            // Nameservers

            /**
            * Register or modify a nameserver glue record
            */
            'nameserver_register' => array(
                'url' => 'nameserver/register',
                'method' => 'put',
                'params' => array(
                    'domainname' => '',
                    'hostname' => '',
                    'ipaddress' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'hostname',
                    'ipaddress',
                    'email',
                    'password'
                )
            ),

            /**
            * Deleting a nameserver glue record
            */
            'nameserver_delete' => array(
                'url' => 'nameserver/delete',
                'method' => 'delete',
                'params' => array(
                    'domainname' => '',
                    'hostname' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'hostname',
                    'email',
                    'password'
                )
            ),

            /**
            * Listing nameserver glue records under a domain
            */
            'nameserver_list' => array(
                'url' => 'nameserver/list',
                'method' => 'get',
                'params' => array(
                    'domainname' => '',

                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'email',
                    'password'
                )
            ),

            // Contacts

            /**
            * Create or modify contact
            */
            'contact_register' => array(
                'url' => 'contact/register',
                'method' => 'put',
                'params' => array(
                    'contact_organization' => '', //	Organization name of contact	No	No
                    'contact_title' => '', //	Title of the contact	No	No
                    'contact_firstname' => '', //	First name of contact	Yes	No
                    'contact_middlename' => '', //	Middle name of contact	No	No
                    'contact_lastname' => '', //	Last name of contact	Yes	No
                    'contact_address' => '', //	Address of the contact	Yes	No
                    'contact_city' => '', //	City of the contact	Yes	No
                    'contact_zipcode' => '', //	Zipcode of the contact	Yes	No
                    'contact_statecode' => '', //	ISO-3166 code for state	Yes	No
                    'contact_countrycode' => '', //	ISO-3166 code for country	Yes	No
                    'contact_phone' => '', //	Phone number of contact (international format)	Yes	No
                    'contact_fax' => '', //	Fax number of contact (international format)	No	No
                    'contact_email' => '', //	Email address of contact	Yes	No
                    'contact_id' => '', //	ID of existing contact	No	No

                    'email' => '', //	E-mail address used for authentication	Yes	No
                    'password' => '', //	Password used for authentication	Yes	No

                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'contact_firstname',
                    'contact_lastname',
                    'contact_address',
                    'contact_city',
                    'contact_zipcode',
                    'contact_statecode',
                    'contact_phone',
                    'contact_email',
                    'email',
                    'password'
                )
            ),

            /**
            * Delete contact
            */
            'contact_delete' => array(
                'url' => 'contact/delete',
                'method' => 'delete',
                'params' => array(
                    'contact_id' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'contact_id',
                    'email',
                    'password'
                )
            ),

            /**
            * Get info on specific contacts
            */
            'contact_getinfo' => array(
                'url' => 'contact/getinfo',
                'method' => 'get',
                'params' => array(
                    'contact_id' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'contact_id',
                    'email',
                    'password'
                )
            ),

            /**
            * List contacts under account
            */
            'contact_list' => array(
                'url' => 'contact/list',
                'method' => 'get',
                'params' => array(
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'email',
                    'password'
                )
            ),

            // Transfers

            /**
            * Get price of a domain transfer
            */
            'domain_transfer_price' => array(
                'url' => 'domain/transfer/price',
                'method' => 'get',
                'params' => array(
                    'domainname' => '',
                    'authcode' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'authcode',
                    'email',
                    'password'
                )
            ),

            /**
            * Request a domain transfer
            */
            'domain_transfer_request' => array(
                'url' => 'domain/transfer/request',
                'method' => 'post',
                'params' => array(
                    'domainname' => '',
                    'authcode' => '',
                    'period' => '',
                    'owner_id' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'authcode',
                    'period',
                    'owner_id',
                    'email',
                    'password'
                )
            ),

            /**
            * Approve a domain transfer
            */
            'domain_transfer_approve' => array(
                'url' => 'domain/transfer/approve',
                'method' => 'post',
                'params' => array(
                    'domainname' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'email',
                    'password'
                )
            ),

            /**
            * Decline a domain transfer
            */
            'domain_transfer_decline' => array(
                'url' => 'domain/transfer/decline',
                'method' => 'post',
                'params' => array(
                    'domainname' => '',
                    'reason' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'domainname',
                    'reason',
                    'email',
                    'password'
                )
            ),

            /**
            * List current domain transfers
            */
            'domain_transfer_list' => array(
                'url' => 'domain/transfer/list',
                'method' => 'get',
                'params' => array(
                    'email' => '',
                    'password' => '',
                    'test_mode' => $test_mode
                ),
                'required' => array(
                    'email',
                    'password'
                )
            )
        );
    }
}
