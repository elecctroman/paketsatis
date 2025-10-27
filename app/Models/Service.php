<?php

namespace App\Models;

use Core\Model;

class Service extends Model
{
    protected string $table = 'services';

    public function findBySlug(string $slug): ?array
    {
        return $this->firstWhere('slug', $slug);
    }

    public function forCategory(int $categoryId): array
    {
        return $this->where(['category_id' => $categoryId, 'is_active' => 1], null, 'created_at DESC');
    }

    public function featured(int $limit = 6): array
    {
        return $this->where(['is_active' => 1], $limit, 'created_at DESC');
    }
}
