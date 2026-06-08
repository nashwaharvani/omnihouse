<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public routes
$routes->get('/', 'HomeController::index');
$routes->get('search', 'HomeController::search');
$routes->get('cari', 'HomeController::search');
$routes->get('properti/(:num)', 'PropertyController::detail/$1');
$routes->get('jual-properti', 'SellerController::sellInfo');
$routes->get('langganan', 'SellerController::subscription');
$routes->get('my-properties', 'SellerController::dashboard');

// Auth routes
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::register');
$routes->get('logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->post('notifications/mark-read/(:num)', 'NotificationsController::markRead/$1');
    $routes->post('notifications/mark-all-read', 'NotificationsController::markAllRead');
    $routes->post('notifications/delete/(:num)', 'NotificationsController::delete/$1');
});

// User routes (login required)
$routes->group('user', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'UserController::dashboard');
    $routes->get('profil', 'UserController::profile');
    $routes->post('profil', 'UserController::profile');
    $routes->get('inbox', 'UserController::inbox');
    $routes->get('chat/(:num)/(:num)', 'UserController::conversation/$1/$2');
});

// Seller routes (login + seller/admin)
$routes->group('seller', ['filter' => 'seller'], function ($routes) {
    $routes->get('dashboard', 'SellerController::dashboard');
    $routes->get('properti/tambah', 'SellerController::create');
    $routes->post('properti/tambah', 'SellerController::create');
    $routes->get('create', 'SellerController::create');
    $routes->post('create', 'SellerController::create');
    $routes->get('properti/edit/(:num)', 'SellerController::edit/$1');
    $routes->post('properti/edit/(:num)', 'SellerController::edit/$1');
    $routes->delete('properti/(:num)', 'SellerController::delete/$1');
    $routes->get('properties/new', 'SellerController::create');
    $routes->post('properties/new', 'SellerController::create');
    $routes->get('properties/edit/(:num)', 'SellerController::edit/$1');
    $routes->post('properties/edit/(:num)', 'SellerController::edit/$1');
    $routes->delete('properties/(:num)', 'SellerController::delete/$1');
});

// AJAX API routes
$routes->post('api/messages/send', 'UserController::sendMessage');
$routes->delete('api/images/(:num)', 'SellerController::deleteImage/$1');
