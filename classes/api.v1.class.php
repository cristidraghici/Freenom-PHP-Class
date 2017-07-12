<?php
namespace FreenomAPIv1;

/**
* Freenom PHP Class
*
* Author: Cristi DRAGHICI <cristi@draghici.net>
* Version: 1.0 - 2014-05-30
*/

class Freenom
{
    /**
    * The API base url
    */
    const URL = 'https://api.freenom.com/v1/';
	
    /**
    * The timeout for the requests
    * @var number
    */
    private $timeout = 30;
    
    /**
    * Storage for the object errors
    * @var number
    */
    public $errors = array();
    
    /**
    * Constructor
    *
    * Checks if the cURL extension is loaded.
    */
    public function __construct()
    {
        if (!extension_loaded('curl')) { $this->err("PHP required extension - curl - not loaded.", true); }
    }
    
    /**
    * This is the list of available API actions, put in the class method list.
    * More information can be found at:
    *
    * http://www.freenom.com/en/freenom-api.html
    *
    * The order of the parameters is slightly changed. The mandatory parameters are put first, then those with a default value and last those that need not be specified.
    */
    
    ########################
    # Services
    ########################
    
    /**
    * Ping the service
    */
    public function ping()
    {
        return $this->ask('service/ping');
    }
    
    ########################
    # Domains
    ########################
    
    /**
    * Search for available domains
    */
    public function domain_search($domainname, $email=null, $password=null)
    {
        return $this->ask('domain/search', array(
            'domainname' => $domainname,
            
            'email' => $email,
            'password' => $password
        ));
    }
    
    /**
    * Register a domain
    *
    * Note:
    * forward_url and nameservers are mutual exclusive. Either the forward_url OR nameservers need to be specified. It is not possible to specify both. In case the nameserver is under the same domain, a glue record must be created for this domain. This can be done by registering Nameserver records. 
    */
    public function domain_register($domainname, $owner_id, $email, $password, $period='1Y', $forward_url='', $nameserver='', $billing_id='', $tech_id='', $admin_id='')
    {
        return $this->ask('domain/register', array(
            'domainname' => $domainname,
            'owner_id' => $owner_id,
            'email' => $email,
            'password' => $password,
            
            'email' => $email,
            'password' => $password,
            'period' => $period,
            'forward_url' => $forward_url,
            'nameserver' => $nameserver,
            'billing_id' => $billing_id,
            'tech_id' => $tech_id,
            'admin_id' => $admin_id
        ), 'post');
    }
    
    
    /**
    * Renew a domain name registration
    */
    public function domain_renew($domainname, $email, $password, $period='1Y')
    {
        return $this->ask('domain/renew', array(
            'domainname' => $domainname,
            'email' => $email,
            'password' => $password,
            
            'period' => $period
        ), 'post');
    }
    
    /**
    * Get info on the registered domain names
    */
    public function domain_getinfo($domainname, $email, $password)
    {
        return $this->ask('domain/getinfo', array(
            'domainname' => $domainname,
            'email' => $email,
            'password' => $password
        ));
    }
    
    /**
    * Modify a domain
    *
    * Note:
    * forward_url and nameservers are mutual exclusive. Either the forward_url OR nameservers need to be specified. It is not possible to specify both. In case the nameserver is under the same domain, a glue record must be created for this domain. This can be done by registering Nameserver records. 
    */
    public function dommain_modify($domainname, $email, $password, $owner_id='', $period='1Y', $forward_url='', $nameserver='', $billing_id='', $tech_id='', $admin_id='')
    {
        return $this->ask('domain/modify', array(
            'domainname' => $domainname,
            'email' => $email,
            'password' => $password,
            
            'owner_id' => $owner_id,
            'email' => $email,
            'password' => $password,
            'period' => $period,
            'forward_url' => $forward_url,
            'nameserver' => $nameserver,
            'billing_id' => $billing_id,
            'tech_id' => $tech_id,
            'admin_id' => $admin_id
        ), 'post');
    }
    
    /**
    * Register or modify a nameserver glue record
    */
    public function nameserver_register($domainname, $hostname, $ipaddress, $email, $password)
    {
        return $this->ask('nameserver/register', array(
            'domainname' => $domainname,
            'hostname' => $hostname,
            'ipaddress' => $ipaddress,
            'email' => $email,
            'password' => $password
        ), 'post');
    }
    
    /**
    * Deleting a nameserver glue record
    */
    public function nameserver_delete($domainname, $hostname, $email, $password)
    {
        return $this->ask('nameserver/delete', array(
            'domainname' => $domainname,
            'hostname' => $hostname,
            'email' => $email,
            'password' => $password
        ), 'post');
    }
    
    /**
    * Listing nameserver glue records under a domain
    */
    public function nameserver_list($domainname, $email, $password)
    {
        return $this->ask('nameserver/list', array(
            'domainname' => $domainname,
            
            'email' => $email,
            'password' => $password
        ));
    }
    
    ########################
    # Contact
    ########################
    
