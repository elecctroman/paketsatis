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
}
