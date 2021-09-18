<?php

namespace App\Utility;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class Logger implements ILogger
{
    /**
     * @throws Exception
     * @throws Throwable
     */
    public function write($message, $level, Exception $exceptionObject = null)
    {
        if (isset($exceptionObject)) {
            $message .= "\n$exceptionObject";
        }

        switch ($level) {
            case 'emergency':
                Log::emergency($message);
                break;
            case 'alert':
                Log::alert($message);
                break;
            case 'critical':
                Log::critical($message);
                break;
            case 'error':
                Log::error($message);
                break;
            case 'warning':
                Log::warning($message);
                break;
            case 'notice':
                Log::notice($message);
                break;
            case 'info':
                Log::info($message);
                break;
            case 'debug':
                Log::debug($message);
                break;
            default:
                break;
        }
    }
}
