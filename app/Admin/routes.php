<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('users', UserController::class);
    $router->resource('categories', CategoryController::class);
    $router->resource('pages', PageController::class);
    $router->resource('banners', BannerController::class);
    $router->resource('formality-levels', FormalityLevelController::class);
    $router->resource('formality-areas', FormalityAreaController::class);
    $router->resource('formality-ops', FormalityOpsController::class);
    $router->resource('formality-admins', FormalityAdminController::class);
    $router->resource('plans', PlanController::class);
    $router->resource('posts', PostController::class);
    $router->resource('picture', MediaController::class);
    $router->resource('customers', CustomerController::class);
});
