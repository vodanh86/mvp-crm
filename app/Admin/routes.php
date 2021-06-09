<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/report', 'HomeController@report')->name('report');
    $router->get('/reportExp', 'ExpenditureController@report')->name('report');
    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('users', UserController::class);
    $router->resource('categories', CategoryController::class);
    $router->resource('appointments', AppointmentController::class);
    $router->resource('plans', PlanController::class);
    $router->resource('posts', PostController::class);
    $router->resource('picture', MediaController::class);
    $router->resource('customers', CustomerController::class);
    $router->resource('gfps', GfpController::class,['customer_id']);
    $router->resource('contracts', ContractController::class);
    $router->resource('checks', CheckController::class);
    $router->resource('expenditures', ExpenditureController::class);
    $router->resource('bills', BillController::class, ['contract_id']);
});
