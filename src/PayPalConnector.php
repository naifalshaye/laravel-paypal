<?php

namespace Naif\PayPal;

use Exception;

class PayPalConnector
{
    /**
     * API Version
     */
    const VERSION = 47.0;

    /**
     * List of valid API environments
     * @var array
     */
    private $allowedEnvs = array(
        'beta-sandbox',
        'live',
        'sandbox'
    );

    /**
     * Config storage from constructor
     * @var array
     */
    private $config = array();

    /**
     * URL storage based on environment
     * @var string
     */
    private $url;

    /**
     * Build PayPal API request
     *
     * @param string $username
     * @param string $password
     * @param string $signature
     * @param string $environment
     * @throws Exception
     */
    public function __construct($username, $password, $signature, $environment = 'live')
    {
        if (!in_array($environment, $this->allowedEnvs)) {
            throw new Exception('Specified environment is not allowed.');
        }
        $this->config = array(
            'username'    => $username,
            'password'    => $password,
            'signature'   => $signature,
            'environment' => $environment
        );
    }

    /**
     * Make a request to the PayPal API
     *
     * @param  string $method API method (e.g. GetBalance)
     * @param  array  $params Additional fields to send in the request (e.g. array('RETURNALLCURRENCIES' => 1))
     * @return array
     */
    public function call($method, array $params = array())
    {
        $fields = $this->encodeFields(array_merge(
            array(
                'METHOD'    => $method,
                'VERSION'   => self::VERSION,
                'USER'      => $this->config['username'],
                'PWD'       => $this->config['password'],
                'SIGNATURE' => $this->config['signature']
            ),
            $params
        ));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        if (!$response) {
            throw new Exception('Failed to contact PayPal API: ' . curl_error($ch) . ' (Error No. ' . curl_errno($ch) . ')');
        }
        curl_close($ch);
        parse_str($response, $result);
        return $this->decodeFields($result);
    }

    /**
     * Prepare fields for API
     *
     * @param  array  $fields
     * @return array
     */
    private function encodeFields(array $fields)
    {
        return array_map('urlencode', $fields);
    }

    /**
     * Make response readable
     *
     * @param  array  $fields
     * @return array
     */
    private function decodeFields(array $fields)
    {
        return array_map('urldecode', $fields);
    }

    /**
     * Get API url based on environment
     *
     * @return string
     */
    private function getUrl()
    {
        if (is_null($this->url)) {
            switch ($this->config['environment']) {
                case 'sandbox':
                case 'beta-sandbox':
                    $this->url = "https://api-3t.paypal.com/nvp";
                    break;
                default:
                    $this->url = 'https://api-3t.paypal.com/nvp';
            }
        }
        return $this->url;
    }
}