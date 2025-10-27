<?php

namespace Core;

use PDO;
use PDOException;

class DB
{
    private static ?PDO $pdo = null;

    public static function init(array $config): void
    {
        if (self::$pdo !== null) {
            return;
        }
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', $config['host'], $config['port'] ?? 3306, $config['database'], $config['charset'] ?? 'utf8mb4');
        try {
            self::$pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            if (!empty($config['collation'])) {
                self::$pdo->exec("SET NAMES '{$config['charset']}' COLLATE '{$config['collation']}'");
            }
        } catch (PDOException $e) {
            throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function query(string $sql, array $params = [])
    {
        if (self::$pdo === null) {
            throw new \RuntimeException('Database not initialised');
        }
        $stmt = self::$pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(is_int($key) ? $key + 1 : ':' . $key, $value);
        }
        $stmt->execute();
        return $stmt;
    }

    public static function lastInsertId(): string
    {
        return self::$pdo?->lastInsertId() ?? '0';
    }

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            throw new \RuntimeException('Database not initialised');
        }
        return self::$pdo;
    }

    public static function paginate(string $sql, int $perPage = 15, int $page = 1, array $params = []): array
    {
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;
        $countSql = 'SELECT COUNT(*) FROM (' . $sql . ') as count_query';
        $total = (int) self::query($countSql, $params)->fetchColumn();
        $pagedSql = $sql . ' LIMIT ' . $perPage . ' OFFSET ' . $offset;
        $items = self::query($pagedSql, $params)->fetchAll();
        return [
            'items' => $items,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => (int) ceil($total / $perPage),
        ];
    }
}
