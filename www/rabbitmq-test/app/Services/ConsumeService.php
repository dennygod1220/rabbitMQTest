<?php

namespace App\Services;

use App\Models\FcmJob;
use App\Services\FcmService;
use Carbon\Carbon;

class ConsumeService {

    public function handle($job , $payload)
    {
        $payload = unserialize( $payload['data']['command'] )->data;

        $deviceId = $payload['deviceId'] ?? null;
        $data = [];
        $data['title'] = 'Incoming message';
        $data['body'] = $payload['text'] ?? '';

        $fcm = app(FcmService::class)->callApi($deviceId ,$data);
        // $fcm = [
        //     'identifier' => 'abcdefg'
        // ];

        if($fcm != false){
            $fcmInsert = [
                'data' => [
                    'identifier' => $payload['identifier'],
                    'deliverAt' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            ];

            FcmJob::create($fcmInsert);

            return $fcm;
        }

        throw new \Exception('Fcm send err');
    }
}