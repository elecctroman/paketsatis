<?php

namespace Core;

class Rbac
{
    private static array $permissions = [];
    private static array $routeMap = [];

    public static function load(array $permissions, array $routeMap): void
    {
        self::$permissions = $permissions;
        self::$routeMap = $routeMap;
    }

    public static function can(string $role, string $permission): bool
    {
        return in_array($permission, self::$permissions[$role] ?? [], true);
    }

    public static function authorize(string $route, ?array $user): bool
    {
        $permission = self::$routeMap[$route] ?? null;
        if (!$permission) {
            return true;
        }
        if (!$user) {
            return false;
        }
        return self::can($user['role'] ?? 'guest', $permission);
    }
}
