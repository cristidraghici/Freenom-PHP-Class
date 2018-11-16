<?php
namespace Freenom;

abstract class FreenomMain
{
    /**
     * The API base url
     *
     * @var string
     */
    private $api = '';

    /**
     * The timeout for the requests
     * @var integer
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
     * @param string $api
     * @param string $email
     * @param string $password
     *
     * @return void
     *
     * Checks if the cURL extension is loaded, sets basic parameters.
    */
    public function __construct(string $api, string $email, string $password)
    {
        if (!extension_loaded('curl')) {
            throw new \InvalidArgumentException("PHP required extension - curl - not loaded.", __FILE__, __LINE__);
        }

        // Set the minimal configuration
        $this->api = $api;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * It's about the magic method: Caller
     *
     * @param string $name
     * @param array $arguments
     *
     * @return array
     *
     * Function used to call a certain method in the blueprint
     */
    public function __call(string $name, array $arguments)
    {
        $params = $arguments[0] ?? [];

        $file = $params['__FILE__'] ?? __FILE__;
        unset($params['__FILE__']);

        $line = $params['__LINE__'] ?? __LINE__;
        unset($params['__LINE__']);

        if (empty($this->blueprint[$name])) {
            throw new \InvalidArgumentException("The requested method ('" . $name . "') does not exist.", $file, $line);
        }

        $info = $this->blueprint[$name];

        if (array_key_exists('email', $info['params']) && empty($params['email'])) {
            $params['email'] = $this->email;
        }
        if (array_key_exists('user', $info['params']) && empty($params['user'])) {
            $params['user'] = $this->email;
        }
        if (array_key_exists('password', $info['params']) && empty($params['password'])) {
            $params['password'] = $this->password;
        }

        foreach ($info['params'] as $key => $value) {
            if (empty($params[$key])) {
                $params[$key] = $value;
            }
        }

        $err = [];

        foreach ($info['required'] as $key => $value) {
            if (empty($params[$value])) {
                $err[] = $value;
            }
        }

        if (count($err) > 0) {
            throw new \InvalidArgumentException("Parameters required for '" . $name . "': " . implode(", ", $err));
        }

        return $this->ask($info['url'], $params, $info['method']);
    }

    /**
     * Private method to send requests
     *
     * @param string $url
     * @param array $data
     * @param string $method
     *
     * @return array
     */
    private function ask(string $url, array $data = [], string $method = 'get')
    {
        $response = $this->fetch($this->api . $url, $data, $method);
        $response = @json_decode($response, true);

        return $response;
    }

    /**
     * Private method to help sending requests
     *
     * @param string $url
     * @param string $data
     * @param string $method
     *
     * @return string
    */
    private function fetch(string $url, array $data = [], string $method = 'get')
    {
        try {
            $curl = curl_init();

            $method = strtolower($method);

            $data['method'] = strtoupper($method);

            switch ($method) {
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
                    curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
                    curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                    break;

                default:
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                    $url .= "?".http_build_query($data);
                    break;
            }

            $curl = $this->buildCurlOptions($curl, $url, $data);

            $return = curl_exec($curl);
            curl_close($curl);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $return;
    }

    /**
     * It's about building other cURL options for request work
     *
     * @param resource $curl
     * @param string $url
     *
     * @return resource
     */
    private function buildCurlOptions($curl, string $url)
    {
        $headers = [
            "Accept: application/x-www-form-urlencoded",
            "Content-Type: application/x-www-form-urlencoded",
        ];

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36');

        return $curl;
    }
}
