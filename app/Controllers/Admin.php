<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use App\Models\ArticleModel;
use InvalidArgumentException;
use Exception;

class Admin extends BaseController
{
    /**
     * @var string ADMIN_PASS Password used for admin authentication
     */
    private const ADMIN_PASS = '123';

    /**
     * @var int PAGE_SIZE Number of articles shown in admin dashboard
     */
    private const PAGE_SIZE = 10;

    /**
     * @var object session Session object
     */
    private $session;

    /**
     * @var string EXCEPTION_MSG Exception message for authorized admin
     */
    private const EXCEPTION_MSG = 'An error occurred'; 

    /**
     * Instantiate the session object used for admin authorization
     */
    public function __construct()
    {
        $this->session = Services::session();
    }

    /**
     * Return the admin login panel view
     * 
     * @return mixed
     */
    public function viewLogin()
    {
        if ($this->authorize()) {
            return redirect()->route('Admin::displayDashboardPage');
        }

        return view('admin/login');
    }

    /**
     * Process admin login data
     * Redirect to admin dashboard on success, retry to login otherwise
     * 
     * @return RedirectResponse
     */
    public function handleLogin()
    {
        if (!$this->request->is('post')) {
            throw new PageNotFoundException();
        }

        if ($this->request->getGetPost('pswd') === self::ADMIN_PASS) {
            $this->session->set('login_status', true);
            return redirect()->route('Admin::displayDashboardPage');
        } else {
            $this->session->set('login_status', false);
            return redirect()->route('Admin::login');
        }
    }

    /**
     * Logout admin, redirect to home page
     * 
     * @return RedirectResponse
     */
    public function logout()
    {
        unset($_SESSION['login_status']);
        session_destroy();
        return redirect()->route('Articles::viewPage');
    }

    /**
     * Show admin dashboard if authorized
     * Display given page of articles
     * 
     * @param int $page_num Number of page to be contained in the dashboard 
     * @return mixed
     */
    public function displayDashboardPage($page_num = 1)
    {
        if (!$this->authorize()) {
            throw new PageNotFoundException();
        }

        $page_num = intval($page_num);

        $model = model(ArticleModel::class);

        try {
            $data['articles'] = $model->getArticlesPaginated(page: $page_num, page_size: self::PAGE_SIZE);
        } catch (InvalidArgumentException $e) {
            throw new PageNotFoundException(self::EXCEPTION_MSG);
        }

        $data['cur_page_num'] = $page_num;
        $data['num_of_pages'] = $model->getNumOfPages(self::PAGE_SIZE);

        return view('admin/dashboard', $data);
    }

    /**
     * Display specific article page to admin
     * 
     * @param int $article_id Id of the article
     * @return mixed
     */
    public function displayArticlePage($article_id)
    {
        if (!$this->authorize()) {
            throw new PageNotFoundException();
        }

        $article_id = intval($article_id);

        $model = model(ArticleModel::class);
        try {
            $data['article'] = $model->getArticle($article_id);
        } catch (InvalidArgumentException $e) {
            throw new PageNotFoundException(self::EXCEPTION_MSG);
        }

        return view('articles/single', $data);
    }

    /**
     * Display article edit page to admin
     * 
     * @param int $article_id Id of the article to be edited
     * @return mixed
     */
    public function displayEditPage($article_id)
    {
        if (!$this->authorize()) {
            throw new PageNotFoundException();
        }

        $article_id = intval($article_id);

        $model = model(ArticleModel::class);
        try {
            $data['article'] = $model->getArticle($article_id);
        } catch (InvalidArgumentException $e) {
            throw new PageNotFoundException(self::EXCEPTION_MSG);
        }

        return view('admin/edit', $data);
    }

    /**
     * Process article edit request
     * 
     * @param int $article_id Id of the article that is edited
     * @return RedirectResponse
     */
    public function handleEdit($article_id)
    {
        if (!$this->authorize() || !$this->request->is('post')) {
            throw new PageNotFoundException();
        }

        $article_id = intval($article_id);

        // Retrieve data from the POST request, perform validation
        $new_title = $this->request->getPost('new_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $new_content = $this->request->getPost('new_content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $new_title = trim($new_title);
        $new_content = trim($new_content);

        // If either field is empty (''), redirect back to edit page
        if (empty($new_title) || empty($new_content)) {
            return redirect()->to(site_url('/admin/edit/' . $article_id));
        }

        $model = model(ArticleModel::class);

        try {
            $model->updateArticle($article_id, $new_title, $new_content);
        } catch (Exception $e) {
            throw new PageNotFoundException(self::EXCEPTION_MSG);
        }

        return redirect()->route('Admin::displayDashboardPage');
    }

    /**
     * Authorize the admin
     * 
     * @return bool Is admin authorized
     */
    public function authorize()
    {
        return (isset($_SESSION['login_status']) && $_SESSION['login_status'] === true);
    }

    /**
     * Display article Create page to admin
     * 
     * @return mixed
     */
    public function displayAddPage()
    {
        if (!$this->authorize()) {
            throw new PageNotFoundException();
        }

        return view('admin/add');
    }

    /**
     * Handle article creation request
     * 
     * @return RedirectResponse
     */
    public function handleAdd()
    {
        if (!$this->authorize() || !$this->request->is('post')) {
            throw new PageNotFoundException();
        }

        try {
            // Retrieve data from the POST request, validate it
            $title = $this->request->getPost('title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = $this->request->getPost('content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $title = trim($title);
            $content = trim($content);

            // If either field is empty (''), navigate back to add page
            if (empty($title) || empty($content)) {
                return redirect()->to(site_url('/admin/add'));
            }

            $model = model(ArticleModel::class);
            $model->createArticle($title, $content);

        } catch (Exception $e) {
            throw new PageNotFoundException(self::EXCEPTION_MSG);
        }

        return redirect()->route('Admin::displayDashboardPage');
    }

    /**
     * Process article deletion request
     * 
     * @return RedirectResponse
     */
    public function handleDelete($article_id)
    {
        if (!$this->authorize() || !$this->request->is('post')) {
            throw new PageNotFoundException();
        }

        $article_id = intval($article_id);

        $model = model(ArticleModel::class);

        try {
            $model->deleteArticle($article_id);
        } catch (InvalidArgumentException $e) {
            throw new PageNotFoundException();
        }

        return redirect()->route('Admin::displayDashboardPage');
    }
}
