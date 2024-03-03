<?php

declare(strict_types=1);

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\ArticleModel;

class Articles extends BaseController
{
    /**
     * @var int PAGE_SIZE Number of articles per page in case of pagination
     */
    private const PAGE_SIZE = 5;

    /**
     * Return the view of a page of articles
     * 
     * @param int $page_num Number of the page to be returned, 1 by default
     * @throws PageNotFoundException if pagination failed
     * @return mixed
     */
    public function viewPage(int $page_num = 1): mixed
    {
        $model = model(ArticleModel::class);
        try {
            $data['articles'] = $model->getArticlesPaginated(page: $page_num, page_size: Articles::PAGE_SIZE);
        } catch (\InvalidArgumentException $e) {
            throw new PageNotFoundException();
        }

        $data['cur_page_num'] = $page_num;
        $data['num_of_pages'] = $model->getNumOfPages(self::PAGE_SIZE);

        return view('articles/page', $data);
    }

    /**
     * Return the view of a single article
     * 
     * @param int $article_id Id of the article
     * @throws PageNotFoundException if article lookup failed
     * @return mixed
     */
    public function viewArticle(int $article_id): mixed
    {
        $model = model(ArticleModel::class);
        try {
            $data['article'] = $model->getArticle($article_id);
        } catch (\InvalidArgumentException $e) {
            throw new PageNotFoundException();
        }
        return view('articles/single', $data);
    }
}
