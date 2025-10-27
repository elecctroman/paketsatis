<?php

namespace Core;

class Auth
{
    public static function attempt(string $email, string $password): bool
    {
        $stmt = DB::query('SELECT * FROM users WHERE email = :email LIMIT 1', ['email' => $email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password_hash']) && (int) $user['is_active'] === 1) {
            Session::put('user', ['id' => $user['id'], 'name' => $user['name'], 'role' => $user['role']]);
            return true;
        }
        return false;
    }

    public static function user(): ?array
    {
        return Session::get('user');
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function logout(): void
    {
        Session::forget('user');
    }
}
