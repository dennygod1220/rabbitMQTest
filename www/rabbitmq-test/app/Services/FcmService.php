<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

class FcmService
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var mixed
     */
    private $baseUrl;
    /**
     * @var mixed
     */
    private $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('FCM_URL', 'https://fcm.googleapis.com/fcm/send');
        $this->apiKey = env('FCM_KEY', '123');

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'key=' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);
    }

    public function callApi($token, $data)
    {
        try {
            $postData = [
                'json' => [
                    'registration_ids' => $token,
                    'notification' => [
                        'title' => $data['title'] ?? '',
                        'body' => $data['body'] ?? '',
                        'image' => null
                    ],
                    'data' => $data
                ]
            ];

            $res = $this->client->request('POST', $this->baseUrl, $postData);

            if ($res->getStatusCode() === 200) {
                return $res->getBody();
            }

            return false;
        } catch (ClientException $e) {
            $this->logs($postData, Psr7\Message::toString($e->getResponse()));

            return false;
        } catch (\Throwable $th) {
            $this->logs($postData, $th->getMessage());

            return false;
        }
    }

    protected function logs(array $requestData = [], string $msg = null)
    {
        Log::error('FCM-FAIL', [
            'Request Data' => $requestData,
            '失敗原因' => $msg
        ]);
    }
}
