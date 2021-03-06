<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix'=>'users'],function ()use ($router){
    $router->post('/','UserController@store');
    $router->get('/','UserController@search');

});
$router->post('/login','UserController@login');
$router->group(['prefix'=>'chats','middleware' => 'api',],function ()use ($router){
    $router->post('/','ChatController@store');
    $router->get('/','ChatController@chatWithUser');
    $router->get('/manager','ChatController@index');
});
