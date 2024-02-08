<?php

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
     * @param int $pageNum Number of the page to be returned, 1 by default

     * @return mixed
     */
    public function viewPage($pageNum = 1)
    {
        $model = model(ArticleModel::class);
        try {
            $data['articles'] = $model->getArticlesPaginated(page: $pageNum, page_size: Articles::PAGE_SIZE);
        } catch (\InvalidArgumentException $e) {
            throw new PageNotFoundException();
        }

        $data['curPageNum'] = $pageNum;
        $data['numOfPages'] = $model->getNumOfPages(self::PAGE_SIZE);

        return view('articles/page', $data);
    }

    /**
     * Return the view of a single article
     * 
     * @param int $articleId Id of the article
     * 
     * @return mixed
     */
    public function viewArticle($articleId)
    {
        $model = model(ArticleModel::class);
        try {
            $data['article'] = $model->getArticle($articleId);
        } catch (\InvalidArgumentException $e) {
            throw new PageNotFoundException();
        }
        return view('articles/single', $data);
    }
}
