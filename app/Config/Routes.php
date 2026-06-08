<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public routes
$routes->get('/', 'HomeController::index');
$routes->get('search', 'HomeController::search');
$routes->get('cari', 'HomeController::search');
$routes->get('properti/(:num)', 'PropertyController::detail/$1');
$routes->get('iklan-properti', 'AuthController::loginSeller');
$routes->get('jual-properti', 'AuthController::loginSeller');
$routes->get('turun-harga', 'HomeController::priceDrop');
$routes->get('kalkulator-harga', 'HomeController::calculator');
$routes->get('forum-properti', 'HomeController::community');
$routes->get('layanan-lainnya', 'HomeController::services');
$routes->get('langganan', 'SellerController::subscription');

// Auth routes
$routes->get('login', 'AuthController::loginBuyer');
$routes->post('login', 'AuthController::loginBuyer');
$routes->get('login/buyer', 'AuthController::loginBuyer');
$routes->post('login/buyer', 'AuthController::loginBuyer');
$routes->get('login/seller', 'AuthController::loginSeller');
$routes->post('login/seller', 'AuthController::loginSeller');
$routes->get('register', 'AuthController::registerBuyer');
$routes->post('register', 'AuthController::registerBuyer');
$routes->get('register/buyer', 'AuthController::registerBuyer');
$routes->post('register/buyer', 'AuthController::registerBuyer');
$routes->get('register/seller', 'AuthController::registerSeller');
$routes->post('register/seller', 'AuthController::registerSeller');
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

$routes->group('', ['filter' => 'buyer'], function ($routes) {
    $routes->get('dashboard/buyer', 'UserController::dashboard');
    $routes->get('favorit', 'UserController::favorites');
});

$routes->group('', ['filter' => 'seller'], function ($routes) {
    $routes->get('dashboard/seller', 'SellerController::dashboard');
});

// Seller routes (login + seller/admin)
$routes->group('seller', ['filter' => 'seller'], function ($routes) {
    $routes->get('dashboard', 'SellerController::dashboard');
    $routes->get('my-properties', 'SellerController::dashboard');
    $routes->get('dashboard/seller', 'SellerController::dashboard');
    $routes->get('properti/tambah', 'SellerController::create');
    $routes->post('properti/tambah', 'SellerController::create');
    $routes->get('create', 'SellerController::create');
    $routes->post('create', 'SellerController::create');
    $routes->get('properti/edit/(:num)', 'SellerController::edit/$1');
    $routes->post('properti/edit/(:num)', 'SellerController::edit/$1');
    $routes->delete('properti/(:num)', 'SellerController::delete/$1');
    $routes->get('delete/(:num)', 'SellerController::delete/$1');
    $routes->get('properties/new', 'SellerController::create');
    $routes->post('properties/new', 'SellerController::create');
    $routes->get('properties/edit/(:num)', 'SellerController::edit/$1');
    $routes->post('properties/edit/(:num)', 'SellerController::edit/$1');
    $routes->delete('properties/(:num)', 'SellerController::delete/$1');
});

// AJAX API routes
$routes->post('api/messages/send', 'UserController::sendMessage');
$routes->delete('api/images/(:num)', 'SellerController::deleteImage/$1');
