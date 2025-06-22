<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes
$routes->get('/', 'Home::index');
$routes->get('blog', 'Blog::index');
$routes->get('about', 'Home::about');
$routes->get('blog/post/(:segment)', 'Blog::post/$1');
$routes->get('blog/category/(:segment)', 'Blog::category/$1');

$routes->get('simple-login', 'SimpleAuth::login');
$routes->post('simple-login', 'SimpleAuth::login');
$routes->get('simple-logout', 'SimpleAuth::logout');

// Admin routes
$routes->group('admin', ['filter' => 'auth_check'], function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Posts routes
    $routes->get('posts', 'Admin\Posts::index');
    $routes->get('posts/create', 'Admin\Posts::create');
    $routes->post('posts/store', 'Admin\Posts::store');
    $routes->get('posts/edit/(:num)', 'Admin\Posts::edit/$1');
    $routes->post('posts/update/(:num)', 'Admin\Posts::update/$1');
    $routes->put('posts/update/(:num)', 'Admin\Posts::update/$1');
    $routes->post('posts/delete/(:num)', 'Admin\Posts::delete/$1');
    $routes->delete('posts/delete/(:num)', 'Admin\Posts::delete/$1');

    // Categories routes
    $routes->get('categories', 'Admin\Categories::index');
    $routes->get('categories/create', 'Admin\Categories::create');
    $routes->post('categories/store', 'Admin\Categories::store');
    $routes->get('categories/show/(:num)', 'Admin\Categories::show/$1');
    $routes->get('categories/edit/(:num)', 'Admin\Categories::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\Categories::update/$1');
    $routes->put('categories/update/(:num)', 'Admin\Categories::update/$1');
    $routes->post('categories/delete/(:num)', 'Admin\Categories::delete/$1');
    $routes->delete('categories/delete/(:num)', 'Admin\Categories::delete/$1');
});

// Test routes
$routes->get('test-login', 'TestLogin::index');