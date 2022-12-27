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

// Route::apiResource('pengeluaran', PengeluaranController::class);
$router->group(['prefix' => 'api/'], function () use ($router) {
    $router->get('pengeluaran', 'PengeluaranController@index');
    $router->post('pengeluaran', 'PengeluaranController@store');
    $router->get('pengeluaran/{id}', 'PengeluaranController@show');
    $router->put('pengeluaran/{id}', 'PengeluaranController@update');
    $router->delete('pengeluaran/{id}', 'PengeluaranController@destroy');
});
