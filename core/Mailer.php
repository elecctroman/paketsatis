<?php

namespace Core;

class Mailer
{
    public static function send(string $to, string $subject, string $body, array $headers = []): bool
    {
        $config = Config::get('mail');
        $headers = array_merge([
            'From' => $config['from']['name'] . ' <' . $config['from']['address'] . '>',
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=UTF-8'
        ], $headers);
        $headerString = '';
        foreach ($headers as $key => $value) {
            $headerString .= $key . ': ' . $value . "\r\n";
        }
        return mail($to, $subject, $body, $headerString);
    }
}
