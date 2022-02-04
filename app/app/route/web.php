<?php 

use App\Router;


$router = new Router;
$router->get('/',                      ['class' => App\Controllers\UsersController::class,     'method' => 'index']);
$router->get('/404',                   ['class' => App\Controllers\ErrorPageController::class, 'method' => 'page_not_found']);
$router->get('/403',                   ['class' => App\Controllers\ErrorPageController::class, 'method' => 'access_forbidden']);
$router->get('/500',                   ['class' => App\Controllers\ErrorPageController::class, 'method' => 'server_error']);
$router->get('/register',              ['class' => App\Controllers\UsersController::class,     'method' => 'registration']);
$router->get('/forgotPassword',        ['class' => App\Controllers\UsersController::class,     'method' => 'password_forgot']);
$router->get('/user/confirm',          ['class' => App\Controllers\UsersController::class,     'method' => 'confirm']);
$router->get('/user/passwordChange',   ['class' => App\Controllers\UsersController::class,     'method' => 'password_change']);
$router->get('/user/logout',           ['class' => App\Controllers\UsersController::class,     'method' => 'logout']);
$router->post('/',                     ['class' => App\Controllers\UsersController::class,     'method' => 'login']);
$router->post('/register',             ['class' => App\Controllers\UsersController::class,     'method' => 'register']);
$router->post('/forgotPassword',       ['class' => App\Controllers\UsersController::class,     'method' => 'password_forgot']);
$router->post('/user/passwordChange',  ['class' => App\Controllers\UsersController::class,     'method' => 'password_change']);


$router->get('/posts',                 ['class' => App\Controllers\PostsController::class,     'method' => 'index']);
$router->get('/posts/search',          ['class' => App\Controllers\PostsController::class,     'method' => 'search']);
$router->get('/posts/page',            ['class' => App\Controllers\PostsController::class,     'method' => 'page']);
$router->get('/post/show',             ['class' => App\Controllers\PostsController::class,     'method' => 'show']);
$router->get('/posts/show',            ['class' => App\Controllers\PostsController::class,     'method' => 'my_posts']);
$router->get('/post/create',           ['class' => App\Controllers\PostsController::class,     'method' => 'create']);
$router->get('/post/edit',             ['class' => App\Controllers\PostsController::class,     'method' => 'edit']);
$router->post('/post/create',          ['class' => App\Controllers\PostsController::class,     'method' => 'store']);
$router->post('/post/update',          ['class' => App\Controllers\PostsController::class,     'method' => 'update']);
$router->post('/post/delete',          ['class' => App\Controllers\PostsController::class,     'method' => 'remove']);

$router->load();