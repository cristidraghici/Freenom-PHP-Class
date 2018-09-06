<?php
namespace Freenom;

/**
 * It's about Freenom API V2 class
 */
class FreenomV2 extends FreenomMain
{
    /**
     * @var array
     */
    protected $blueprint;

    /**
     * It's the constructor
     *
     * @param string $email
     * @param string $password
     *
     * @return void
     */
    public function __construct(string $email, string $password, int $testMode = 0)
    {
        parent::__construct('https://api.freenom.com/v2/', $email, $password);

        $this->blueprint = [
            'ping' => [
                'url' => 'service/ping',
                'method' => 'get',
                'params' => [],
                'required' => [],
            ],

            'domainSearch' => [
                'url' => 'domain/search',
                'method' => 'get',
                'params' => [
                    'domainname' => '',
                    'domaintype' => 'FREE', // FREE or PAID
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'domaintype',
                    'email',
                    'password',
                ],
            ],

            'domainRegister' => [
                'url' => 'domain/register',
                'method' => 'post',
                'params' => [
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
                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'owner_id',
                    'email',
                    'password',
                    'domaintype',
                ],
            ],

            'domainRenew' => [
                'url' => 'domain/renew',
                'method' => 'post',
                'params' => [
                    'domainname' => '',
                    'period' => '12M', // The period of registration. If not given it will default to 1Y for paid domains and will default to 3M for free domains

                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                ],
            ],

            'domainGetinfo' => [
                'url' => 'domain/getinfo',
                'method' => 'get',
                'params' => [
                    'domainname' => '',
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                ],
            ],

            'domainModify' => [
                'url' => 'domain/modify',
                'method' => 'put',
                'params' => [
                    'domainname' => '', //  The name of the domain  Yes No
                    'forward_url' => '', // The URL the domain name should forward to   No* No
                    'forward_mode' => 'cloak', //   The type of forward. Can be cloak or 301_redirect. cloak is default.    No  No
                    'nameserver' => '', //  Nameserver to use. Minimally 2 are needed   No* Yes
                    'owner_id' => '', //    Contact ID of domain owner  No  No
                    'admin_id' => '', //    Contact ID of administrative contact    No  No
                    'tech_id' => '', // Contact ID of technical contact No  No
                    'billing_id' => '', //  Contact ID of billing contact   No  No

                    'email' => '', //   E-mail address used for authentication  Yes No
                    'password' => '', //    Password used for authentication    Yes No

                    'idshield' => 'enabled', // Identity protection parameter, possible values : enabled or disabled    No  No
                    'autorenew' => 'enabled', //    Autorenewal setting for this domain. Possible values: enabled or disabled.  No  No

                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                ],
            ],

            'domainDelete' => [
                'url' => 'domain/delete',
                'method' => 'delete',
                'params' => [
                    'domainname' => '',
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                ],
            ],

            'domainRestore' => [
                'url' => 'domain/restore',
                'method' => 'post',
                'params' => [
                    'domainname' => '',
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                ],
            ],

            'domainUpgrade' => [
                'url' => 'domain/restore',
                'method' => 'post',
                'params' => [
                    'domainname' => '', //  The name of the domain  Yes No
                    'email' => '', //   E-mail address used for authentication  Yes No
                    'password' => '', //    Password used for authentication    Yes No
                    'owner_id' => '', //    Contact ID of owner contact No**    No
                    'billing_id' => '', //  Contact ID of billing contact   No  No
                    'admin_id' => '', //    Contact ID of admin contact No  No
                    'tech_id' => '', // Contact ID of technical contact No  No
                    'idshield' => 'enabled', // Identity protection parameter, possible values : enabled or disabled    No**    No
                    'period' => '', //  Number of years to add to domain expiration, after the domain has been upgraded.    Yes Yes
                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                    'period',
                ],
            ],

            'domainList' => [
                'url' => 'domain/list',
                'method' => 'get',
                'params' => [
                    'pagenr' => '', //      Page number of results. Defaults to 1   No  No
                    'results_per_page' => '', //        Number of results per page. Defaults to 25  No  No
                    'email' => '', //       E-mail address used for authentication  No  No
                    'password' => '', //        Password used for authentication    No  No
                    'testMode' => $testMode,
                ],
                'required' => [
                    'email',
                    'password',
                ],
            ],

            'nameserverRegister' => [
                'url' => 'nameserver/register',
                'method' => 'put',
                'params' => [
                    'domainname' => '',
                    'hostname' => '',
                    'ipaddress' => '',
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'hostname',
                    'ipaddress',
                    'email',
                    'password',
                ],
            ],

            'nameserverDelete' => [
                'url' => 'nameserver/delete',
                'method' => 'delete',
                'params' => [
                    'domainname' => '',
                    'hostname' => '',
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'hostname',
                    'email',
                    'password',
                ],
            ],

            'nameserverList' => [
                'url' => 'nameserver/list',
                'method' => 'get',
                'params' => [
                    'domainname' => '',

                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                ],
            ],

            'contactRegister' => [
                'url' => 'contact/register',
                'method' => 'put',
                'params' => [
                    'contact_organization' => '', //    Organization name of contact    No  No
                    'contact_title' => '', //   Title of the contact    No  No
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
                    'testMode' => $testMode,
                ],
                'required' => [
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

            'contactDelete' => [
                'url' => 'contact/delete',
                'method' => 'delete',
                'params' => [
                    'contact_id' => '',
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'contact_id',
                    'email',
                    'password',
                ],
            ],

            'contactGetinfo' => [
                'url' => 'contact/getinfo',
                'method' => 'get',
                'params' => [
                    'contact_id' => '',
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'contact_id',
                    'email',
                    'password',
                ],
            ],

            'contactList' => [
                'url' => 'contact/list',
                'method' => 'get',
                'params' => [
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'email',
                    'password',
                ],
            ],

            'domainTransferPrice' => [
                'url' => 'domain/transfer/price',
                'method' => 'get',
                'params' => [
                    'domainname' => '',
                    'authcode' => '',
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'authcode',
                    'email',
                    'password',
                ],
            ],

            'domainTransferRequest' => [
                'url' => 'domain/transfer/request',
                'method' => 'post',
                'params' => [
                    'domainname' => '',
                    'authcode' => '',
                    'period' => '',
                    'owner_id' => '',
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
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

            'domainTransferApprove' => [
                'url' => 'domain/transfer/approve',
                'method' => 'post',
                'params' => [
                    'domainname' => '',
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'email',
                    'password',
                ],
            ],

            'domainTransferDecline' => [
                'url' => 'domain/transfer/decline',
                'method' => 'post',
                'params' => [
                    'domainname' => '',
                    'reason' => '',
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'domainname',
                    'reason',
                    'email',
                    'password',
                ],
            ],

            'domainTransferList' => [
                'url' => 'domain/transfer/list',
                'method' => 'get',
                'params' => [
                    'email' => '',
                    'password' => '',
                    'testMode' => $testMode,
                ],
                'required' => [
                    'email',
                    'password',
                ],
            ],
        ];
    }
}
