<?php

namespace Core;

class Logger
{
    public static function info(string $message, array $context = []): void
    {
        self::write('INFO', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::write('ERROR', $message, $context);
    }

    private static function write(string $level, string $message, array $context = []): void
    {
        $logDir = __DIR__ . '/../storage/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0775, true);
        }
        $file = $logDir . '/' . date('Y-m-d') . '.log';
        $context = $context ? json_encode($context, JSON_UNESCAPED_UNICODE) : '';
        $line = sprintf("[%s] %s %s %s\n", date('Y-m-d H:i:s'), $level, $message, $context);
        file_put_contents($file, $line, FILE_APPEND);
    }
}
