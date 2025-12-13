<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class Samaya {

    protected $url;
    protected $client;
    
    
    public function __construct()
    {
        $this->url = 'https://samayasms.com.np/smsapi/index.php';
        $this->client = new Client();
    }

    /**
     * Send SMS
     *
     * @param Integer $to
     * @param String $message
     * @return void
     */
    public function send($to, $message)
    {
        if (app()->environment('production')) {
            $response = $this->client->request('POST', $this->url, [
                'form_params' => [
                    'key' => config('samaya.token'),
                    'contacts' => $to,
                    'msg' => $message,
                    'senderid' => 'FSN_Alert',
                    'responsetype' => 'json'
                    ]
                ]);
    
            return $response->getBody();
        } else  {
            Log::info($message);
        }
    }
}