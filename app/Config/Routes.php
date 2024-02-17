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

$routes->get('/admin/add', [Admin::class,'displayAddPage']);
$routes->post('/admin/add', [Admin::class,'handleAdd']);

$routes->get('/admin/edit/(:segment)', [Admin::class, 'displayEditPage']);
$routes->post('/admin/edit/(:segment)', [Admin::class, 'handleEdit']);

$routes->post('/admin/delete/(:segment)', [Admin::class,'handleDelete']);

$routes->get('/admin', [Admin::class, 'displayDashboardPage']);
$routes->get('/admin/article/(:segment)', [Admin::class, 'displayArticlePage']);
$routes->get('/admin/page/(:segment)', [Admin::class, 'displayDashboardPage']);

/** 
* Articles section routes
*/
$routes->get('/', [Articles::class, 'viewPage']);

$routes->get('/page/(:segment)', [Articles::class, 'viewPage']);
$routes->get('/article/(:segment)', [Articles::class, 'viewArticle']);
