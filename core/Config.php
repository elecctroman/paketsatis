<?php

namespace Core;

class Config
{
    private static array $config;

    public static function load(string $file): void
    {
        if (!is_file($file)) {
            throw new \RuntimeException('Config file not found: ' . $file);
        }
        self::$config = include $file;
    }

    public static function get(string $key, $default = null)
    {
        $segments = explode('.', $key);
        $value = self::$config;
        foreach ($segments as $segment) {
            if (!isset($value[$segment])) {
                return $default;
            }
            $value = $value[$segment];
        }
        return $value;
    }
}
