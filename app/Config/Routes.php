<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Articles;
use App\Controllers\Admin;

/**
 * @var RouteCollection $routes
 */

// Admin section routes
$routes->get('/admin/login', [Admin::class, 'viewLogin']);
$routes->post('/admin/login', [Admin::class, 'handleLogin']);
$routes->get('/admin/logout', [Admin::class, 'logout']);
$routes->get('/admin', [Admin::class, 'index']);

// Articles section routes
$routes->get('/', [Articles::class, 'viewPage']);
$routes->get('/articles', [Articles::class, 'viewPage']);
$routes->get('/(:segment)', [Articles::class, 'viewPage']);
$routes->get('/articles/(:segment)', [Articles::class, 'viewArticle']);
