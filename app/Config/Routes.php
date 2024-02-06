<?php

use CodeIgniter\Router\RouteCollection;

use App\Controllers\Articles;
use App\Controllers\Admin;

/**
 * @var RouteCollection $routes
 */

/** 
* Admin section routes
*/
$routes->get('/admin/login', [Admin::class, 'viewLogin']);
$routes->post('/admin/login', [Admin::class, 'handleLogin']);

$routes->get('/admin/logout', [Admin::class, 'logout']);

$routes->get('/admin/add', [Admin::class,'displayCreatePage']);
$routes->post('/admin/add', [Admin::class,'handleCreate']);

$routes->get('/admin/edit/(:segment)', [Admin::class, 'displayEditPage']);
$routes->post('/admin/edit/(:segment)', [Admin::class, 'handleEdit']);

$routes->post('/admin/delete/(:segment)', [Admin::class,'handleDelete']);

$routes->get('/admin', [Admin::class, 'displayDashboardPage']);
$routes->get('/admin/articles/(:segment)', [Admin::class, 'displayArticlePage']);
$routes->get('/admin/(:segment)', [Admin::class, 'displayDashboardPage']);

/** 
* Articles section routes
*/
$routes->get('/', [Articles::class, 'viewPage']);
$routes->get('/articles', [Articles::class, 'viewPage']);

$routes->get('/(:segment)', [Articles::class, 'viewPage']);
$routes->get('/articles/(:segment)', [Articles::class, 'viewArticle']);
