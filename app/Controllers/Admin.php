<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

class Admin extends BaseController
{
    /**
     * @var string ADMIN_PASS Password used for admin authentication
     */
    private const ADMIN_PASS = '123';

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
            return redirect()->route('Admin::index');
        }

        return view('templates/header')
            . view('admin/login')
            . view('templates/footer');
    }

    /**
     * Process admin login data
     * Redirect to admin dashboard on success, retry to login otherwise
     * 
     * @return mixed
     */
    public function handleLogin()
    {
        if (!$this->request->is('post')) {
            throw new PageNotFoundException('');
        }

        if ($this->request->getGetPost('pswd') === self::ADMIN_PASS) {
            $this->session->set('login_status', true);
            return redirect()->route('Admin::index');
        } else {
            $this->session->set('login_status', false);
            return redirect()->route('Admin::login');
        }
    }

    /**
     * Logout admin, redirect to home page
     * 
     * @return mixed
     */
    public function logout()
    {
        if (isset($_SESSION['login_status'])) {
            $this->session->set('login_status', false);
        }
        return redirect()->route('Articles::viewPage');
    }

    /**
     * Show admin dashboard if authorized
     * 
     * @return mixed
     */
    public function index()
    {
        if (!$this->authorize()) {
            throw new PageNotFoundException('');
        }
        return view('templates/header') . view('templates/footer');
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
}
