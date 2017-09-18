<?php
namespace Freenom;

require_once( __DIR__ . '/freenom.class.php');

class V1 extends Main {
    protected $blueprint;

    public function __construct($email, $password)
    {
        parent::__construct('https://api.freenom.com/v1/', $email, $password);

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
                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'domainname',
                    'user',
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
                    'owner_id' => '',
                    'user' => '',
                    'password' => '',

                    'period' => '1Y',
                    'forward_url' => '',
                    'nameserver' => '',
                    'billing_id' => '',
                    'tech_id' => '',
                    'admin_id' => ''
                ),
                'required' => array(
                    'domainname',
                    'owner_id',
                    'user',
                    'password'
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
                    'user' => '',
                    'password' => '',

                    'period' => '1Y'
                ),
                'required' => array(
                    'domainname',
                    'user',
                    'password',

                    'period'
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
                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'domainname',
                    'user',
                    'password'
                )
            ),

            /**
            * Modify a domain
            */
            'dommain_modify' => array(
                'url' => 'domain/modify',
                'method' => 'post',
                'params' => array(
                    'domainname' => '',
                    'user' => '',
                    'password' => '',

                    'owner_id' => '',
                    'user' => '',
                    'password' => '',
                    'period' => '',
                    'forward_url' => '',
                    'nameserver' => '',
                    'billing_id' => '',
                    'tech_id' => '',
                    'admin_id' => ''
                ),
                'required' => array(
                    'domainname',
                    'user',
                    'password',
                    'owner_id'
                )
            ),

            /**
            * Register or modify a nameserver glue record
            */
            'nameserver_register' => array(
                'url' => 'nameserver/register',
                'method' => 'post',
                'params' => array(
                    'domainname' => '',
                    'hostname' => '',
                    'ipaddress' => '',
                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'domainname',
                    'hostname',
                    'user',
                    'password'
                )
            ),

            /**
            * Deleting a nameserver glue record
            */
            'nameserver_delete' => array(
                'url' => 'nameserver/delete',
                'method' => 'post',
                'params' => array(
                    'domainname' => '',
                    'hostname' => '',
                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'domainname',
                    'hostname',
                    'user',
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

                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'domainname',
                    'user',
                    'password'
                )
            ),

            // Contacts

            /**
            * Create or modify contact
            */
            'contact_register' => array(
                'url' => 'contact/register',
                'method' => 'post',
                'params' => array(
                    'contact_title' => '',
                    'contact_first_name' => '',
                    'contact_last_name' => '',
                    'contact_address' => '',
                    'contact_city' => '',
                    'contact_zipcode' => '',
                    'contact_statecode' => '',
                    'contact_country_code' => '',
                    'contact_phone' => '',
                    'contact_email' => '',
                    'user' => '',
                    'password' => '',

                    'contact_organization' => '',
                    'contact_middle_name' => '',
                    'contact_fax' => '',
                    'contact_id' => ''
                ),
                'required' => array(
                    'contact_first_name',
                    'contact_last_name',
                    'user',
                    'password'
                )
            ),

            /**
            * Delete contact
            */
            'contact_delete' => array(
                'url' => 'contact/delete',
                'method' => 'post',
                'params' => array(
                    'contact_id' => '',
                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'contact_id',
                    'user',
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
                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'contact_id',
                    'user',
                    'password'
                )
            ),

            /**
            * List contacts under account
            */
            'contact_list' => array(
                'url' => 'contact/list',
                'method' => 'post',
                'params' => array(
                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'user',
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
                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'domainname',
                    'authcode',
                    'user',
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
                    'owner_id' => '',
                    'period' => '',
                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'domainname',
                    'authcode',
                    'owner_id',
                    'period',
                    'user',
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
                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'domainname',
                    'user',
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
                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'domainname',
                    'reason',
                    'user',
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
                    'user' => '',
                    'password' => ''
                ),
                'required' => array(
                    'user',
                    'password'
                )
            )
        );
    }
}

?>
