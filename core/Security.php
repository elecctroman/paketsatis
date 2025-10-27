<?php

namespace Core;

class Security
{
    public static function csrfToken(): string
    {
        Session::start();
        if (!isset($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    public static function verifyCsrf(?string $token): bool
    {
        Session::start();
        return isset($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], (string) $token);
    }

    public static function sanitizeString(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function sanitizeHtml(string $html): string
    {
        $allowed = [
            'p', 'b', 'i', 'strong', 'em', 'a', 'ul', 'ol', 'li', 'h1', 'h2', 'h3', 'h4', 'img', 'blockquote', 'code', 'pre'
        ];
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8"?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new \DOMXPath($dom);
        foreach ($xpath->query('//*') as $node) {
            if (!in_array($node->nodeName, $allowed, true)) {
                $node->parentNode?->removeChild($node);
                continue;
            }
            if ($node->nodeName === 'a') {
                foreach (iterator_to_array($node->attributes) as $attr) {
                    if ($attr->nodeName !== 'href') {
                        $node->removeAttribute($attr->nodeName);
                    }
                }
            }
            if ($node->nodeName === 'img') {
                foreach (iterator_to_array($node->attributes) as $attr) {
                    if (!in_array($attr->nodeName, ['src', 'alt'], true)) {
                        $node->removeAttribute($attr->nodeName);
                    }
                }
            }
        }
        $clean = $dom->saveHTML() ?: '';
        libxml_clear_errors();
        libxml_use_internal_errors(false);
        return $clean;
    }
}
