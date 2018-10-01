<?php namespace Escape\Argon\Helpers;

use GuzzleHttp\Client;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Log;

class BlocksLibrary
{
    protected $client;
    protected $url;
    protected $apiKey;
    protected $secretKey;

    public function __construct()
    {
        $this->url = env('BLOCKS_LIB_URL');
        $this->apiKey = env('BLOCKS_LIB_API_KEY');
        $this->secretKey = env('BLOCKS_LIB_SECRET_KEY');
    }

    public function isConnected()
    {
        if(empty($this->url) || empty($this->apiKey) || empty($this->secretKey))
        {
            return false;
        }


        $encrypter = new Encrypter($this->secretKey, 'AES-256-CBC');
        $token = $encrypter->encrypt($this->apiKey, false);

        $this->client = new Client([
            'base_uri' => sprintf('%s/api/v1/', $this->url),
            'headers' => [
                'key' => $this->apiKey,
                'token' => $token
            ]

        ]);

        return true;
    }

    public function getBlocks()
    {
        if(!$this->isConnected())
        {
            return [];
        }

        try
        {
            $response = $this->client->get("blocks");

            if ($response->getStatusCode() !== 200)
            {
                Log::error('Blocks Library getBlocks failed.');
                return [];
            }

            if (($json = json_decode($response->getBody())) && !empty($json->blocks))
            {
                return $json->blocks;
            }
        }
        catch (\Exception $e)
        {
            Log::error('Blocks Library getBlocks failed with code: ' . $e->getCode());
            return [];
        }

        return [];
    }


    public function getBlock($blockId)
    {
        if(!$this->isConnected())
        {
            return null;
        }

        try
        {
            $response = $this->client->get("blocks/".$blockId);

            if (($json = json_decode($response->getBody())) && !empty($json->block))
            {
                return $json->block;
            }
        }
        catch (\Exception $e)
        {
            Log::error('Blocks Library getBlock failed with code: ' . $e->getCode());
            return null;
        }

        return null;
    }


    public function deleteBlock($blockId)
    {
        if(!$this->isConnected())
        {
            return false;
        }

        try
        {
            $response = $this->client->delete("blocks/".$blockId);

            if (($json = json_decode($response->getBody())))
            {
                return $json->success;
            }
        }
        catch (\Exception $e)
        {
            Log::error('Blocks Library deleteBlock failed with code: ' . $e->getCode());
            return false;
        }

        return false;
    }


    public function createBlock($request)
    {
        if(!$this->isConnected())
        {
            return false;
        }

        try
        {
            $response = $this->client->post("blocks", [
                'form_params' => $request->all()
            ]);

            if (($json = json_decode($response->getBody())) && !empty($json->block))
            {
                return $json;
            }
        }
        catch (\Exception $e)
        {
            Log::error('Blocks Library createBlock failed with code: ' . $e->getCode());
            return false;
        }

        return false;
    }


    public function updateBlock($blockId, $request)
    {
        if(!$this->isConnected())
        {
            return false;
        }

        try
        {
            $response = $this->client->post("blocks/".$blockId, [
                'form_params' => $request->all()
            ]);

            if (($json = json_decode($response->getBody())))
            {
                return $json->success;
            }
        }
        catch (\Exception $e)
        {
            Log::error('Blocks Library updateBlock failed with code: ' . $e->getCode());
            return false;
        }

        return false;
    }
}