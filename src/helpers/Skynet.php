<?php namespace Escape\Argon\Helpers;

use Carbon\Carbon;
use Illuminate\Encryption\Encrypter;

class Skynet
{
    protected $url;
    protected $apiKey;
    protected $secretKey;

    public function __construct()
    {
        $this->url = env('SKYNET_URL');
        $this->apiKey = env('SKYNET_API_KEY');
        $this->secretKey = env('SKYNET_SECRET_KEY');
    }

    public function isConnected()
    {
        if(empty($this->url) || empty($this->apiKey) || empty($this->secretKey))
        {
            return false;
        }

        return true;
    }

    public function rememberUser($userId)
    {
        if(!$this->isConnected())
        {
            return false;
        }

        $endpoint = $this->url."/api/deleted_users/create";

        $encrypter = new Encrypter($this->secretKey, 'AES-256-CBC');
        $token = $encrypter->encrypt($this->apiKey, false);


        $client = new \GuzzleHttp\Client();
        $response = $client->post($endpoint, [
            'headers' => [
                'key' => $this->apiKey,
                'token' => $token
            ],
            'form_params' => [
                'user_id' => $userId
            ]
        ]);

        return $response;
    }

    public function getRememberedUsers()
    {
        if(!$this->isConnected())
        {
            return false;
        }

        $endpoint = $this->url."/api/deleted_users";

        $encrypter = new Encrypter($this->secretKey, 'AES-256-CBC');
        $token = $encrypter->encrypt($this->apiKey, false);


        $client = new \GuzzleHttp\Client();
        $response = $client->get($endpoint, [
            'headers' => [
                'key' => $this->apiKey,
                'token' => $token
            ]
        ]);

        return json_decode($response->getBody());
    }


}