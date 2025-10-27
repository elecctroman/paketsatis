<?php

namespace App\Models;

use Core\Model;

class Category extends Model
{
    protected string $table = 'categories';

    public function findBySlug(string $slug): ?array
    {
        return $this->firstWhere('slug', $slug);
    }

    public function active(): array
    {
        return $this->where(['is_active' => 1], null, 'sort ASC, id ASC');
    }
}
