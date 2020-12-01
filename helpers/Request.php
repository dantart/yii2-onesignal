<?php

namespace dantart\onesignal\helpers;

use yii\base\Object;
use GuzzleHttp\Client;

class Request extends Object
{

    public $client;
    public $appId;
    public $apiKey;
    public $apiBaseUrl = 'https://onesignal.com/api/v1/';

    public function init()
    {
        $this->client = new Client([
            'base_uri' => $this->apiBaseUrl,
            'headers' => [
                'Authorization' => 'Basic ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ]
        ]);
    }
}