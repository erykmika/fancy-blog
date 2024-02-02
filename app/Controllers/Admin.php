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

        return view('templates/header')
            . view('admin/login')
            . view('templates/footer');
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
            throw new PageNotFoundException('');
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
     * @param int $pageNum Number of page to be contained in the dashboard 
     * 
     * @return mixed
     */
    public function displayDashboardPage($pageNum = 1)
    {
        if (!$this->authorize()) {
            throw new PageNotFoundException('');
        }

        $model = model(ArticleModel::class);

        try {
            $data['articles'] = $model->getArticlesPaginated(page: $pageNum, page_size: self::PAGE_SIZE);
        } catch (InvalidArgumentException $e) {
            throw new PageNotFoundException();
        }

        $data['curPageNum'] = $pageNum;
        $data['numOfPages'] = $model->getNumOfPages(self::PAGE_SIZE);

        return view('templates/header') .
            view('admin/dashboard', $data) .
            view('templates/footer');
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
    public function displayCreatePage()
    {
        if (!$this->authorize()) {
            throw new PageNotFoundException('');
        }

        return view('templates/header')
            . view('admin/add')
            . view('templates/footer');
    }

    /**
     * Handle article creation request
     * 
     * @return RedirectResponse
     */
    public function handleCreate()
    {
        if (!$this->authorize() || !$this->request->is('post')) {
            throw new PageNotFoundException('');
        }

        try {
            // Retrieve data from the POST request
            $title = $this->request->getPost('title');
            $content = $this->request->getPost('content');

            // Sanitize data inserted into the database
            $title = trim($title);
            $content = trim($content);

            $model = model(ArticleModel::class);
            $model->createArticle($title, $content);
        } catch (Exception $e) {
            throw new PageNotFoundException("An error occurred");
        }

        return redirect()->route('Admin::displayDashboardPage');
    }

    /**
     * Process article deletion request
     * 
     * @return RedirectResponse
     */
    public function handleDelete($articleId)
    {
        if (!$this->authorize() || !$this->request->is('post')) {
            throw new PageNotFoundException('');
        }

        $model = model(ArticleModel::class);

        try {
            $model->deleteArticle($articleId);
        } catch (InvalidArgumentException $e) {
            throw new PageNotFoundException();
        }

        return redirect()->route('Admin::displayDashboardPage');
    }
}