    /**
    * Create or modify contact
    */
    public function contact_register($contact_title, $contact_first_name, $contact_last_name, $contact_address, $contact_city, $contact_zipcode, $contact_statecode, $contact_country_code, $contact_phone, $contact_email, $email, $password, $contact_organization='', $contact_middle_name='', $contact_fax='', $contact_id='')
    {
        return $this->ask('contact/register', array(
            'contact_title' => $contact_title,
            'contact_first_name' => $contact_first_name,
            'contact_last_name' => $contact_last_name,
            'contact_address' => $contact_address,
            'contact_city' => $contact_city,
            'contact_zipcode' => $contact_zipcode,
            'contact_statecode' => $contact_statecode,
            'contact_country_code' => $contact_country_code,
            'contact_phone' => $contact_phone,
            'contact_email' => $contact_email,
            'email' => $email,
            'password' => $password,
            
            'contact_organization' => $contact_organization,
            'contact_middle_name' => $contact_middle_name,
            'contact_fax' => $contact_fax,
            'contact_id' => $contact_id
        ), 'post');
    }
    
    /**
    * Delete contact
    */
    public function contact_delete($contact_id, $email, $password)
    {
        return $this->ask('contact/delete', array(
            'contact_id' => $contact_id,
            'email' => $email,
            'password' => $password
        ), 'post');
    }
    
    /**
    * Get info on specific contacts
    */
    public function contact_getinfo($contact_id, $email, $password)
    {
        return $this->ask('contact/getinfo', array(
            'contact_id' => $contact_id,
            'email' => $email,
            'password' => $password
        ));
    }
    
    /**
    * List contacts under account
    */
    public function contact_list($email, $password)
    {
        return $this->ask('contact/list', array(
            'email' => $email,
            'password' => $password
        ));
    }
    
    ########################
    # Transfers
    ######################## 
    
    /**
    * Get price of a domain transfer
    */
    public function domain_transfer_price($domainname, $authcode, $email, $password)
    {
        return $this->ask('domain/transfer/price', array(
            'domainname' => $domainname,
            'authcode' => $authcode, 
            'email' => $email,
            'password' => $password
        ));
    }
    
    /**
    * Request a domain transfer
    */
    public function domain_transfer_request($domainname, $authcode, $owner_id, $period='1Y', $email, $password)
    {
        return $this->ask('domain/transfer/request', array(
            'domainname' => $domainname,
            'authcode' => $authcode,
            'owner_id' => $owner_id,
            'period' => $period,
            'email' => $email,
            'password' => $password
        ), 'post');
    }
    
    /**
    * Approve a domain transfer
    */
    public function domain_transfer_approve($domainname, $email, $password)
    {
        return $this->ask('domain/transfer/approve', array(
            'domainname' => $domainname,
            'email' => $email,
            'password' => $password
        ), 'post');
    }
    
    /**
    * Decline a domain transfer
    */
    public function domain_transfer_decline($domainname, $reason, $email, $password)
    {
        return $this->ask('domain/transfer/decline', array(
            'domainname' => $domainname,
            'reason' => $reason,
            'email' => $email,
            'password' => $password
        ), 'post');
    }
    
    /**
    * List current domain transfers
    */
    public function domain_transfer_list($email, $password)
    {
        return $this->ask('domain/transfer/list', array(
            'email' => $email,
            'password' => $password
        ));
    }
    
    ########################
    # Internally used functions
    ######################## 
    
    /**
    * Private method to send requests
    * 
    * @param String $url
    * @param String $data
    * @param String $method
    */
    private function ask($url, $data=array(), $method='get')
    {
        // Make the request
        $response = $this->get( Freenom::URL . $url, $data, $method);
        //$response = substr($response, strpos($response, '{'), strrpos($response, '}'));
        
        $response = @json_decode($response, true);
        
        // Add the encountered non-fatal errors to the response
        if (count($this->errors) > 0)
        {
            $response['errors'] = $this->errors;
        }
        
        return $response;
    }
    
    /**
    * Private method to help sending requests
    * 
    * @param String $url
    * @param String $data
    * @param String $method
    */
    private function get($url, $data=array(), $method='get')
    {
        $method = strtolower($method);
        
        $curl = curl_init();
        
        switch (strtolower($method))
        {
            case 'post':
                curl_setopt($curl, CURLOPT_POST, true);
                break;
            
            default:
            case 'get':
                if (count($data) > 0)
                {
                    $url = stristr($url, '?') ? $url . '&' .  http_build_query($data, '', '&') : $url . '?' .  http_build_query($data, '', '&');
                }
                $method = 'get';
                break;
        }
		
        if(!is_null($data) && $method != 'get')
		{
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Don't print the result
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/plain; charset=UTF-8" ));
        curl_setopt($curl, CURLOPT_USERAGENT,'Freenom API Class');
        
        try {
            $return = curl_exec($curl);
            $this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			
            //$this->errors['curl'] = curl_getinfo($curl);
        }
		catch(Exception $ex)
		{
            $this->errors['curl'] = array(
                'no'    => curl_errno($curl),
                'error' => curl_error($curl)
            );
            
            $return = null;
        }
		
        curl_close($curl);
		
        return $return;
    }
    
    /**
    * Error handler
    * 
    * @param String $message
    * @param String $fatal
    */
    private function err($message='Error encountered', $fatal=false)
    {
        $this->errors[] = $message;
        
        if ($fatal == true)
        {
            echo $message;
            exit;
        }
    }
}

?>