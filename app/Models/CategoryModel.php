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
     * Get specific category
     * 
     * @param int $id Category id
     * @return mixed
     */
    public function getCategoryName($id)
    {
        if($id < 1) {
            throw new InvalidArgumentException('Invalid category id');
        }
        $name = $this->where('id', $id)->first()['name'];
        return $name;
    }
}
