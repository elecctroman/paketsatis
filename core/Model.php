<?php

namespace Core;

abstract class Model
{
    protected string $table;
    protected string $primaryKey = 'id';

    public function all(): array
    {
        $stmt = DB::query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id): ?array
    {
        $stmt = DB::query("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1", ['id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $keys = array_keys($data);
        $columns = implode(',', $keys);
        $placeholders = implode(',', array_map(fn($k) => ':' . $k, $keys));
        DB::query("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})", $data);
        return (int) DB::lastInsertId();
    }

    public function update($id, array $data): bool
    {
        $set = implode(',', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $data[$this->primaryKey] = $id;
        DB::query("UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = :{$this->primaryKey}", $data);
        return true;
    }

    public function firstWhere(string $column, $value): ?array
    {
        $this->guardColumn($column);
        $stmt = DB::query("SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1", ['value' => $value]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function where(array $conditions = [], ?int $limit = null, ?string $orderBy = null): array
    {
        $clauses = [];
        $params = [];
        foreach ($conditions as $column => $value) {
            $this->guardColumn((string) $column);
            $paramKey = 'param_' . count($params);
            $clauses[] = "{$column} = :{$paramKey}";
            $params[$paramKey] = $value;
        }
        $sql = "SELECT * FROM {$this->table}";
        if ($clauses) {
            $sql .= ' WHERE ' . implode(' AND ', $clauses);
        }
        if ($orderBy) {
            if (!preg_match('/^[a-zA-Z0-9_,\s]+$/', $orderBy)) {
                throw new \InvalidArgumentException('Invalid order by clause.');
            }
            $sql .= ' ORDER BY ' . $orderBy;
        }
        if ($limit !== null) {
            $sql .= ' LIMIT ' . (int) $limit;
        }
        $stmt = DB::query($sql, $params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function guardColumn(string $column): void
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $column)) {
            throw new \InvalidArgumentException('Invalid column name.');
        }
    }
}
