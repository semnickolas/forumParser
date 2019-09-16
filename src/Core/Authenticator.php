<?php
/**
 * Created by PhpStorm.
 * User: Saymon
 * Date: 14.09.2019
 * Time: 20:07
 */

namespace src\Core;

use src\components\ConfigStorage;
use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;

/**
 * Class Authenticator
 * @package src\Core
 */
class Authenticator
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var ConfigStorage
     */
    private $configStorage;

    /**
     * Authenticator constructor.
     */
    public function __construct()
    {
        $this->configStorage = new ConfigStorage();
        $this->client = new Client(['curl' => [CURLOPT_SSL_VERIFYPEER => false]]);
    }

    /**
     * @return StreamInterface
     */
    public function authenticate(): StreamInterface
    {
        $response = $this->client->post(
            $this->configStorage->getParam('loginUrl'),
            [
                'form_params' => [
                    'vb_login_username' => $this->configStorage->getParam('login'),
                    'vb_login_pass' => $this->configStorage->getParam('pass'),
                    'do' => 'login',
                ],
            ]
        );

        return $response->getBody();
    }
}