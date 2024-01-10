<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\ArticleModel;

class Articles extends BaseController
{
    /**
     * @var int page_size Number of articles per page in case of pagination
     */
    private const page_size = 5;

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
            $data['articles'] = $model->getArticlesPaginated(page: $pageNum, page_size: Articles::page_size);
        } catch (\InvalidArgumentException $e) {
            throw new PageNotFoundException();
        }

        $data['curPageNum'] = $pageNum;
        $data['numOfPages'] = (int)ceil($model->getNumOfRows() / Articles::page_size);

        return view('templates/header')
            . view('articles/index', $data)
            . view('templates/footer');
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
        return view('templates/header')
            . view('articles/single', $data)
            . view('templates/footer');
    }
}
