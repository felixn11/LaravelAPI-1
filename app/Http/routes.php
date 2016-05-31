<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$api = app('Dingo\Api\Routing\Router');

$middleware = [ ];
if ( !App::runningUnitTests()){
    $middleware[] = 'jwt.auth';
}

$api->version('v1', ['middleware' => $middleware, 'prefix' => '/api/v1/'], function($api)
{
    $api->resource('blogs', 'App\Http\Controllers\BlogController');
});

$api->version('v1', ['middleware' => 'cors'], function ($api){
    $api->post('auth/login', 'App\Http\Controllers\AuthenticateController@login');
    $api->post('auth/signup', 'App\Http\Controllers\AuthenticateController@signup');
});

