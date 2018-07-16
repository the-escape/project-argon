<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SkynetConnect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skynet:connect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Connect this project to Skynet microservice.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = env('SKYNET_URL');
        $defaultUrl = 'http://skynet.the-escape.work';

        if(empty($url))
        {
            $this->warn('');
            $url = $this->ask('SKYNET_URL has not been found in your .env file. Please provide the URL of the current Skynet installation.', $defaultUrl);
        }

        if(!empty(env('SKYNET_API_KEY')) && !empty(env('SKYNET_SECRET_KEY')))
        {
            if (!$this->confirm('This project is already connected to Skynet. Do you want to create new connection?'))
            {
                return false;
            }
        }

        $endpoint = $url."/api/installations/create";

        $client = new \GuzzleHttp\Client();
        $response = $client->post($endpoint, [
            'headers' => [
                'timestamp' => time()
            ]
        ]);



        $json = json_decode($response->getBody());

        $apiKey = $json->api_key;
        $secretKey = $json->secret_key;

        $this->comment('SKYNET_URL='.$url);
        $this->comment('SKYNET_API_KEY='.$apiKey);
        $this->comment('SKYNET_SECRET_KEY='.$secretKey);

        $path = base_path('.env');
        if (file_exists($path))
        {
            if ($u = env('SKYNET_URL'))
            {
                file_put_contents($path, str_replace(
                    'SKYNET_URL='.$u, 'SKYNET_URL='.$url, file_get_contents($path)
                ));
            }
            else
            {
                file_put_contents($path, file_get_contents($path)."\n\nSKYNET_URL=".$url);
            }

            if ($k = env('SKYNET_API_KEY'))
            {
                file_put_contents($path, str_replace(
                    'SKYNET_API_KEY='.$k, 'SKYNET_API_KEY='.$apiKey, file_get_contents($path)
                ));
            }
            else
            {
                file_put_contents($path, file_get_contents($path)."\nSKYNET_API_KEY=".$apiKey);
            }

            if ($s = env('SKYNET_SECRET_KEY'))
            {
                file_put_contents($path, str_replace(
                    'SKYNET_SECRET_KEY='.$s, 'SKYNET_SECRET_KEY='.$secretKey, file_get_contents($path)
                ));
            }
            else
            {
                file_put_contents($path, file_get_contents($path)."\nSKYNET_SECRET_KEY=".$secretKey);
            }

            $this->comment('SKYNET_ variables have been added to your .env file.');
        }
        else
        {
            $this->comment('Copy these variables and paste in your .env file.');
        }
    }
}
