<?php

namespace App\Models;

use Core\Model;

class Content extends Model
{
    protected string $table = 'contents';

    public function latestByType(string $type, int $limit = 10): array
    {
        return $this->where(['type' => $type], $limit, 'published_at DESC');
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->firstWhere('slug', $slug);
    }
}
