<?php
namespace Freenom;

class FreenomMain
{
    /**
    * The API base url
    */
    private $api = '';

    /**
    * The timeout for the requests
    * @var number
    */
    private $timeout = 30;

    /**
    * Email to connect to the account
    * @var string
    */
    private $email = '';

    /**
    * Password to connect to the account
    * @var string
    */
    private $password = '';

    /**
    * Constructor
    *
    * Checks if the cURL extension is loaded, sets basic parameters.
    */
    public function __construct($api, $email, $password)
    {
        if (!extension_loaded('curl')) {
            $this->err("PHP required extension - curl - not loaded.", __FILE__, __LINE__);
        }

        // Set the minimal configuration
        $this->api = $api;
        $this->email = $email;
        $this->password = $password;
    }

    /**
    * Caller
    *
    * Function used to call a certain method in the blueprint
    */
    public function __call($name, $arguments)
    {
        // Get the parameters
        $params = isset($arguments[0]) ? $arguments[0] : array();

        if (gettype($params) !== 'array') {
            return $this->err("Error on method '" . $name . "': please use an array to contain the parameters.");
        }

        $file = isset($params['__FILE__']) ? $params['__FILE__'] : __FILE__;
        unset($params['__FILE__']);
        $line = isset($params['__LINE__']) ? $params['__LINE__'] : __LINE__;
        unset($params['__LINE__']);

        // Check the existence of the method
        if (!isset($this->blueprint[$name])) {
            return $this->err("The requested method ('" . $name . "') does not exist.", $file, $line);
        }

        // Get the info from the blueprint
        $info = $this->blueprint[$name];

        // add email and password, if needed
        if (array_key_exists('email', $info['params']) && !isset($params['email'])) {
            $params['email'] = $this->email;
        }
        if (array_key_exists('user', $info['params']) && !isset($params['user'])) {
            $params['user'] = $this->email;
        }
        if (array_key_exists('password', $info['params']) && !isset($params['password'])) {
            $params['password'] = $this->password;
        }

        // add the default values
        foreach ($info['params'] as $key=>$value) {
            if (!isset($params[$key])) {
                $params[$key] = $value;
            }
        }

        // Validate parameters' existence
        $err = array();

        foreach ($info['required'] as $key=>$value) {
            if (!isset($params[$value])) {
                $err[] = $value;
            }
        }

        if (count($err) > 0) {
            return $this->err("Parameters required for '" . $name . "': " . implode(", ", $err), $file, $line);
        }

        // Execute the request
        return $this->ask($info['url'], $params, $info['method']);
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
        $response = $this->fetch($this->api . $url, $data, $method);
        $response = @json_decode($response, true);

        // Return the response
        return $response;
    }

    /**
    * Private method to help sending requests
    *
    * @param String $url
    * @param String $data
    * @param String $method
    */
    private function fetch($url, $data=array(), $method='get')
    {
        try {
            $curl = curl_init();
            $method = strtolower($method);

            // The authorization
            if (isset($data['email']) && isset($data['password'])) {
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($curl, CURLOPT_USERPWD, $data['email'] . ":" .  $data['password']);
            }

            // Set the method in the parameters
            $data['method'] = strtoupper($method);

            // The request
            switch (strtolower($method)) {
                case 'put':
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                    break;

                case 'delete':
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                    break;

                case 'post':
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                      curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
                      curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
                    break;

                default:
                case 'get':
                    if (count($data) > 0) {
                        $query = http_build_query($data, '', '&');
                        $url = stristr($url, '?') ? $url . '&' . $query  : $url . '?' .  $query;
                    }
                    break;
            }

            // headers
            $headers = array("Accept: application/x-www-form-urlencoded", "Content-Type: application/x-www-form-urlencoded");

            // Other options
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Don't print the result
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
            curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            // curl_setopt($curl, CURLOPT_USERAGENT, 'Freenom API Wrapper Object');
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36');

            $return = curl_exec($curl);
            curl_close($curl);
        } catch (Exception $ex) {
            return $this->err(curl_error($curl), curl_errno($curl), __FILE__, __LINE__);
        }

        return $return;
    }

    /**
    * Error handler
    *
    * @param String $message
    * @param Int $code
    * @param String $file
    * @param Int $line
    */
    private function err($message='Error encountered', $file=null, $line=null)
    {
        if (!!$file && !!$line) {
            $message .= ' [[ ' . $file . ' #' . $line . ']]';
        }

        // Throw the exception
        echo $message;
        exit;
    }
}
