<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

// Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});
Router::post('/mail/getCode', 'App\Controller\MailController@getCode');
Router::post('/user/signup', 'App\Controller\UserController@signup');
Router::post('/user/login', 'App\Controller\UserController@login');
Router::addGroup('/auth', function () {
    Router::get('/user/test', 'App\Controller\UserController@test');
}, ['middleware' => [\App\Middleware\AuthMiddleware::class]]);