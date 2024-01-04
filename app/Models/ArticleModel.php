<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = "Article";

    /**
     * Get articles from a database
     * 
     * @param $id Id of the article to be retrieved. If it is 0, all articles are returned;
     * @return mixed
     */
    public function getArticles($id = 0)
    {
        if ($id == 0) {
            return $this->findAll();
        }

        return $this->where(["id"=> $id])->first();
    }
}