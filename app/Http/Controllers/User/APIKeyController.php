<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\APILog;
use Illuminate\Http\Request;

class APIKeyController extends Controller
{

    public function displayLogs($apiKeyId)
    {
        $logs = APILog::orderBy('created_at', 'desc')->where('api_key_id', $apiKeyId)->paginate(10);

        return view('user.account.api-keys.log.index', [
            'apiKeyLogs' => $logs
        ]);
    }


    public function showLogInfo($logId)
    {
        $log = APILog::find($logId);

        return view('user.account.api-keys.log.view', [
            'log' => $log,
            'headers' => json_decode($log->headers, false),
            'endpoint' => json_decode($log->endpoint, false),
            'body' => json_decode($log->body, false)
        ]);
    }

}
