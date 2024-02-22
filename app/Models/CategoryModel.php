<?php

namespace App\Models;

use CodeIgniter\Model;
use InvalidArgumentException;

class CategoryModel extends Model
{
    /**
     * Table name
     */
    protected $table = 'Category';

    /**
     * Allowed fields
     */
    protected $allowedFields = [
        'id',
        'name'
    ];

    /**
     * Get category names
     * 
     * @return mixed
     */
    public function getCategories()
    {
        $rows = $this->select('id, name')->findAll();
        $categories = [];
        foreach ($rows as $row) {
            $categories[$row['id']] = $row['name'];
        }
        return $categories;
    }
}
