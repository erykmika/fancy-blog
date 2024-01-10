<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = "Article";

    /**
     * Get paginated articles from a database
     * Implement own pagination
     * 
     * @param $page Number of page to return articles from
     * @param $limit Number of articles per page
     * @return mixed
     */
    public function getArticlesPaginated($page = 1, $page_size = 10)
    {
        $page = intval($page);
        $page_size = intval($page_size);
        if ($page < 1 || $page_size < 1) {
            throw new \InvalidArgumentException("Invalid pagination parameters");
        }
        return $this->orderBy("date")->findAll($page_size, ($page - 1) * $page_size);
    }

    /**
     * Get specific article from a database
     * 
     * @param $id Id of the article to retrieve
     * @return mixed
     */
    public function getArticle($id)
    {
        $id = intval($id);

        if ($id < 1) {
            throw new \InvalidArgumentException("Invalid id");
        }

        $article = $this->where("id", $id)->first();

        if ($article === null) {
            throw new \InvalidArgumentException("Invalid id");
        }

        return $article;
    }

    /**
     * Get number of rows in the table
     * 
     * @return int
     */
    public function getNumOfRows()
    {
        $query = $this->db->query("SELECT count(id) FROM Article;");
        return (int)$query->getRowArray()['count(id)'];
    }
}
