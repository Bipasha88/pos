<?php

namespace App\Utility;
use Exception;

interface ILogger
{
    public function write($message, $level, ?Exception $exceptionObject);
}
