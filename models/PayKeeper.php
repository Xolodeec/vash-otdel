<?php

namespace app\models;

use GuzzleHttp\Client;

class PayKeeper
{
    private $http;
    private $securityToken;
    private $host;
    private $login;
    private $password;

    public function __construct($host, $login, $password)
    {
        $this->host = $host;
        $this->login = $login;
        $this->password = $password;

        $this->http = new Client([
            'base_uri' => $this->host,
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode("{$this->login}:{$this->password}" )
            ],
        ]);

        $this->securityToken = $this->getSecurityToken();
    }

    public function getSecurityToken()
    {
        $response = $this->http->request('GET', '/info/settings/token/');
        $response = json_decode($response->getBody()->getContents(), true);

        return $response['token'];
    }

    public function getPaymentData($params = [])
    {
        $params = collect($params)->merge(['token' => $this->securityToken]);

        $response = $this->http->request('POST', '/change/invoice/preview/', ['form_params' => $params->toArray()]);
        $response = json_decode($response->getBody()->getContents(), true);

        return $response;
    }
}
