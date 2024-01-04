<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Articles;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Articles::class, 'index']);
$routes->get('/articles/(:segment)', [Articles::class, 'viewArticle']);


$routes->get('/articles', [Articles::class, 'index']);
$routes->get('(:segment)', [Articles::class, 'view']);
