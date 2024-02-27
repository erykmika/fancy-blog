<?php

declare(strict_types=1);

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
    public function getArticlesPaginated(int $page = 1, int $page_size = 10): mixed
    {
        if ($page < 1 || $page_size < 1) {
            throw new InvalidArgumentException('Invalid pagination parameters');
        }

        // Fetch Article data from the database
        $articles = $this->orderBy('date DESC')->findAll($page_size, ($page - 1) * $page_size);

        // Determine ids of the fetched articles
        $selected_ids = [];

        foreach ($articles as $article) {
            $selected_ids[] = $article['id'];
        }

        $ids_sql_set = implode(', ', $selected_ids);

        // Fetch name of categories of the previously fetched articles using a single query
        $sql = <<<SQL
            SELECT ArticleCategory.articleId as articleId, Category.name as categoryName
            FROM Category
            INNER JOIN ArticleCategory
            ON Category.id = ArticleCategory.categoryId
            WHERE articleId IN ($ids_sql_set);
        SQL;

        // Assign categories to proper articles
        foreach ($this->db->query($sql)->getResult('array') as $row) {
            $categories[$row['articleId']][] = $row['categoryName'];
        }

        foreach ($articles as &$article) {
            $article['categories'] = $categories[$article['id']];
            sort($article['categories']);
        }

        return $articles;
    }

    /**
     * Get specific article from a database
     * 
     * @param int $id Id of the article to retrieve
     * @return mixed
     */
    public function getArticle(int $id): mixed
    {
        if ($id < 1) {
            throw new InvalidArgumentException('Invalid id');
        }

        $article = $this->where('id', $id)->first();

        if ($article === null) {
            throw new InvalidArgumentException('Invalid id');
        }

        // Fetch name of categories of the given article
        $sql = <<<SQL
            SELECT Category.name as name
            FROM Category
            INNER JOIN ArticleCategory
            ON Category.id = ArticleCategory.categoryId
            WHERE ArticleCategory.articleId = $id;
        SQL;

        foreach ($this->db->query($sql)->getResult('array') as $row) {
            $article['categories'][] = $row['name'];
        }

        sort($article['categories']);

        return $article;
    }

    /**
     * Get total number of pages in case of pagination
     * 
     * @param int $page_size Number of articles per page
     * @return int
     */
    public function getNumOfPages(int $page_size): int
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
     * @param int[] $categories Ids of the article categories
     * @return void
     */
    public function createArticle(string $title, string $content, array $categories): void
    {
        $inserted_data = [
            'title' => $title,
            'content' => $content
        ];

        $this->insert($inserted_data);
        $articleId = (int) $this->db->insertID();
        $this->setCategories($articleId, $categories);
    }

    /**
     * Update the article
     * 
     * @param int $id Id of the article to be updated
     * @param string $new_title New title
     * @param string $new_content New content
     * @param int[] $new_categories Ids of new categories 
     * @return void
     */
    public function updateArticle(int $id, string $new_title, string $new_content, array $new_categories): void
    {
        if ($id < 1) {
            throw new InvalidArgumentException('Invalid article id');
        }
        $this->update($id, [
            'title' => $new_title,
            'content' => $new_content
        ]);

        $this->db->query("DELETE FROM ArticleCategory WHERE articleId = $id;");
        $this->setCategories($id, $new_categories);
    }

    /**
     * Set categories for the article
     * 
     * @param int $articleId Id of the article
     * @param int[] $categoryIds Ids of the categories to be set
     * @return void
     */
    private function setCategories(int $articleId, array $categoryIds): void
    {
        if ($articleId < 1) {
            throw new InvalidArgumentException('Invalid article id');
        }
        foreach ($categoryIds as $categoryId) {
            $sql = <<<SQL
            INSERT INTO ArticleCategory (articleId, categoryId)
            VALUES ($articleId, $categoryId);
            SQL;
            $this->db->query($sql);
        }
    }

    /**
     * Delete the article with the specified id
     * 
     * @param int $id Id of the article to be deleted
     * @return void
     */
    public function deleteArticle(int $id): void
    {
        if ($id < 1) {
            throw new InvalidArgumentException('Invalid article id');
        }

        $this->where('id', $id)->delete();
    }
}
