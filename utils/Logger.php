<?php
class Logger {
    public static function log($message, $level = 'INFO') {
        $logFile = __DIR__ . '/../logs/app.log';
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] [$level] $message" . PHP_EOL;
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
}
