<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use App\Models\ArticleModel;
use CodeIgniter\Session\Session;
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
     * @var Session session Session object
     */
    private Session $session;

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
    public function viewLogin(): mixed
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
    public function handleLogin(): RedirectResponse
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
    public function logout(): RedirectResponse
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
    public function displayDashboardPage(int $page_num = 1): mixed
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
    public function displayArticlePage(int $article_id): mixed
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

        return view('admin/single', $data);
    }

    /**
     * Display article edit page to admin
     * 
     * @param int $article_id Id of the article to be edited
     * @return mixed
     */
    public function displayEditPage(int $article_id): mixed
    {
        if (!$this->authorize()) {
            throw new PageNotFoundException();
        }

        $article_id = intval($article_id);

        $model = model(ArticleModel::class);
        try {
            $article = $model->getArticle($article_id);
            $data['article'] = $article;
        } catch (InvalidArgumentException $e) {
            throw new PageNotFoundException(self::EXCEPTION_MSG);
        }

        $category_model = model(CategoryModel::class);

        // All categories that can be assigned to the article
        $possible_categories = $category_model->getCategories();
        // Already assigned categories
        $categories = [];

        foreach ($possible_categories as $key => $name) {
            $categories[$name] = "";
        }

        foreach ($possible_categories as $key => $possible_category) {
            if (in_array($possible_category, $article['categories'], true)) {
                $categories[$possible_category] = "on";
            }
        }

        $data['categories'] = $categories;

        return view('admin/edit', $data);
    }

    /** 
     * Validate article POST request data, including categories
     * 
     * @return array|bool Associative array of 'title', 'content', 'categories' keys on success, false otherwise 
     */
    private function validateArticlePostData(): array|bool
    {
        // Retrieve data from the POST request, perform validation
        $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $content = trim(filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // If either field is empty (''), return false
        if (empty($title) || empty($content)) {
            return false;
        }

        // Handle categories
        $category_model = model(CategoryModel::class);

        // All categories that can be assigned to an article
        $possible_categories = $category_model->getCategories();
        // Chosen categories
        $categories = [];

        foreach ($possible_categories as $key => $possible_category) {
            if ($this->request->getPost($possible_category) === 'on') {
                $categories[] = $key;
            }
        }
        return ['title' => $title, 'content' => $content, 'categories' => $categories];
    }

    /**
     * Process article edit request
     * 
     * @param int $article_id Id of the article that is edited
     * @return RedirectResponse
     */
    public function handleEdit(int $article_id): RedirectResponse
    {
        if (!$this->authorize() || !$this->request->is('post')) {
            throw new PageNotFoundException();
        }

        $article_id = intval($article_id);
        $article_data = $this->validateArticlePostData();

        if ($article_data === false) {
            return redirect()->to(site_url('/admin/edit/' . $article_id));
        }

        $model = model(ArticleModel::class);

        try {
            $model->updateArticle(
                $article_id,
                $article_data['title'],
                $article_data['content'],
                $article_data['categories']
            );
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
    public function authorize(): bool
    {
        return (isset($_SESSION['login_status']) && $_SESSION['login_status'] === true);
    }

    /**
     * Display article Create page to admin
     * 
     * @return mixed
     */
    public function displayAddPage(): mixed
    {
        if (!$this->authorize()) {
            throw new PageNotFoundException();
        }

        $category_model = model(CategoryModel::class);
        $data['categories'] = $category_model->getCategories();

        return view('admin/add', $data);
    }

    /**
     * Handle article creation request
     * 
     * @return RedirectResponse
     */
    public function handleAdd(): RedirectResponse
    {
        if (!$this->authorize() || !$this->request->is('post')) {
            throw new PageNotFoundException();
        }

        try {
            $article_data = $this->validateArticlePostData();

            if ($article_data === false) {
                return redirect()->to(site_url('/admin/add'));
            }

            $model = model(ArticleModel::class);

            $model->createArticle(
                $article_data['title'],
                $article_data['content'],
                $article_data['categories']
            );
        } catch (Exception $e) {
            throw new PageNotFoundException(self::EXCEPTION_MSG);
        }

        return redirect()->route('Admin::displayDashboardPage');
    }

    /**
     * Process article deletion request
     * 
     * @param int $article_id Id of the article to be deleted
     * @return RedirectResponse
     */
    public function handleDelete(int $article_id): RedirectResponse
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
