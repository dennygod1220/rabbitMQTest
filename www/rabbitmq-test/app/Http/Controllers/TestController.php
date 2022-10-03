<?php

namespace App\Http\Controllers;

use App\Jobs\PushJob;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function push()
    {
        $this->dispatch(new PushJob([
            'identifier' => 1,
            'type' => 'device',
            'deviceId' => 'abcdefg',
            'text' => 'hello world'
        ]));

        return response()->json(['code' => 0, 'msg' => "success"]);
    }
}
