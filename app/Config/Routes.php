<?php

namespace Config;

use App\Controllers\News;
use App\Controllers\Pages;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('dashboard', 'Home::index');

$routes->get('signup', 'Register::index');
$routes->post('register', 'Register::new');

$routes->get('signin', 'Login::index');
$routes->post('check-login', 'Login::checkLogin');
$routes->get('logout', 'Login::logout');

$routes->get('employee', 'Employee::index');
$routes->get('employee-add', 'Employee::add');
$routes->post('employee/store', 'Employee::createEmployee');
$routes->get('employee-edit', 'Employee::edit');
$routes->get('employee-detail', 'Employee::detailEmployee');
$routes->post('employee/update', 'Employee::updateEmployee');
$routes->post('employee/delete', 'Employee::deleteEmployee');

$routes->get('income', 'Income::index');
$routes->get('income/list', 'Income::list');
$routes->get('income-add', 'Income::add');
$routes->get('income-edit', 'Income::edit');
$routes->post('income/store', 'Income::store');
$routes->post('income/update', 'Income::update');
$routes->get('income-detail', 'Income::detail');
$routes->post('income/delete', 'Income::delete');
$routes->post('shop/add_option', 'Shop::createUnit');

$routes->get('product', 'Product::index');
$routes->get('product/list', 'Product::list');
$routes->get('product-add', 'Product::add');
$routes->post('product/store', 'Product::store');
$routes->get('product-edit', 'Product::edit');
$routes->post('product/update', 'Product::update');
$routes->get('product-detail', 'Product::detail');

$routes->get('customer', 'Customer::index');
$routes->get('customer/list', 'Customer::list');
$routes->get('customer-add', 'Customer::add');
$routes->post('customer/store', 'Customer::store');
$routes->get('customer-edit', 'Customer::edit');
$routes->post('customer/update', 'Customer::update');
$routes->get('customer-detail', 'Customer::detail');

$routes->get('order', 'Order::index');
$routes->get('order/list', 'Order::list');
$routes->get('order-add', 'Order::add');
$routes->post('order/store', 'Order::store');
$routes->get('order-edit', 'Order::edit');
$routes->post('order/update', 'Order::update');
$routes->get('order-detail', 'Order::detail');

$routes->group('news', function ($routes) {
    // $routes->match(['get', 'post'], 'create', [News::class, 'create']);

    $routes->get('create', [News::class, 'create']);
    $routes->post('store', [News::class, 'store']);

    $routes->post('delete', [News::class, 'delete']);

    $routes->get('(:segment)/edit', [News::class, 'edit']);
    $routes->post('update', [News::class, 'update']);

    $routes->get('(:segment)', [News::class, 'show']);
    $routes->get('', [News::class, 'index']);
});

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'show']);


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
