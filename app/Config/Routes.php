<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Articles;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Articles::class, 'viewPage']);
$routes->get('/articles', [Articles::class, 'viewPage']);
$routes->get('/(:segment)', [Articles::class, 'viewPage']);
$routes->get('/articles/(:segment)', [Articles::class, 'viewArticle']);
