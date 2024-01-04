<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\ArticleModel;

class Articles extends BaseController
{
    public function index()
    {
        $model = model(ArticleModel::class);
        $data['articles'] = $model->getArticles();
        return view('templates/header')
            . view('articles/index', $data)
            . view('templates/footer');
    }

    public function viewArticle($article)
    {
        $model = model(ArticleModel::class);
        $data['article'] = $model->getArticles($article);
        return view('templates/header')
            . view('articles/single', $data)
            . view('templates/footer');
    }

    public function view($page = 'home')
    {
        // Capitalize the first letter to match the file name in case of a case-sensitive system
        $page = ucfirst($page);

        if (!is_file(APPPATH . '\\Views\\articles\\' . $page . '.php')) {
            throw new PageNotFoundException($page . APPPATH . 'Views\\articles\\' . $page . '.php');
        }

        return view('templates/header')
            . view('articles/' . $page)
            . view('templates/footer');
    }
}