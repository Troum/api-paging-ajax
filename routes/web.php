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
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('register', ['uses' => 'AuthController@register']);

    $router->post('login', ['uses' => 'AuthController@login']);

    $router->get('tiles', ['uses' => 'TilesController@index']);

    $router->get('tiles/{id}', ['uses' => 'TilesController@show']);

    $router->group(['middleware' => 'auth', 'prefix' => 'auth'], function () use ($router) {

        $router->post('tiles', ['uses' => 'TilesController@store']);

        $router->post('tiles', ['uses' => 'TilesController@store']);

        $router->get('tiles/{id}', ['uses' => 'TilesController@show']);

        $router->patch('tiles/{id}', ['uses' => 'TilesController@update']);

        $router->delete('tiles/{id}', ['uses' => 'TilesController@destroy']);

        $router->get('user', ['uses' => 'AuthController@user']);

        $router->get('logout', ['uses' => 'AuthController@logout']);
    });

});
