<?php

namespace App\util;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{
    public static function write($logController, $logFunction, $logMessage, $logLevel)
    {
        $date = date('d_m_y');

        $delimiter = env('DELIMITER', '//');

        $logFile = public_path().$delimiter.'logs'.$delimiter.'log_'.$date.'.log';

        if (!file_exists($logFile)) {
            $fp = fopen($logFile, 'w');
            fwrite($fp, '');
            fclose($fp);
        }

        $log = new Logger('\n Controller: '.$logController.' Function: '.$logFunction.'; ');

        switch ($logLevel) {
            case 'Warn':
                $log->pushHandler(new StreamHandler($logFile, Logger::WARNING));
                $log->warning($logMessage);
                break;

            case 'Error':
                $log->pushHandler(new StreamHandler($logFile, Logger::ERROR));
                $log->error($logMessage);
                break;

            default:
                $log->pushHandler(new StreamHandler($logFile, Logger::INFO));
                $log->info($logMessage);
        }
    }
}
