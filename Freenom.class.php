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
    * Constructor
    * 
    * @param String $apiEmail
    * @param String $apiPassword
    * @param String $apiKey
    */
    public function __construct($apiEmail='', $apiPassword='')
    {
        if (!extension_loaded('curl')) { $this->err(400, "PHP required extension - curl - not loaded."); }
        
        $this->apiEmail = $apiEmail;
        $this->apiPassword = $apiPassword;
    }
    
    public function ping()
    {
        echo $this->get('https://api.freenom.com/v1/service/ping');
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
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Don't print the result
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: " . $this->type() . '; charset=UTF-8' ));
        curl_setopt($curl,CURLOPT_USERAGENT,'Freenom API Class');
        
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
                $method = 'get';
                break;
        }
        
        if(!is_null($data) && $method != 'get')
		{
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        
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
        $return = substr($return, strpos($return, '{'), strrpos($return, '}'));
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
    private function err($code=401, $message='Error encountered')
    {
        $code = (string) $code;
        $message = (string) $message;
        
        // set the response code
        header(
            "{$_SERVER['SERVER_PROTOCOL']} {$code} {$message}",
            true,
            (int) $code
        );
        
        echo $message;
        exit;
    }
}

?>