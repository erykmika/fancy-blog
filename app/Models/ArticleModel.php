<?php

namespace App\Models;

use CodeIgniter\Model;
use InvalidArgumentException;

class ArticleModel extends Model
{
    /**
     * Table name
     */
    protected $table = 'Article';

    /**
     * Allowed fields
     */
    protected $allowedFields = [
        'title',
        'content'
    ];

    /**
     * Primary key
     */
    protected $primaryKey = 'id';

    /**
     * Get paginated articles from a database
     * Implement own pagination
     * 
     * @param int $page Number of page to return articles from
     * @param int $limit Number of articles per page
     * @return mixed
     */
    public function getArticlesPaginated($page = 1, $page_size = 10)
    {
        if ($page < 1 || $page_size < 1) {
            throw new InvalidArgumentException('Invalid pagination parameters');
        }
        return $this->orderBy('date DESC')->findAll($page_size, ($page - 1) * $page_size);
    }

    /**
     * Get specific article from a database
     * 
     * @param int $id Id of the article to retrieve
     * @return mixed
     */
    public function getArticle($id)
    {
        if ($id < 1) {
            throw new InvalidArgumentException('Invalid id');
        }

        $article = $this->where('id', $id)->first();

        if ($article === null) {
            throw new InvalidArgumentException('Invalid id');
        }

        return $article;
    }

    /**
     * Get total number of pages in case of pagination
     * 
     * @param int $page_size Number of articles per page
     * @return int
     */
    public function getNumOfPages($page_size)
    {
        if ($page_size < 1) {
            throw new InvalidArgumentException('Invalid page size');
        }
        $query = $this->query('SELECT count(id) FROM Article;');
        $num_of_rows = (int) $query->getRowArray()['count(id)'];
        return (int) ceil($num_of_rows / $page_size);
    }

    /**
     * Create a new article
     * 
     * @param string $title Title of the created article
     * @param string $content Content of the created article
     * @return void
     */
    public function createArticle($title, $content)
    {
        $inserted_data = [
            'title' => $title,
            'content' => $content
        ];

        $this->insert($inserted_data);
    }

    /**
     * Update the article
     * 
     * @param int $id Id of the article to be updated
     * @param string $new_title New title
     * @param string $new_content New content
     * @return void
     */
    public function updateArticle($id, $new_title, $new_content)
    {
        $this->update($id, [
            'title' => $new_title,
            'content' => $new_content
        ]);
    }

    /**
     * Delete the article with the specified id
     * 
     * @param int $id Id of the article to be deleted
     * @return void
     */
    public function deleteArticle($id)
    {
        if ($id < 1) {
            throw new InvalidArgumentException('Invalid article id');
        }

        $this->where('id', $id)->delete();
    }
}
