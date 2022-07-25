<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BlocksLibraryConnect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blockslib:connect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Connect this project to Blocks Library microservice.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = env('BLOCKS_LIB_URL');
        $defaultUrl = 'http://blockslibrary.the-escape.work';

        if(empty($url))
        {
            $this->warn('');
            $url = $this->ask('BLOCKS_LIB_URL has not been found in your .env file. Please provide the URL of the current Blocks Library installation.', $defaultUrl);
        }

        if(!empty(env('BLOCKS_LIB_API_KEY')) && !empty(env('BLOCKS_LIB_SECRET_KEY')))
        {
            if (!$this->confirm('This project is already connected to Blocks Library. Do you want to create new connection?'))
            {
                return 0;
            }
        }

        $endpoint = $url."/api/v1/installations";

        $client = new \GuzzleHttp\Client();
        $response = $client->post($endpoint, [
            'headers' => [
                'timestamp' => time()
            ]
        ]);

        if ($response->getStatusCode() == 206)
        {
            $code = $this->ask('Authentication code required...');

            $response = $client->post($endpoint, [
                'headers' => [
                    'key' => $code
                ]
            ]);

            if ($response->getStatusCode() !== 201)
            {
                $this->warn('Authentication code is invalid.');
                return 0;
            }
        }

        $json = json_decode($response->getBody());

        $apiKey = $json->api_key;
        $secretKey = $json->secret_key;

        $this->comment('BLOCKS_LIB_URL='.$url);
        $this->comment('BLOCKS_LIB_API_KEY='.$apiKey);
        $this->comment('BLOCKS_LIB_SECRET_KEY='.$secretKey);

        $path = base_path('.env');
        if (file_exists($path))
        {
            if ($u = env('BLOCKS_LIB_URL'))
            {
                file_put_contents($path, str_replace(
                    'BLOCKS_LIB_URL='.$u, 'BLOCKS_LIB_URL='.$url, file_get_contents($path)
                ));
            }
            else
            {
                file_put_contents($path, file_get_contents($path)."\n\nBLOCKS_LIB_URL=".$url);
            }

            if ($k = env('BLOCKS_LIB_API_KEY'))
            {
                file_put_contents($path, str_replace(
                    'BLOCKS_LIB_API_KEY='.$k, 'BLOCKS_LIB_API_KEY='.$apiKey, file_get_contents($path)
                ));
            }
            else
            {
                file_put_contents($path, file_get_contents($path)."\nBLOCKS_LIB_API_KEY=".$apiKey);
            }

            if ($s = env('BLOCKS_LIB_SECRET_KEY'))
            {
                file_put_contents($path, str_replace(
                    'BLOCKS_LIB_SECRET_KEY='.$s, 'BLOCKS_LIB_SECRET_KEY='.$secretKey, file_get_contents($path)
                ));
            }
            else
            {
                file_put_contents($path, file_get_contents($path)."\nBLOCKS_LIB_SECRET_KEY=".$secretKey);
            }

            $this->comment('BLOCKS_LIB_ variables have been added to your .env file.');
        }
        else
        {
            $this->comment('Copy these variables and paste in your .env file.');
        }
    }
}
