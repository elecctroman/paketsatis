<?php

namespace App\Models;

use Core\Model;

class Order extends Model
{
    protected string $table = 'orders';

    public function findByReference(string $reference): ?array
    {
        $stmt = \Core\DB::query(
            "SELECT * FROM {$this->table} WHERE external_ref = :reference OR id = :id LIMIT 1",
            ['reference' => $reference, 'id' => $reference]
        );
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
