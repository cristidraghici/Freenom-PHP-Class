<?php
namespace FreenomAPI;

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
    * The Email of the User accessing the API
    * @var string
    */
    private $apiEmail;
    
    /**
    * The Password of the User accessing the API
    * @var string
    */
    private $apiPassword;
    
    /**
    * The timeout for the requests
    * @var number
    */
    private $timeout = 10;
    
    /**
    * The default request format
    * @var number
    */
    public  $requestContentType = 'xml';
    
    /**
    * Storage for the request debugging
    * @var number
    */
    public  $debugInfo = '';
    
    /**
    * Storage for the object errors
    * @var number
    */
    public $errors = array();
    
    
    /**
    * Constructor
    * 
    * @param String $apiEmail
    * @param String $apiPassword
    * @param String $apiKey
    */
    public function __construct($apiEmail='', $apiPassword='')
    {
        if (!extension_loaded('curl')) { $this->err("PHP required extension - curl - not loaded."); }
        
        $this->apiEmail = $apiEmail;
        $this->apiPassword = $apiPassword;
    }
    
    /**
    * This is the list of available API actions, put in the class method list
    * More information can be found at:
    *
    * http://www.freenom.com/en/freenom-api.html
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
    public function check($domainname)
    {
        return $this->ask('domain/search', array('domainname'=>$domainname));
    }
    
    /**
    * Register a domain
    */
    
    /**
    * Renew a domain name registration
    */
    
    /**
    * Get info on the registered domain names
    */
    
    /**
    * Modify a domain
    */
    
    /**
    * Register or modify a nameserver glue record
    */
    
    /**
    * Deleting a nameserver glue record
    */
    
    /**
    * Listing nameserver glue records under a domain
    */
    
    ########################
    # Contact
    ########################
    
    /**
    * Create or modify contact
    */
    
    /**
    * Delete contact
    */
    
    /**
    * Get info on specific contacts
    */
    
    /**
    * List contacts under account
    */
    
    ########################
    # Transfers
    ######################## 
    
    /**
    * Get price of a domain transfer
    */
    
    /**
    * Request a domain transfer
    */
    
    /**
    * Approve a domain transfer
    */
    
    /**
    * Decline a domain transfer
    */
    
    /**
    * List current domain transfers
    */
    
    
    
    /**
    * Private method to send requests
    * 
    * @param String $url
    * @param String $data
    * @param String $method
    */
    private function ask($url, $data=array(), $method='get')
    {
        if (strlen($this->apiEmail) > 0) { $data['email'] = $this->apiEmail; }
        if (strlen($this->apiPassword) > 0) { $data['password'] = $this->apiPassword; }
        
        $response = $this->get( Freenom::URL . $url, $data, $method);
        $response = substr($response, strpos($response, '{'), strrpos($response, '}'));
        
        $response = @json_decode($response, true);
        
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
            case 'delete':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            
            case 'put':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                break;
            
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
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: " . $this->type() . '; charset=UTF-8' ));
        curl_setopt($curl, CURLOPT_USERAGENT,'Freenom API Class');
        
        try {
            $return = curl_exec($curl);
            $this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			
            $this->debugInfo = curl_getinfo($curl);
        }
		catch(Exception $ex)
		{
            $this->debugInfo = array(
                'no'    => curl_errno($curl),
                'error' => curl_error($curl)
            );
            
            $return = null;
        }
		
        curl_close($curl);
        
        return $return;
    }
    
    /**
    * Helper to set the content type
    */
    private function type()
    {
        switch ($this->requestContentType)
        {
            case 'text/plain':
            case 'text':
                return 'text/plain';
                break;
            
            case 'application/xml':
            case 'xml':
                return 'application/xml';
                break;
            
            default:
            case 'application/json':
            case 'json':
                return 'application/json';
                break;
        }
        
        return false;
    }
    
    /**
    * Error handler
    * 
    * @param String $code
    * @param String $text
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