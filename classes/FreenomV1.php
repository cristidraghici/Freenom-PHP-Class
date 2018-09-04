<?php
namespace Freenom;

class FreenomV1 extends FreenomMain
{
    protected $blueprint;

    public function __construct($email, $password, $testMode = 0)
    {
        parent::__construct('https://api.freenom.com/v1/', $email, $password);

        // The blueprint for the api
        $this->blueprint = [
            /**
            * Ping the service
            */
            'ping' => [
                'url' => 'service/ping',
                'method' => 'get',
                'params' => [],
                'required' => [],
            ],

            // Domains

            /**
            * Search for available domains
            */
            'domainSearch' => [
                'url' => 'domain/search',
                'method' => 'get',
                'params' => [
                    'domainname' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                ],
            ],

            /**
            * Register a domain
            */
            'domainRegister' => [
                'url' => 'domain/register',
                'method' => 'post',
                'params' => [
                    'domainname' => '', //  The name of the domain  Yes No
                    'period' => '', //  The period of registration. Defaults to 1Y if not given No  No
                    'forward_url' => '', // The URL the domain name should forward to   No* No
                    'nameserver' => '', //  Nameserver to use. A minimum of 2 nameservers is required   No* Yes
                    'owner_id' => '', //    Contact ID of domain owner  Yes No
                    'billing_id' => '', //  Contact ID of billing contact   No  No
                    'tech_id' => '', // Contact ID of technical contact No  No
                    'admin_id' => '', //    Contact ID of admin contact No  No
                    'email' => '', //   E-mail address used for authentication  Yes No
                    'password' => '', //    Password used for authentication    Yes No
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'owner_id',
                    'email',
                    'password',
                ],
            ],

            /**
            * Renew a domain name registration
            */
            'domain_renew' => [
                'url' => 'domain/renew',
                'method' => 'post',
                'params' => [
                    'domainname' => '',
                    'period' => '1Y',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                    'period',
                ],
            ],

            /**
            * Get info on the registered domain names
            */
            'domain_getinfo' => [
                'url' => 'domain/getinfo',
                'method' => 'get',
                'params' => [
                    'domainname' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                ],
            ],

            /**
            * Modify a domain
            */
            'dommain_modify' => [
                'url' => 'domain/modify',
                'method' => 'post',
                'params' => [
                    'domainname' => '', //  The name of the domain  Yes No
                    'forward_url' => '', // The URL the domain name should forward to   No* No
                    'nameserver' => '', //  Nameserver to use. Minimally 2 are needed   No* Yes
                    'owner_id' => '', //    Contact ID of domain owner  No  No
                    'admin_id' => '', //    Contact ID of administrative contact    No  No
                    'tech_id' => '', // Contact ID of technical contact No  No
                    'billing_id' => '', //  Contact ID of billing contact   No  No
                    'email' => '', //   E-mail address used for authentication  Yes No
                    'password' => '', //    Password used for authentication    Yes No
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                ],
            ],

            /**
            * Register or modify a nameserver glue record
            */
            'nameserver_register' => [
                'url' => 'nameserver/register',
                'method' => 'post',
                'params' => [
                    'domainname' => '',
                    'hostname' => '',
                    'ipaddress' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'hostname',
                    'ipaddress',
                    'email',
                    'password',
                ]
            ],

            /**
            * Deleting a nameserver glue record
            */
            'nameserver_delete' => [
                'url' => 'nameserver/delete',
                'method' => 'post',
                'params' => [
                    'domainname' => '',
                    'hostname' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'hostname',
                    'email',
                    'password',
                ],
            ],

            /**
            * Listing nameserver glue records under a domain
            */
            'nameserver_list' => [
                'url' => 'nameserver/list',
                'method' => 'get',
                'params' => [
                    'domainname' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                ],
            ],

            // Contacts

            /**
            * Create or modify contact
            */
            'contact_register' => [
                'url' => 'contact/register',
                'method' => 'post',
                'params' => [
                    'contact_organization' => '', //    Organization name of contact    No  No
                    'contact_title' => '', //   Title of the contact    Yes No
                    'contact_firstname' => '', //   First name of contact   Yes No
                    'contact_middlename' => '', //  Middle name of contact  No  No
                    'contact_lastname' => '', //    Last name of contact    Yes No
                    'contact_address' => '', // Address of the contact  Yes No
                    'contact_city' => '', //    City of the contact Yes No
                    'contact_zipcode' => '', // Zipcode of the contact  Yes No
                    'contact_statecode' => '', //   ISO-3166 code for state Yes No
                    'contact_countrycode' => '', // ISO-3166 code for country   Yes No
                    'contact_phone' => '', //   Phone number of contact (international format)  Yes No
                    'contact_fax' => '', // Fax number of contact (international format)    No  No
                    'contact_email' => '', //   Email address of contact    Yes No
                    'contact_id' => '', //  ID of existing contact  No  No
                    'email' => '', //   E-mail address used for authentication  Yes No
                    'password' => '', //    Password used for authentication    Yes No
                    'test_mode' => '', // => $testMode
                ],
                'required' => [
                    'contact_title',
                    'contact_firstname',
                    'contact_lastname',
                    'contact_address',
                    'contact_city',
                    'contact_zipcode',
                    'contact_statecode',
                    'contact_phone',
                    'contact_email',
                    'email',
                    'password',
                ],
            ],

            /**
            * Delete contact
            */
            'contact_delete' => [
                'url' => 'contact/delete',
                'method' => 'post',
                'params' => [
                    'contact_id' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'contact_id',
                    'email',
                    'password',
                ],
            ],

            /**
            * Get info on specific contacts
            */
            'contact_getinfo' => [
                'url' => 'contact/getinfo',
                'method' => 'get',
                'params' => [
                    'contact_id' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'contact_id',
                    'email',
                    'password',
                ],
            ],

            /**
            * List contacts under account
            */
            'contact_list' => [
                'url' => 'contact/list',
                'method' => 'get',
                'params' => [
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'email',
                    'password',
                ],
            ],

            // Transfers

            /**
            * Get price of a domain transfer
            */
            'domain_transfer_price' => [
                'url' => 'domain/transfer/price',
                'method' => 'get',
                'params' => [
                    'domainname' => '',
                    'authcode' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'authcode',
                    'email',
                    'password',
                ],
            ],

            /**
            * Request a domain transfer
            */
            'domain_transfer_request' => [
                'url' => 'domain/transfer/request',
                'method' => 'post',
                'params' => [
                    'domainname' => '',
                    'authcode' => '',
                    'period' => '',
                    'owner_id' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'authcode',
                    'period',
                    'owner_id',
                    'email',
                    'password',
                ],
            ],

            /**
            * Approve a domain transfer
            */
            'domain_transfer_approve' => [
                'url' => 'domain/transfer/approve',
                'method' => 'post',
                'params' => [
                    'domainname' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                ],
            ],

            /**
            * Decline a domain transfer
            */
            'domain_transfer_decline' => [
                'url' => 'domain/transfer/decline',
                'method' => 'post',
                'params' => [
                    'domainname' => '',
                    'reason' => '',
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'reason',
                    'email',
                    'password',
                ],
            ],

            /**
            * List current domain transfers
            */
            'domain_transfer_list' => [
                'url' => 'domain/transfer/list',
                'method' => 'post',
                'params' => [
                    'email' => '',
                    'password' => '',
                    'test_mode' => $testMode,
                ],
                'required' => [
                    'email',
                    'password',
                ],
            ],
        ];
    }
}
